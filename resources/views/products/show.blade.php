@extends('layouts.app')

@section('title', $product->name . ' - SahroolFlora')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            
            <div x-data="{ mainImage: '{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/600' }}' }">
                <div class="aspect-square w-full overflow-hidden rounded-lg bg-gray-100">
                    <img :src="mainImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="mt-4 grid grid-cols-5 gap-4">
                    @foreach ($product->images as $image)
                    <button @click="mainImage = '{{ asset('storage/' . $image->path) }}'" class="aspect-square w-full rounded-md overflow-hidden focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="sticky top-24">
                <h1 class="font-lora text-3xl md:text-4xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="mt-3 text-3xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

                <div class="mt-6">
                    <span class="font-semibold text-gray-800">Stok:</span>
                    @if($product->stock && $product->stock->quantity > 0)
                        <span class="ml-2 text-green-600 font-bold">Tersedia</span>
                    @else
                        <span class="ml-2 text-red-600 font-bold">Habis</span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-8" x-data="{ quantity: 1 }">
                    @csrf
                    <div class="flex items-center mb-6">
                        <label for="quantity" class="font-semibold text-gray-800 mr-4">Kuantitas:</label>
                        <div class="flex items-center border border-gray-300 rounded-md">
                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 text-gray-500 hover:bg-gray-100">-</button>
                            <input type="text" name="quantity" x-model="quantity" class="w-12 text-center border-l border-r border-gray-300" readonly>
                            <button type="button" @click="quantity++" class="px-3 py-2 text-gray-500 hover:bg-gray-100">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-700 text-white font-bold py-4 px-6 rounded-full hover:bg-green-800 transition-colors duration-300 text-lg">
                        Tambah ke Keranjang
                    </button>
                </form>

                <div class="mt-10 border-t border-gray-200">
                    <div x-data="{ open: true }" class="border-b border-gray-200 py-6">
                        <h3>
                            <button @click="open = !open" class="flex items-center justify-between w-full text-left text-gray-600">
                                <span class="font-semibold text-lg">Deskripsi</span>
                                <span x-text="open ? '-' : '+'" class="text-xl"></span>
                            </button>
                        </h3>
                        <div x-show="open" x-collapse class="pt-4 text-gray-500 prose">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    <div x-data="{ open: false }" class="border-b border-gray-200 py-6">
                        <h3>
                            <button @click="open = !open" class="flex items-center justify-between w-full text-left text-gray-600">
                                <span class="font-semibold text-lg">Panduan Perawatan</span>
                                <span x-text="open ? '-' : '+'" class="text-xl"></span>
                            </button>
                        </h3>
                        <div x-show="open" x-collapse class="pt-4 text-gray-500">
                            {{-- Anda bisa menambahkan data spesifik perawatan di sini --}}
                            <p>Informasi perawatan akan ditampilkan di sini.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection