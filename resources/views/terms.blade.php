@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - SahroolFlora')

@section('content')

    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Syarat dan Ketentuan</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Harap baca dengan saksama sebelum menggunakan layanan
                kami.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-12">

            <aside class="lg:col-span-1 mb-12 lg:mb-0">
                <div class="lg:sticky lg:top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Isi</h2>
                    <nav>
                        <ul class="space-y-3 text-gray-600">
                            <li><a href="#akun-pengguna" class="hover:text-green-700 hover:underline">1. Akun Pengguna</a>
                            </li>
                            <li><a href="#pemesanan-produk" class="hover:text-green-700 hover:underline">2. Pemesanan dan
                                    Produk</a></li>
                            <li><a href="#harga-pembayaran" class="hover:text-green-700 hover:underline">3. Harga dan
                                    Pembayaran</a></li>
                            <li><a href="#pengiriman" class="hover:text-green-700 hover:underline">4. Pengiriman</a></li>
                            <li><a href="#pengembalian" class="hover:text-green-700 hover:underline">5. Pengembalian</a>
                            </li>
                            <li><a href="#kekayaan-intelektual" class="hover:text-green-700 hover:underline">6. Kekayaan
                                    Intelektual</a></li>
                            <li><a href="#perubahan-ketentuan" class="hover:text-green-700 hover:underline">7. Perubahan
                                    Ketentuan</a></li>
                            <li><a href="#kontak" class="hover:text-green-700 hover:underline">8. Hubungi Kami</a></li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <div class="lg:col-span-3 text-gray-700 space-y-10">
                <div class="lg:col-span-3 text-gray-700 space-y-10">
                    {{-- Kita gunakan nl2br agar enter di textarea admin berfungsi --}}
                    {!! nl2br(
                        e($settings['legal_terms'] ?? 'Konten Syarat dan Ketentuan belum diisi. Silakan isi melalui panel admin.'),
                    ) !!}
                </div>

                <p class="mt-8 text-sm text-gray-500"><em>Terakhir diperbarui: 7 Oktober 2025</em></p>
            </div>
        </div>
    </div>

@endsection
