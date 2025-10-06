<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil role yang sudah ada
        $adminRole = Role::where('name', 'admin')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // 2. Buat User Admin
        $adminUser = User::create([
            'name' => 'Admin Fawwaz',
            'email' => 'admin@example.test',
            'password' => Hash::make('password'),
        ]);
        $adminUser->roles()->attach($adminRole);

        // 3. Buat User Customer
        $customerUser = User::create([
            'name' => 'Wira Pelanggan',
            'email' => 'wira@example.test',
            'password' => Hash::make('password'),
        ]);
        $customerUser->roles()->attach($customerRole);
    }
}