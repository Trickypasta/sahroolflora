<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk dengan filter dan sorting.
     */
    public function index(Request $request): View
    {
        // Ambil semua kategori untuk filter
        $categories = Category::latest()->get();

        // Mulai membangun query produk
        $query = Product::query()->with('images');

        // Filter berdasarkan Kategori
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Logika untuk Urutkan (Sort)
        switch ($request->input('sort', 'latest')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Eksekusi query dengan paginasi
        $products = $query->paginate(12)->withQueryString();

        // ==========================================================
        // PERBAIKAN 1: Logika Wishlist Disederhanakan
        // ==========================================================
        $wishlistProductIds = [];
        if (Auth::check()) {
            // Gunakan relasi 'wishlist' yang sudah ada di model User
            $wishlistProductIds = Auth::user()->wishlist()->pluck('product_id')->flip()->toArray();
        }
        
        return view('products.index', compact('products', 'categories', 'wishlistProductIds'));
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(Product $product): View
    {
        $product->load('images', 'stock', 'categories');

        // ==========================================================
        // PERBAIKAN 2: Tambahkan Logika Wishlist di Sini Juga
        // ==========================================================
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Auth::user()->wishlist()->pluck('product_id')->flip()->toArray();
        }

        // Kirim variabel 'product' DAN 'wishlistProductIds' ke view
        return view('products.show', compact('product', 'wishlistProductIds'));
    }
}