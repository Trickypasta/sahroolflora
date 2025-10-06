<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong untuk checkout.');
        }

        $shippingMethods = ShippingMethod::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $discount = 0;
        if (session()->has('coupon')) {
            $coupon = session('coupon');
            if ($coupon['type'] == 'fixed') {
                $discount = $coupon['value'];
            } else {
                $discount = ($subtotal * $coupon['percent_off']) / 100;
            }
        }

        $totalAfterDiscount = $subtotal - $discount;
        if ($totalAfterDiscount < 0) {
            $totalAfterDiscount = 0;
        }

        return view('checkout.index', compact('cart', 'shippingMethods', 'paymentMethods', 'subtotal', 'discount', 'totalAfterDiscount'));
    }

    /**
     * Memproses pesanan dari form checkout.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $cart = Auth::user()->cart;
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong.');
        }

        // --- Perhitungan ulang di backend ---
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $shippingMethod = ShippingMethod::find($request->shipping_method_id);
        $shippingCost = $shippingMethod->cost;

        $total = $subtotal + $shippingCost;

        if (session()->has('coupon')) {
            $coupon = session('coupon');
            $discount = ($coupon['type'] == 'fixed') ? $coupon['value'] : ($subtotal * $coupon['percent_off']) / 100;
            $total -= $discount;
        }

        if ($total < 0) {
            $total = 0;
        }

        $paymentMethod = PaymentMethod::find($request->payment_method_id);

        // 1. Simpan alamat
        $address = Address::create([
            'user_id' => Auth::id(),
            'address_line' => $request->address_line,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
        ]);

        // 2. Buat pesanan (order)
        $newOrder = Order::create([
            'user_id' => Auth::id(),
            'shipping_address_id' => $address->id,
            'total_amount' => $total,
            'shipping_method' => $shippingMethod->name,
            'shipping_cost' => $shippingCost,
            'payment_method' => $paymentMethod->name,
            'status' => 'pending',
        ]);

        // 3. Pindahkan item & kurangi stok
        foreach ($cart->items as $item) {
            $newOrder->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->stock->decrement('quantity', $item->quantity);
        }

        // 4. Hapus keranjang & session kupon
        $cart->delete();
        session()->forget('coupon');

        // 5. Arahkan ke halaman detail pesanan
        return redirect()->route('orders.show', $newOrder);
    }
}
