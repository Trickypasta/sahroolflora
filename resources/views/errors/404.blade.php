@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan (404)')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto text-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            {{-- Teks Error --}}
            <p class="mt-6 text-2xl font-lora font-bold text-green-700">404</p>
            <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Oops! Sepertinya Anda Tersesat.</h1>
            <p class="mt-4 text-base text-gray-600">Halaman yang Anda cari mungkin sudah dipindahkan, dihapus, atau memang tidak pernah ada.</p>
            
            {{-- Tombol Aksi --}}
            <div class="mt-8 flex justify-center space-x-4">
                <a href="{{ route('home') }}" 
                   class="inline-block bg-green-700 text-white font-bold py-3 px-8 rounded-full hover:bg-green-800">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('products.index') }}" 
                   class="inline-block bg-transparent border border-gray-400 text-gray-800 font-bold py-3 px-8 rounded-full hover:bg-gray-100">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection