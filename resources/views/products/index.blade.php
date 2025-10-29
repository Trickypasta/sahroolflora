@extends('layouts.app')
@section('title', 'SahroolFlora - Produk Kami')

@section('content')
    <div x-data="{ filterOpen: false }" class="bg-white">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center pb-12">
                <h1 class="font-lora text-4xl font-bold text-gray-900">Semua Tanaman</h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">Jelajahi koleksi lengkap kami, dari yang mudah
                    dirawat hingga tanaman langka yang eksotis.</p>
            </div>

            {{-- SEMUA FILTER SEKARANG ADA DI DALAM SATU FORM --}}
            <form action="{{ route('products.index') }}" method="GET">
                <div class="flex items-center justify-between border-b border-gray-200 pb-6">
                    <h2 class="text-lg font-medium text-gray-900 hidden md:block">Filter</h2>

                    {{-- Tombol Filter Mobile --}}
                    <div class="md:hidden">
                        <button type="button" @click="filterOpen = !filterOpen"
                            class="inline-flex items-center p-2 border rounded-md text-gray-600">
                            <span>Filter</span>
                            <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>

                    {{-- Area Search & Sort --}}
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="search" name="search" placeholder="Cari tanaman..."
                                value="{{ request('search') }}"
                                class="text-sm border-gray-300 rounded-md pl-10 focus:ring-green-500 focus:border-green-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="hidden sm:flex items-baseline">
                            <label for="sort"
                                class="text-sm font-medium text-gray-700 sr-only sm:not-sr-only">Urutkan:</label>
                            <select id="sort" name="sort" onchange="this.form.submit()"
                                class="ml-2 text-sm border-gray-300 rounded-md">
                                <option value="latest" @selected(request('sort', 'latest') == 'latest')>Terbaru</option>
                                <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga: Termurah</option>
                                <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga: Termahal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <section class="pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-x-8 gap-y-10">
                        {{-- Sidebar Filter (Desktop) --}}
                        <aside class="hidden md:block">
                            <h4 class="font-semibold text-gray-900 mb-3">Kategori</h4>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('products.index', ['sort' => request('sort'), 'search' => request('search')]) }}"
                                        class="text-base transition {{ !request('category') ? 'font-bold text-green-700' : 'text-gray-600 hover:text-green-700' }}">
                                        Semua Kategori
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('products.index', ['category' => $category->slug, 'sort' => request('sort'), 'search' => request('search')]) }}"
                                            class="text-base transition {{ request('category') == $category->slug ? 'font-bold text-green-700' : 'text-gray-600 hover:text-green-700' }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>

                        {{-- Daftar Produk --}}
                        <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse ($products as $product)
                                <div class="group relative text-left">
                                    <div class="relative w-full h-80 overflow-hidden rounded-2xl bg-gray-100">
                                        <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
                                            alt="{{ $product->name }}"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        @if ($product->stock && $product->stock->quantity <= 0)
                                            <div
                                                class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-10 rounded-2xl">
                                                <span class="text-red-600 font-bold text-lg">Stok Habis</span>
                                            </div>
                                        @endif
                                        @include('partials.wishlist-button', ['product' => $product])
                                    </div>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-xl font-bold text-green-700">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-16">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">Produk tidak ditemukan</h3>
                                    <p class="mt-1 text-sm text-gray-500">Coba ubah kata kunci pencarian atau filter Anda.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </form>

            <div class="mt-12">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
