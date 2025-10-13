<header x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="flex items-center">
                <div class="lg:hidden mr-4">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-md text-gray-500 hover:text-gray-700">
                        <span class="sr-only">Buka menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

                <a href="{{ route('home') }}" class="font-bold text-2xl text-gray-800">
                    SahroolFlora
                </a>

                <div class="hidden lg:ml-10 lg:flex lg:space-x-8">
                    <a href="{{ route('products.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Produk</a>
                    <a href="{{ route('posts.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Blog</a>
                    <a href="{{ route('about') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Tentang Kami</a>
                    <a href="{{ route('contact.show') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Kontak</a>
                    <a href="{{ route('testimonials.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Testimoni</a>
                    <a href="{{ route('promos.index') }}"
                        class="text-sm font-medium text-gray-600 hover:text-green-700">Promo</a>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                {{-- Wishlist (Disembunyikan di layar paling kecil) --}}
                <a href="{{ route('wishlist.index') }}" class="hidden sm:block text-gray-500 hover:text-green-700">
                    <span class="sr-only">Wishlist</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                </a>

                {{-- Keranjang (Selalu tampil) --}}
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-green-700">
                    <span class="sr-only">Keranjang</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                    @endif
                </a>

                @guest
                    <a href="{{ route('login') }}"
                        class="hidden sm:block text-sm font-medium text-gray-600 hover:text-green-700">Login</a>
                    <a href="{{ route('register') }}"
                        class="hidden sm:block bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">Register</a>
                @endguest

                @auth
                    {{-- Menu User (Disembunyikan di layar paling kecil) --}}
                    <div class="relative hidden sm:block">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" type="button"
                            class="flex items-center space-x-1 text-gray-800 hover:text-green-700">
                            <span class="text-sm font-medium">Hi, {{ Str::words(auth()->user()->name, 1, '') }}</span>
                            <svg class="h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="userMenuOpen" x-transition
                            class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 origin-top-right"
                            x-cloak>
                            @if (auth()->user()->roles()->where('name', 'admin')->exists())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Akun Saya</a>
                            <a href="{{ route('orders.index') }}"
                                class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span>Pesanan Saya</span>
                                @if (isset($orderCount) && $orderCount > 0)
                                    <span
                                        class="bg-green-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ $orderCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('orders.track.form') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lacak Pesanan</a>
                            <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="lg:hidden" x-cloak>
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('products.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Produk</a>
                <a href="{{ route('posts.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Blog</a>
                <a href="{{ route('about') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Tentang
                    Kami</a>
                <a href="{{ route('contact.show') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Kontak</a>
                <a href="{{ route('testimonials.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Testimoni</a>
                <a href="{{ route('promos.index') }}"
                    class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Promo</a>
            </div>
            {{-- Menu User di Mobile --}}
            <div class="pt-4 pb-3 border-t border-gray-200">
                @auth
                    <a href="{{ route('profile.edit') }}"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Akun
                        Saya</a>
                    <a href="{{ route('wishlist.index') }}"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Wishlist</a>
                    <form action="{{ route('logout') }}" method="POST"> @csrf <button type="submit"
                            class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Login</a>
                    <a href="{{ route('register') }}"
                        class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:bg-gray-50 hover:border-green-500 hover:text-gray-800">Register</a>
                @endauth
            </div>
        </div>
    </nav>
</header>
