<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishlist Saya - SahroolFlora</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    @include('partials.navbar')
    @include('partials.notification')

    <main class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-center mb-8">Wishlist Saya</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($wishlistItems as $item)
                    @php
                        // Bikin variabel biar gampang manggilnya
                        $product = $item->product;
                    @endphp

                    {{-- Cek dulu kalau produknya masih ada (tidak dihapus) --}}
                    @if($product)
                    <div class="group bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden relative">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->path) : 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}" class="w-full h-56 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 truncate">{{ $product->name }}</h3>
                                <p class="mt-2 text-xl font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </a>

                        {{-- Tombol Hati untuk Unlike dari halaman Wishlist --}}
                        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            <button type="submit" class="p-2 bg-white rounded-full shadow">
                                {{-- Hati akan selalu merah di halaman wishlist --}}
                                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                @empty
                    <div class="col-span-full text-center py-16">
                        <h3 class="text-xl font-semibold text-gray-700">Wishlist Anda Kosong</h3>
                        <p class="text-gray-500 mt-2">Ayo mulai tambahkan produk favoritmu dengan menekan ikon hati!</p>
                        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Jelajahi Produk</a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>