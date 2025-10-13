@extends('layouts.app')

@section('title', 'Ulasan Pelanggan - SahroolFlora')

@section('content')

    <div class="bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Ulasan Pelanggan</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Lihat apa kata mereka tentang produk kami.</p>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 sm:py-24 px-4 sm:px-6 lg:px-8">

            <form action="{{ route('testimonials.index') }}" method="GET" class="mb-12">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-gray-700">Filter Rating:</span>
                        <a href="{{ route('testimonials.index', ['sort' => request('sort')]) }}"
                            class="px-3 py-1 text-sm rounded-full {{ !request('rating') ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">Semua</a>
                        @for ($i = 5; $i >= 1; $i--)
                            <a href="{{ route('testimonials.index', ['rating' => $i, 'sort' => request('sort')]) }}"
                                class="px-3 py-1 text-sm rounded-full flex items-center {{ request('rating') == $i ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                                {{ $i }} ★
                            </a>
                        @endfor
                    </div>
                    <div>
                        <select name="sort" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-md">
                            <option value="latest" @selected(request('sort', 'latest') == 'latest')>Urutkan: Terbaru</option>
                            <option value="oldest" @selected(request('sort') == 'oldest')>Urutkan: Terlama</option>
                            <option value="highest_rating" @selected(request('sort') == 'highest_rating')>Rating Tertinggi</option>
                            <option value="lowest_rating" @selected(request('sort') == 'lowest_rating')>Rating Terendah</option>
                        </select>
                        {{-- Simpan filter rating saat sorting --}}
                        <input type="hidden" name="rating" value="{{ request('rating') }}">
                    </div>
                </div>
            </form>

            @if ($testimonials->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                        @if ($product = $testimonial->product)
                            <div class="border border-gray-200 rounded-lg p-6 flex flex-col">
                                <div class="flex items-start mb-4">
                                    <a href="{{ route('products.show', $product->slug) }}" class="flex-shrink-0">
                                        <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/100' }}"
                                            alt="{{ $product->name }}" class="h-16 w-16 object-cover rounded-md">
                                    </a>
                                    <div class="ml-4">
                                        <a href="{{ route('products.show', $product->slug) }}"
                                            class="font-semibold text-gray-900 hover:text-green-700">{{ $product->name }}</a>
                                        <div class="flex items-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-4 w-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                                @if ($testimonial->comment)
                                    <p class="text-gray-600 italic flex-grow">"{{ $testimonial->comment }}"</p>
                                @else
                                    <p class="text-gray-400 italic flex-grow">(Tanpa Komentar)</p>
                                @endif

                                <div class="flex items-center mt-6 pt-4 border-t border-gray-200">
                                    <div
                                        class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-800 text-xs">
                                        {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-semibold text-gray-900">{{ $testimonial->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $testimonial->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="ml-auto text-xs text-green-600 flex items-center">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Pembelian Terverifikasi</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-16">{{ $testimonials->links() }}</div>
            @else
                <div class="text-center bg-gray-50 rounded-lg py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-800">Belum Ada Ulasan</h2>
                    <p class="mt-2 text-gray-600">Jadilah yang pertama memberikan ulasan untuk produk kami!</p>
                </div>
            @endif
        </div>
    </div>
@endsection
