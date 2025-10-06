<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk ditampilkan sebagai produk pilihan
        $featuredProducts = Product::with('images')->latest()->take(4)->get();

        // Ambil 3 kategori
        $categories = Category::latest()->take(3)->get();

        // Ambil 2 postingan blog terbaru
        $latestPosts = Post::whereNotNull('published_at')->latest()->take(2)->get();

        return view('welcome', compact('featuredProducts', 'categories', 'latestPosts'));
    }
}
