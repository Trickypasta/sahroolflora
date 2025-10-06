<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan ini PENTING!
        // Role harus ada dulu sebelum User dibuat.
        // Kategori harus ada dulu sebelum Produk dibuat.
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}