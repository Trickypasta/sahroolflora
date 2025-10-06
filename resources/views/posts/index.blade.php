@extends('layouts.app')

@section('title', 'Blog - SahroolFlora')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <!-- Header Halaman -->
        <div class="text-center pb-12">
            <h1 class="font-lora text-4xl md:text-5xl font-bold text-gray-900">Jurnal Tanaman</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-500">Panduan, tips, dan inspirasi untuk membantu perjalanan Anda merawat tanaman.</p>
        </div>

        @if ($posts->isNotEmpty())
            <!-- Artikel Unggulan -->
            @php $featuredPost = $posts->first(); @endphp
            <div class="mb-16 group">
                <a href="{{ route('posts.show', $featuredPost->slug) }}" class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div class="overflow-hidden rounded-lg">
                        <img src="{{ $featuredPost->image ? asset('storage/' . $featuredPost->image) : 'https://via.placeholder.com/800x600.png?text=SahroolFlora' }}" alt="{{ $featuredPost->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-green-700 uppercase">Artikel Terbaru</p>
                        <h2 class="mt-2 font-lora text-3xl md:text-4xl font-bold text-gray-900 group-hover:text-green-800 transition">
                            {{ $featuredPost->title }}
                        </h2>
                        <p class="mt-4 text-lg text-gray-600">
                            {{ Str::limit(strip_tags($featuredPost->body), 200) }}
                        </p>
                        <span class="mt-6 inline-block font-semibold text-green-700 group-hover:underline">
                            Baca Selengkapnya &rarr;
                        </span>
                    </div>
                </a>
            </div>

            <!-- Grid Artikel Lainnya -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
                @foreach ($posts->skip(1) as $post)
                <div class="group">
                    <a href="{{ route('posts.show', $post->slug) }}">
                        <div class="overflow-hidden rounded-lg aspect-[4/3] bg-gray-100">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://via.placeholder.com/400x300.png?text=SahroolFlora' }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-900 group-hover:text-green-700 transition">
                                {{ $post->title }}
                            </h3>
                            <p class="mt-2 text-gray-600">
                                {{ Str::limit(strip_tags($post->body), 100) }}
                            </p>
                            <span class="mt-4 inline-block font-semibold text-sm text-green-700 group-hover:underline">
                                Baca Selengkapnya
                            </span>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $posts->links() }}
            </div>

        @else
            <div class="text-center py-16">
                <p class="text-gray-600 text-lg">Belum ada artikel yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</div>
@endsection