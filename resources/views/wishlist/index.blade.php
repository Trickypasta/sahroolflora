@extends('layouts.app')

@section('title', 'Wishlist Saya - SahroolFlora')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="text-center pb-12">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Wishlist Saya</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Daftar produk favorit yang Anda simpan.</p>
        </div>

        {{-- INI BAGIAN KUNCINYA: Cek apakah wishlist tidak kosong --}}
        @if ($wishlistItems->isNotEmpty())
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Loop setiap produk di dalam wishlist --}}
                @foreach ($wishlistItems as $product)
                    <div class="group relative text-left">
                        <div class="relative w-full h-96 overflow-hidden rounded-lg bg-gray-100">
                            <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
                                 alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            
                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 w-11/12 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-white text-gray-800 font-semibold py-3 px-4 rounded-full shadow-md hover:bg-gray-200 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                            {{-- Kita panggil partial yang sudah kita buat agar konsisten --}}
                            @include('partials.wishlist-button', ['product' => $product])
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            
            <div class="text-center py-16 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z"></path></svg>
                <h2 class="mt-4 text-xl font-semibold text-gray-800">Wishlist Anda masih kosong</h2>
                <p class="mt-2 text-gray-600">Simpan produk favorit Anda dengan menekan ikon hati.</p>
                <a href="{{ route('products.index') }}"
                   class="mt-6 inline-block bg-green-700 text-white font-bold py-3 px-8 rounded-full hover:bg-green-800">
                    Jelajahi Produk
                </a>
            </div>

        @endif
    </div>
</div>
@endsection