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

                // 🆕 Versi 3.x: pakai read() bukan make()
                $image = Image::read($imagefile)
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80) // konversi ke webp
                    ->save(storage_path('app/public/' . $path)); // simpan ke storage

                // Simpan path ke database
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index');
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

        // ... (logika slug unik lu biarin aja) ...
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        // Update data teks produk
        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'care_guide' => $request->care_guide,
            'price' => $request->price,
        ]);

        // Update relasi
        $product->categories()->sync($request->categories ?? []);
        $product->stock()->update(['quantity' => $request->stock]);

        // ===========================================
        // LOGIKA UPDATE GAMBAR (REVISI DI SINI)
        // ===========================================
        if ($request->hasFile('images')) {

            // 1. Hapus semua gambar lama dari folder 'storage'
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->path);
            }

            // 2. Hapus SEMUA relasi gambar lama dari database
            $product->images()->delete();

            // 3. Upload dan proses gambar baru (logika sama persis kayak di fungsi store())
            foreach ($request->file('images') as $imagefile) {
                $filename = Str::slug($request->name) . '-' . Str::random(5) . time() . '.webp';
                $path = 'products/' . $filename;

                // Proses dan simpan
                Image::read($imagefile)
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(80)
                    ->save(storage_path('app/public/' . $path)); // Simpan ke storage

                // 4. Buat relasi gambar baru di database
                $product->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.products.index');
    }

    // DELETE
    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
