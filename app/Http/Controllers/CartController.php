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
        $cart = Auth::user()->cart()->firstOrCreate();

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        // Pastikan item ini milik user yang sedang login
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403, 'Aksi tidak diizinkan.');
        }

        if ($request->quantity > 0) {
            $cartItem->update(['quantity' => $request->quantity]);
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