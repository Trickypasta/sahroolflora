@extends('layouts.app')

@section('title', 'Kebijakan Privasi - SahroolFlora')

@section('content')

    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Kebijakan Privasi</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Kami berkomitmen untuk melindungi privasi data Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-x-12">

            <aside class="lg:col-span-1 mb-12 lg:mb-0">
                <div class="lg:sticky lg:top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Daftar Isi</h2>
                    <nav>
                        <ul class="space-y-3 text-gray-600">
                            <li><a href="#informasi-yang-dikumpulkan" class="hover:text-green-700 hover:underline">1.
                                    Informasi yang Kami Kumpulkan</a></li>
                            <li><a href="#penggunaan-informasi" class="hover:text-green-700 hover:underline">2. Penggunaan
                                    Informasi</a></li>
                            <li><a href="#keamanan-data" class="hover:text-green-700 hover:underline">3. Keamanan Data</a>
                            </li>
                            <li><a href="#cookie" class="hover:text-green-700 hover:underline">4. Penggunaan Cookie</a></li>
                            <li><a href="#hak-anda" class="hover:text-green-700 hover:underline">5. Hak Anda</a></li>
                            <li><a href="#perubahan-kebijakan" class="hover:text-green-700 hover:underline">6. Perubahan
                                    Kebijakan</a></li>
                            <li><a href="#kontak" class="hover:text-green-700 hover:underline">7. Hubungi Kami</a></li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <div class="lg:col-span-3 text-gray-700 space-y-10">
                <div class="lg:col-span-3 text-gray-700 space-y-10">
                    {!! nl2br(
                        e($settings['legal_privacy'] ?? 'Konten Kebijakan Privasi belum diisi. Silakan isi melalui panel admin.'),
                    ) !!}
                </div>

                <p class="mt-8 text-sm text-gray-500"><em>Terakhir diperbarui: 7 Oktober 2025</em></p>
            </div>
        </div>
    </div>

@endsection
