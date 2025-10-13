<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <-- 1. Tambahkan ini untuk Transaction

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('items.product.images')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong untuk checkout.');
        }

        $shippingMethods = ShippingMethod::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $addresses = $user->addresses()->latest()->get();

        $subtotal = $cart->items->reduce(function ($carry, $item) {
            return $carry + ($item->product->price * $item->quantity);
        }, 0);

        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] == 'fixed') {
                $discount = $coupon['value'];
            } else {
                $discount = ($subtotal * $coupon['percent_off']) / 100;
            }
        }

        $totalAfterDiscount = max(0, $subtotal - $discount);

        return view('checkout.index', compact('cart', 'shippingMethods', 'paymentMethods', 'subtotal', 'discount', 'totalAfterDiscount', 'addresses'));
    }

    /**
     * Memproses pesanan dari form checkout.
     */
    public function store(Request $request)
{
    // 1. Validasi semua input terlebih dahulu
    $request->validate([
        'address_option' => 'required|string',
        'shipping_method_id' => 'required|exists:shipping_methods,id',
        'payment_method_id' => 'required|exists:payment_methods,id',
        'address_line' => 'required_if:address_option,new|nullable|string|max:255',
        'city' => 'required_if:address_option,new|nullable|string|max:100',
        'province' => 'required_if:address_option,new|nullable|string|max:100',
        'postal_code' => 'required_if:address_option,new|nullable|string|max:10',
    ]);

    $user = Auth::user();
    // Eager load relasi yang dibutuhkan untuk kalkulasi
    $cart = $user->cart()->with('items.product.stock')->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong.');
    }

    // 2. Lakukan semua kalkulasi di backend SEBELUM menyimpan ke database
    $subtotal = $cart->items->reduce(fn($carry, $item) => $carry + ($item->product->price * $item->quantity), 0);
    
    $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
    $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
    $shippingCost = $shippingMethod->cost;
    
    $discount = 0;
    $couponCode = null;
    if (session()->has('coupon')) {
        $coupon = session('coupon');
        $couponCode = $coupon['code'];
        $discount = ($coupon['type'] == 'fixed') ? $coupon['value'] : ($subtotal * $coupon['percent_off']) / 100;
    }

    $totalAmount = max(0, $subtotal - $discount + $shippingCost);

    // 3. Gunakan Database Transaction untuk keamanan data
    $order = null;
    try {
        DB::beginTransaction();

        // Tentukan ID Alamat
        $addressId = null;
        if ($request->address_option === 'new') {
            $address = $user->addresses()->create($request->only(['address_line', 'city', 'province', 'postal_code']));
            $addressId = $address->id;
        } else {
            $chosenAddress = $user->addresses()->findOrFail($request->address_option);
            $addressId = $chosenAddress->id;
        }

        // Buat Pesanan dengan semua data yang sudah final
        $order = Order::create([
            'user_id' => $user->id,
            'shipping_address_id' => $addressId,
            'subtotal' => $subtotal,
            'shipping_method' => $shippingMethod->name,
            'shipping_cost' => $shippingCost,
            'discount' => $discount,
            'coupon_code' => $couponCode, // Simpan kode kupon yang dipakai
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod->name,
            'status' => 'pending',
        ]);

        // Pindahkan item dari keranjang ke pesanan & kurangi stok
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            
            if ($item->product->stock) {
                $item->product->stock->decrement('quantity', $item->quantity);
            }
        }

        // Hapus keranjang & session kupon
        $cart->items()->delete();
        $cart->delete();
        session()->forget('coupon');

        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        // Log::error('Checkout failed: ' . $e->getMessage()); // Opsional untuk debugging
        return back()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
    }

    return redirect()->route('orders.show', $order)->with('success', 'Pesanan Anda berhasil dibuat!');
}
}