<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori yang sudah ada
        $indoorCategory = Category::where('slug', 'tanaman-indoor')->first();
        $outdoorCategory = Category::where('slug', 'tanaman-outdoor')->first();

        // Produk 1: Monstera
        $product1 = Product::create([
            'name' => 'Monstera Deliciosa',
            'slug' => Str::slug('Monstera Deliciosa'),
            'description' => 'Tanaman hias populer dengan daunnya yang unik dan berlubang.',
            'price' => 150000,
        ]);
        $product1->stock()->create(['quantity' => 20]);
        $product1->images()->create(['path' => 'placeholders/monstera.jpg']);
        $product1->categories()->attach($indoorCategory);

        // Produk 2: Aglaonema
        $product2 = Product::create([
            'name' => 'Aglaonema Red',
            'slug' => Str::slug('Aglaonema Red'),
            'description' => 'Dikenal sebagai Sri Rejeki, tanaman ini memiliki corak daun merah yang menawan.',
            'price' => 125000,
        ]);
        $product2->stock()->create(['quantity' => 30]);
        $product2->images()->create(['path' => 'placeholders/aglaonema.jpg']);
        $product2->categories()->attach($outdoorCategory);
    }
}