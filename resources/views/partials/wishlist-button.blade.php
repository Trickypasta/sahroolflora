
@auth
    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-3 right-3 z-10">
        @csrf
        <button type="submit" class="p-2 bg-white rounded-full shadow-md hover:bg-gray-100 transition"
            aria-label="Toggle Wishlist">

            {{-- Cek apakah ID produk ini ada di dalam array $wishlistProductIds --}}
            @if (isset($wishlistProductIds[$product->id]))
                <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z">
                    </path>
                </svg>
            @else
                <svg class="w-6 h-6 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z">
                    </path>
                </svg>
            @endif

        </button>
    </form>
@endauth
