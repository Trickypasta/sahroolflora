@extends('layouts.app')

@section('title', 'Pengaturan Akun - SahroolFlora')

@section('content')

    <!-- Header Halaman -->
    <div class="bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="font-lora text-3xl font-extrabold tracking-tight text-gray-900">Akun Saya</h1>
        </div>
    </div>

    <!-- Konten Utama (Layout 2 Kolom) -->
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <!-- Kolom Kiri: Navigasi Akun (Sidebar) -->
            <aside class="md:col-span-1">
                @include('partials.account-sidebar')
            </aside>

            <!-- Kolom Kanan: Konten Form -->
            <div class="md:col-span-3">
                <!-- Form Update Profil -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900">Update Profil</h2>
                    <p class="mt-1 text-sm text-gray-500">Pastikan informasi Anda sudah benar dan terkini.</p>

                    <form action="{{ route('profile.update') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div class="text-right">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-green-700 hover:bg-green-800">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>

                <hr class="my-8">

                <!-- Form Ubah Password -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900">Ubah Password</h2>
                    <p class="mt-1 text-sm text-gray-500">Gunakan password yang kuat dan unik untuk keamanan akun Anda.</p>

                    <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat
                                Ini</label>
                            <input type="password" name="current_password" id="current_password" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                            <input type="password" name="password" id="password" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                                Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        </div>
                        <div class="text-right">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-full text-white bg-green-700 hover:bg-green-800">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
