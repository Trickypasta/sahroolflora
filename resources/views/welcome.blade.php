@extends('layouts.app')

@section('title', 'SahroolFlora - Bawa Alam ke Rumah Anda')

@section('content')

    <section class="relative h-[70vh] md:h-[85vh] bg-cover bg-center text-white flex items-center justify-center text-center"
        style="background-image: url('https://images.unsplash.com/photo-1592234854932-eff059ff506a?q=80&w=2070');">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative z-10 max-w-3xl mx-auto px-4">
            <h1 class="font-lora text-4xl md:text-6xl font-bold leading-tight">Bawa Keindahan Alam ke Dalam Rumah</h1>
            <p class="mt-4 text-lg md:text-xl max-w-xl mx-auto">Temukan koleksi tanaman hias terbaik untuk setiap sudut
                ruangan, dirawat langsung oleh petani lokal.</p>
            <a href="{{ route('products.index') }}"
                class="mt-8 inline-block bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300 shadow-lg text-lg">
                Jelajahi Koleksi
            </a>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Belanja Sesuai Kebutuhan</h2>
            <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto">Dari yang ramah hewan peliharaan hingga yang cocok
                untuk pemula, kami punya semuanya.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
                @forelse($categories as $category)
                    {{-- Perbaikan: Link kategori sekarang berfungsi --}}
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="block group">
                        <div class="aspect-square w-full overflow-hidden rounded-full bg-gray-200">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/400x400.png?text=' . $category->name }}"
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-gray-800 group-hover:text-green-700 transition-colors">
                            {{ $category->name }}</h3>
                    </a>
                @empty
                    <p class="col-span-full text-gray-500">Kategori belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Produk Terlaris</h2>
                <p class="mt-4 text-lg text-gray-600">Tanaman yang paling dicintai oleh pelanggan kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredProducts as $product)
                    <div class="group relative text-left">
                        <div class="relative w-full h-96 overflow-hidden rounded-lg bg-gray-100">
                            <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

                            {{-- Perbaikan: Form Add to Cart --}}
                            <div
                                class="absolute bottom-4 left-1/2 -translate-x-1/2 w-11/12 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full bg-white text-gray-800 font-semibold py-3 px-4 rounded-full shadow-md hover:bg-gray-200 transition">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>

                            {{-- Perbaikan: Kode Tombol Hati yang Benar --}}
                            @include('partials.wishlist-button', ['product' => $product])

                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-xl font-bold text-gray-900">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-gray-500 text-center">Produk pilihan belum tersedia.</p>
                @endforelse
            </div>

            <div class="text-center mt-16">
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300 shadow-lg text-lg">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="md:order-last">
                    <img src="https://images.unsplash.com/photo-1521334884684-d80222895322?q=80&w=2070" alt="Plant care"
                        class="rounded-lg shadow-lg aspect-[4/3] object-cover">
                </div>
                <div class="text-left">
                    <h2 class="font-lora text-3xl md:text-4xl font-bold mb-4 text-gray-800">Perawatan Jadi Mudah</h2>
                    <p class="text-lg text-gray-600 mb-8">Kunjungi blog kami untuk membaca tips dan trik dari para ahli agar
                        tanamanmu tumbuh subur dan bahagia.</p>
                    <div class="space-y-4">
                        @foreach ($latestPosts as $post)
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="group block border-t border-gray-300 py-4">
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-xl font-semibold text-gray-800 group-hover:text-green-700 transition">{{ $post->title }}</span>
                                    <span
                                        class="text-gray-400 group-hover:text-green-700 transition transform group-hover:translate-x-2">&rarr;</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('posts.index') }}"
                        class="mt-8 inline-block text-green-700 font-semibold hover:underline">
                        Baca Artikel Lainnya
                    </a>
                </div>
            </div>
        </div>

    </section>
    <hr>
@endsection
