<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman wishlist.
     */
    public function index()
    {
        // Ambil produk dari relasi wishlist user yang sedang login
        $wishlistItems = Auth::user()->wishlist()->with('images')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Menambah atau menghapus produk dari wishlist.
     */
    public function toggle(Product $product)
    {
        // Gunakan method toggle() dari Laravel, lebih simpel dan efisien
        Auth::user()->wishlist()->toggle($product->id);
        
        return back()->with('success', 'Status wishlist diperbarui!');
    }
}
