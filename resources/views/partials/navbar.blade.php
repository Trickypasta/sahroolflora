<header x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 flex justify-center md:justify-start">
                <a href="{{ route('home') }}" class="font-bold text-2xl text-gray-800">SahroolFlora</a>
            </div>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('products.index') }}" class="text-gray-600 hover:text-green-700 transition">Produk</a>
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-green-700 transition">Blog</a>
                <a href="{{ route('about') }}" class="text-gray-600 hover:text-green-700 transition">Tentang Kami</a>
                <a href="{{ route('contact.show') }}" class="text-gray-600 hover:text-green-700 transition">Kontak</a>
            </div>

            <div class="flex-1 flex justify-end items-center space-x-4">
                <a href="{{ route('wishlist.index') }}" class="text-gray-500 hover:text-green-700 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                </a>
                <a href="{{ route('cart.index') }}" class="relative text-gray-500 hover:text-green-700 transition">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>

                @guest
                    <a href="{{ route('login') }}" class="hidden sm:block text-gray-600 hover:text-green-700 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">Register</a>
                @endguest

                @auth
                    <div class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" type="button" class="flex items-center space-x-2 text-gray-800 hover:text-green-700">
                            <span>Hi, {{ Str::limit(auth()->user()->name, 20) }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userMenuOpen" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50">
                             @if (auth()->user()->roles()->where('name', 'admin')->exists())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100">Admin Dashboard</a>
                            @endif
                            <a href="{{ route('orders.index') }}" class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <span>Pesanan Saya</span>
                                @if (isset($orderCount) && $orderCount > 0)
                                    <span class="bg-green-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $orderCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan Akun</a>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" class="md:hidden pb-4">
            <a href="{{ route('products.index') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Produk</a>
            <a href="{{ route('posts.index') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Blog</a>
            <a href="{{ route('about') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Tentang Kami</a>
            <a href="{{ route('contact.show') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Kontak</a>
            <hr class="my-2">
            <a href="{{ route('testimonials.index') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Testimoni</a>
            <a href="{{ route('orders.track.form') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Lacak Pesanan</a>
            <a href="{{ route('coupons.index') }}" class="block py-2 px-4 text-gray-600 hover:bg-gray-100 rounded">Promo</a>
        </div>
    </nav>
</header>