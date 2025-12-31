<header x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <div class="lg:hidden mr-2">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none">
                        <span class="sr-only">Buka menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

                <a href="{{ route('home') }}"
                    class="font-bold text-2xl text-gray-800 tracking-tight flex items-center gap-2">
                    <span class="text-green-600">🌿</span>
                    SahroolFlora
                </a>
            </div>

            <div class="hidden lg:flex flex-1 justify-center items-center space-x-8">
                <a href="{{ route('products.index') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('products.*') ? 'text-green-600 font-semibold' : '' }}">Produk</a>
                <a href="{{ route('posts.index') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('posts.*') ? 'text-green-600 font-semibold' : '' }}">Blog</a>
                <a href="{{ route('promos.index') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('promos.*') ? 'text-green-600 font-semibold' : '' }}">Promo</a>
                <a href="{{ route('testimonials.index') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('testimonials.*') ? 'text-green-600 font-semibold' : '' }}">Testimoni</a>
                <a href="{{ route('about') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('about') ? 'text-green-600 font-semibold' : '' }}">Tentang
                    Kami</a>
                <a href="{{ route('contact.show') }}"
                    class="text-l font-medium text-gray-600 hover:text-green-600 transition-colors {{ request()->routeIs('contact.*') ? 'text-green-600 font-semibold' : '' }}">Kontak</a>
            </div>

            <div class="flex items-center space-x-4">
                <a href="{{ route('wishlist.index') }}"
                    class="hidden sm:block text-gray-400 hover:text-red-500 transition-colors" title="Wishlist">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 21.5l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                </a>

                <a href="{{ route('cart.index') }}"
                    class="relative text-gray-400 hover:text-green-600 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    @if (isset($cartCount) && $cartCount > 0)
                        <span
                            class="absolute -top-1.5 -right-1.5 bg-green-600 text-white text-[10px] font-bold rounded-full h-4 w-4 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @guest
                    <div class="hidden sm:flex items-center space-x-2">
                        <a href="{{ route('login') }}"
                            class="text-l font-medium text-gray-600 hover:text-green-600 px-3 py-2">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="bg-green-600 hover:bg-green-700 text-white text-l font-medium px-4 py-2 rounded-full transition-colors shadow-sm">Daftar</a>
                    </div>
                @endguest

                @auth
                    <div class="relative hidden sm:block">
                        <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" type="button"
                            class="flex items-center space-x-1 text-gray-700 hover:text-green-600 focus:outline-none">
                            <span class="text-l font-semibold max-w-[100px] truncate">Hi,
                                {{ Str::words(auth()->user()->name, 1, '') }}</span>
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 py-1 z-50 origin-top-right"
                            x-cloak>

                            @if (auth()->user()->roles()->where('name', 'admin')->exists())
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-sm text-green-600 font-semibold hover:bg-green-50 border-b border-gray-100">
                                    🚀 Admin Panel
                                </a>
                            @endif

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Akun Saya</a>
                            <a href="{{ route('orders.index') }}"
                                class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <span>Pesanan Saya</span>
                                @if (isset($orderCount) && $orderCount > 0)
                                    <span
                                        class="bg-red-100 text-red-600 text-xs font-bold px-1.5 py-0.5 rounded-full">{{ $orderCount }}</span>
                                @endif
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="lg:hidden pb-4" x-cloak>
            <div class="pt-2 pb-3 space-y-1">
                @foreach ([['Produk', 'products.index'], ['Blog', 'posts.index'], ['Promo', 'promos.index'], ['Testimoni', 'testimonials.index'], ['Tentang Kami', 'about'], ['Kontak', 'contact.show']] as $menu)
                    <a href="{{ route($menu[1]) }}"
                        class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs($menu[1] . '*') ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800' }} text-base font-medium transition duration-150 ease-in-out">
                        {{ $menu[0] }}
                    </a>
                @endforeach
            </div>

            <div class="pt-4 pb-3 border-t border-gray-200">
                @auth
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div
                                class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-lg">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('orders.index') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Pesanan Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-red-50">Log Out</button>
                        </form>
                    </div>
                @else
                    <div class="mt-3 space-y-1 px-4">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md text-base font-medium text-gray-700 bg-white hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-4 py-2 border border-transparent rounded-md text-base font-medium text-white bg-green-600 hover:bg-green-700 mt-2">Daftar
                            Sekarang</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>
