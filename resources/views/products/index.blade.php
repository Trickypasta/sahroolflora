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

        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6">
            <h2 class="text-lg font-medium text-gray-900">Filter</h2>

            <div class="flex items-center">
                {{-- Tombol Filter Mobile --}}
                <div class="md:hidden">
                    <button type="button" @click="filterOpen = !filterOpen"
                        class="inline-flex items-center p-2 border rounded-md text-gray-600">
                        <span>Filter</span>
                        <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
                    </button>
                </div>

                {{-- Dropdown Urutkan (Desktop) --}}
                <div class="hidden md:flex items-baseline space-x-4">
                     <form action="{{ route('products.index') }}" method="GET" id="sort-form">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <label for="sort" class="text-sm font-medium text-gray-700">Urutkan:</label>
                        <select id="sort" name="sort" onchange="document.getElementById('sort-form').submit()" class="text-sm border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                            <option value="latest" @selected(request('sort', 'latest') == 'latest')>Terbaru</option>
                            <option value="price_asc" @selected(request('sort') == 'price_asc')>Harga: Termurah</option>
                            <option value="price_desc" @selected(request('sort') == 'price_desc')>Harga: Termahal</option>
                        </select>
                    </form>
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
                            <a href="{{ route('products.index', ['sort' => request('sort')]) }}"
                                class="text-base transition {{ !request('category') ? 'font-bold text-green-700' : 'text-gray-600 hover:text-green-700' }}">
                                Semua Kategori
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->slug, 'sort' => request('sort')]) }}"
                                    class="text-base transition {{ request('category') == $category->slug ? 'font-bold text-green-700' : 'text-gray-600 hover:text-green-700' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                {{-- Filter Overlay (Mobile) - Tidak perlu diubah --}}
                <div x-show="filterOpen" @click.away="filterOpen = false" class="fixed inset-0 bg-black bg-opacity-25 z-40 md:hidden" x-cloak></div>
                <aside x-show="filterOpen" x-transition class="fixed top-0 right-0 h-full w-80 bg-white shadow-xl z-50 p-6 md:hidden" x-cloak>
                    {{-- ... kode filter mobile ... --}}
                </aside>

                {{-- Daftar Produk --}}
                <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($products as $product)
                        <div class="group relative text-left">
                            <div class="relative w-full h-80 overflow-hidden rounded-lg bg-gray-100">
                                <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                
                                {{-- Perbaikan: Kode Tombol Hati yang Benar --}}
                                @include('partials.wishlist-button', ['product' => $product, 'wishlistProductIds' => $wishlistProductIds])

                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <a href="{{ route('products.show', 'slug') }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500 py-16">Produk tidak ditemukan dengan
                            filter ini.</p>
                    @endforelse
                </div>
            </div>
        </section>
        
        <div class="mt-12">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection