<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- 1. TAMBAHKAN INI

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk ditampilkan sebagai produk pilihan
        $featuredProducts = Product::with('images')->latest()->take(4)->get();

        // Ambil 4 kategori (saya naikkan jadi 4 agar pas dengan layout)
        $categories = Category::latest()->take(4)->get();

        // Ambil 2 postingan blog terbaru
        $latestPosts = Post::whereNotNull('published_at')->latest()->take(2)->get();
        
        // 2. LOGIKA UNTUK MENGAMBIL WISHLIST
        $wishlistProductIds = []; // Inisialisasi sebagai array kosong\
        if (Auth::check()) { // Cek dulu apakah user sudah login
            // Ambil SEMUA ID produk yang ada di wishlist user
            // pluck() -> hanya ambil kolom 'product_id'
            // flip()  -> ubah array [1, 5, 12] menjadi [1 => 0, 5 => 1, 12 => 2]
            //            Ini bikin pengecekan di view nanti jadi super cepat.
            $wishlistProductIds = Auth::user()->wishlist()->pluck('product_id')->flip()->toArray();
        }

        // 3. KIRIM SEMUA DATA KE VIEW, TERMASUK WISHLIST
        return view('welcome', compact(
            'featuredProducts', 
            'categories', 
            'latestPosts', 
            'wishlistProductIds' // <-- Tambahkan ini
        ));
    }
}