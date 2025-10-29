@extends('layouts.app')

@section('title', 'SahroolFlora - Bawa Alam ke Rumah Anda')

@section('content')

    {{-- 1. Hero Section --}}
    <section class="relative h-[80vh] bg-cover bg-center text-white overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=2874');">
        {{-- Overlay yang lebih soft --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

        <div class="relative z-10 h-full flex flex-col justify-end max-w-7xl mx-auto p-8 md:p-12">
            <div class="max-w-2xl">
                <h1 class="font-lora text-4xl md:text-6xl font-bold text-white leading-tight drop-shadow-md" data-aos="fade-right">
                    Bawa Keindahan Alam ke Dalam Rumah
                </h1>
                <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-xl drop-shadow" data-aos="fade-right" data-aos-delay="300">
                    Temukan koleksi tanaman hias terbaik untuk setiap sudut ruangan, dirawat langsung oleh petani lokal.
                </p>
                <a href="{{ route('products.index') }}"
                    class="mt-8 inline-block bg-white/20 backdrop-blur-sm border border-white/50 text-white font-bold py-3 px-8 rounded-full transition hover:bg-white hover:text-green-800 shadow-lg text-lg" data-aos="fade-right" data-aos-delay="400">
                    Jelajahi Koleksi
                </a>
            </div>
        </div>
    </section>

    {{-- 2. Kategori Pilihan --}}
    <section class="py-16 sm:py-24 bg-[#F8F7F3] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center"  data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Belanja Sesuai Kebutuhan</h2>
            <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto">Dari yang ramah hewan peliharaan hingga yang cocok
                untuk pemula, kami punya semuanya.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 " data-aos="fade-up">
                @forelse($categories as $category)
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

    {{-- 3. Produk Terlaris --}}
    <section class="py-16 sm:py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="100">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Produk Terlaris</h2>
                <p class="mt-4 text-lg text-gray-600">Tanaman yang paling dicintai oleh pelanggan kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($featuredProducts as $product)
                    <div class="group relative text-left">
                        <div class="relative w-full h-96 overflow-hidden rounded-3xl bg-gray-100">
                            <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

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
                    <p class="col-span-full text-gray-500 text-center">Produk pilihan belum tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. Keunggulan Toko (BAGIAN BARU) --}}
    <section class="py-16 sm:py-24 bg-[#F8F7F3] overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"  data-aos="fade-up">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Kenapa Belanja di SahroolFlora?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div data-aos="fade-up" data-aos-delay="100"
                        class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100 text-green-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold" data-aos="fade-up" data-aos-delay="100">Dukung Petani Lokal</h3>
                    <p class="mt-1 text-gray-600" data-aos="fade-up" data-aos-delay="100">Setiap pembelian Anda membantu perekonomian petani tanaman hias lokal.</p>
                </div>
                <div>
                    <div data-aos="fade-up" data-aos-delay="200"
                        class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100 text-green-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold" data-aos="fade-up" data-aos-delay="200">Garansi Tiba Sehat</h3>
                    <p class="mt-1 text-gray-600" data-aos="fade-up" data-aos-delay="200">Kami pastikan tanaman sampai ke tangan Anda dalam kondisi terbaik.</p>
                </div>
                <div>
                    <div data-aos="fade-up" data-aos-delay="300"
                        class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-green-100 text-green-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0011.667 0l3.182-3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold" data-aos="fade-up" data-aos-delay="300">Pengiriman Aman</h3>
                    <p class="mt-1 text-gray-600" data-aos="fade-up" data-aos-delay="300">Dikemas dengan hati-hati untuk melindungi setiap daun dan batang.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. Blog/Artikel Pilihan --}}
    <section class="py-16 sm:py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="md:order-last " data-aos="fade-left" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1521334884684-d80222895322?q=80&w=2070" alt="Plant care"
                        class="rounded-3xl shadow-lg aspect-[4/3] object-cover">
                </div>
                <div class="text-left">
                    <h2 class="font-lora text-3xl md:text-4xl font-bold mb-4 text-gray-800" data-aos="fade-right">Dari Jurnal Tanaman Kami</h2>
                    <p class="text-lg text-gray-600 mb-8" data-aos="fade-right">Baca tips dan trik dari para ahli agar tanamanmu tumbuh subur dan
                        bahagia.</p>
                    <div class="space-y-4" data-aos="fade-right">
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
                        class="mt-8 inline-block text-green-700 font-semibold hover:underline" data-aos="fade-right">
                        Baca Artikel Lainnya
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
