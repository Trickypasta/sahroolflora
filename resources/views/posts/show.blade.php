@extends('layouts.app')

@section('title', $post->title . ' - SahroolFlora')

@section('content')
<div class="bg-white pt-8 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <div class="mb-8 text-sm text-gray-500">
            <a href="{{ route('posts.index') }}" class="hover:text-green-700">Blog</a>
            <span class="mx-2">&rsaquo;</span>
            <span>{{ $post->title }}</span>
        </div>

        <!-- Header Artikel -->
        <div class="text-center">
            <h1 class="font-lora text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">{{ $post->title }}</h1>
            <div class="mt-6 text-gray-500">
                <span>Ditulis oleh {{ $post->user->name }}</span> &bull;
                <span>{{ optional($post->published_at)->format('d F Y') }}</span>
            </div>
        </div>

        <!-- Gambar Utama -->
        <div class="my-10 overflow-hidden rounded-lg aspect-video bg-gray-100">
            <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://via.placeholder.com/1200x675.png?text=SahroolFlora' }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>

        <!-- Konten Artikel -->
        <div class="prose prose-lg max-w-none">
            {!! $post->body !!}
        </div>

    </div>
</div>
@endsection