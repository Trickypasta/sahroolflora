<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::user()->cart()->with('items.product.images')->first();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        // 1. Validasi input quantity dari form
        $requestedQuantity = (int) $request->input('quantity', 1); // Ambil quantity dari form
        if ($requestedQuantity <= 0) {
            return redirect()->back()->with('error', 'Jumlah tidak valid.');
        }

        // 2. Load relasi stock & ambil stok terbaru dari DB
        $product->load('stock');
        $currentStock = $product->stock ? $product->stock->quantity : 0;

        // 3. Cek apakah stoknya 0 dari awal
        if ($currentStock <= 0) {
            return redirect()->back()->with('error', 'Stok produk telah habis!');
        }

        // 4. Ambil cart user
        $cart = Auth::user()->cart()->firstOrCreate();

        // 5. Cek apakah produk sudah ada di cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        // 6. Hitung total quantity yang AKAN ada di cart
        $newTotalQuantity = $requestedQuantity;
        if ($cartItem) {
            // Jika sudah ada, tambahkan dengan quantity yang ada di cart
            $newTotalQuantity = $cartItem->quantity + $requestedQuantity;
        }

        // 7. Validasi UTAMA: Cek total quantity vs stok
        if ($newTotalQuantity > $currentStock) {
            // Jika stok tidak cukup, kirim pesan error
            return redirect()->back()->with('error', "Stok tidak mencukupi. Sisa stok: $currentStock");
        }

        // 8. Lolos validasi: Tambah/Update item ke cart
        if ($cartItem) {
            // Update quantity yang sudah ada
            $cartItem->update(['quantity' => $newTotalQuantity]);
        } else {
            // Buat item baru di cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $requestedQuantity
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $requestedQuantity = (int) $request->quantity;

        $cartItem->load('product.stock');
        $currentStock = $cartItem->product->stock ? $cartItem->product->stock->quantity : 0;

        if ($requestedQuantity > $currentStock) {
            return redirect()->back()->with('error', "Stok tidak mencukupi. Sisa stok: $currentStock");
        }
    
        if ($requestedQuantity > 0) {
            $cartItem->update(['quantity' => $requestedQuantity]);
        } else {

            $cartItem->delete();
        }

        return redirect()->route('cart.index');
    }

    public function remove(CartItem $cartItem)
    {
        // Pastikan item ini milik user yang sedang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }
        $cartItem->delete();
        return redirect()->route('cart.index');
    }
}
