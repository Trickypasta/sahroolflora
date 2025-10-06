<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected $userModel;
    
    function __construct(User $userModel)
    {
        // Hanya user yang sudah login yang bisa mengakses metode di controller ini
        $this->userModel = $userModel;
    }
    
    /**
     * Menampilkan halaman katalog produk dengan filter dan sorting.
     */
    public function index(Request $request): View
    {
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
                $query->latest(); // Default: terbaru
                break;
        }

        // Eksekusi query dengan paginasi
        $products = $query->paginate(12)->withQueryString();

        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->flip()->toArray();
        }
        
        
        // Ambil semua kategori untuk filter
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories', 'wishlistProductIds'));
    }

    /**
     * Menampilkan halaman detail satu produk.
     */
    public function show(Product $product): View
    {
        $product->load('images', 'stock');
        return view('products.show', compact('product'));
    }
}