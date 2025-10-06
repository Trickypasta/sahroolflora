<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // READ: Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::with('stock', 'images')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // CREATE (Part 1): Menampilkan form tambah produk
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // CREATE (Part 2): Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $product->categories()->sync($request->categories);
        $product->stock()->create(['quantity' => $request->stock]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
        
        return redirect()->route('admin.products.index');
    }

    // UPDATE (Part 1): Menampilkan halaman form edit
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // UPDATE (Part 2): Memproses data dari form edit
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id, // <-- INI VERSI BARU
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
        ]);

        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        $product->categories()->sync($request->categories);
        $product->stock()->update(['quantity' => $request->stock]);

        return redirect()->route('admin.products.index');
    }

    // DELETE: Menghapus data produk
    public function destroy(Product $product)
    {
        // Hapus gambar-gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        // Hapus data dari database (otomatis menghapus relasi)
        $product->delete();
        
        return redirect()->route('admin.products.index');
    }
}