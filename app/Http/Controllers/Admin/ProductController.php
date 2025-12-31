<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    // READ: Menampilkan daftar semua produk
    public function index()
    {
        $products = Product::with('stock', 'images')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // CREATE (Part 1)
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // CREATE (Part 2): Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
            'description' => 'nullable|string',
            'care_guide' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072'
        ]);

        // Slug unik
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Buat produk
        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'care_guide' => $request->care_guide,
            'price' => $request->price,
        ]);

        $product->categories()->sync($request->categories);
        $product->stock()->create(['quantity' => $request->stock]);

        // Upload gambar (pakai Image v3)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $filename = Str::slug($request->name) . '-' . Str::random(5) . time() . '.webp';
                $path = 'products/' . $filename;

                // 👇 FIX: Tentukan Full Path
                $fullPath = storage_path('app/public/' . $path);

                // 👇 FIX: Cek apakah folder 'storage/app/public/products' ada? Kalau ga ada, BIKIN!
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                // Proses resize & save
                Image::read($imagefile)
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80)
                    ->save($fullPath); // Simpan ke path yang udah pasti ada foldernya

                // Simpan path relative ke database
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // UPDATE (Part 1)
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // UPDATE (Part 2)
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'categories' => 'required|array',
            'description' => 'nullable|string',
            'care_guide' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072'
        ]);

        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'care_guide' => $request->care_guide,
            'price' => $request->price,
        ]);

        $product->categories()->sync($request->categories ?? []);
        $product->stock()->update(['quantity' => $request->stock]);

        if ($request->hasFile('images')) {
            // Hapus gambar lama
            foreach ($product->images as $oldImage) {
                if (Storage::disk('public')->exists($oldImage->path)) {
                    Storage::disk('public')->delete($oldImage->path);
                }
            }
            $product->images()->delete();

            // Upload gambar baru
            foreach ($request->file('images') as $imagefile) {
                $filename = Str::slug($request->name) . '-' . Str::random(5) . time() . '.webp';
                $path = 'products/' . $filename;
                $fullPath = storage_path('app/public/' . $path);

                // 👇 FIX: Cek folder lagi disini juga
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                Image::read($imagefile)
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80)
                    ->save($fullPath);

                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Product $product)
    {
        try {
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image->path)) {
                    Storage::disk('public')->delete($image->path);
                }
            }
            $product->images()->delete();
            $product->stock()->delete();
            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
