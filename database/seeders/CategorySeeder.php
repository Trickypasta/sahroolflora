<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Tanaman Indoor',
            'slug' => Str::slug('Tanaman Indoor'),
        ]);
        Category::create([
            'name' => 'Tanaman Outdoor',
            'slug' => Str::slug('Tanaman Outdoor'),
        ]);
    }
}