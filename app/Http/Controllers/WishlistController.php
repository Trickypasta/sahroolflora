<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('product.images')->get();
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        $wishlistItem = Auth::user()->wishlistItems()->where('product_id', $product->id)->first();

        if ($wishlistItem) {
            // Jika sudah ada, hapus (unlike)
            $wishlistItem->delete();
            return back()->with('success', 'Produk dihapus dari wishlist.');
        } else {
            // Jika belum ada, tambahkan (like)
            Auth::user()->wishlistItems()->create(['product_id' => $product->id]);
            return back()->with('success', 'Produk ditambahkan ke wishlist!');
        }
    }
}