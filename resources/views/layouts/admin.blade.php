<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SahroolFlora</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-100 font-sans antialiased" x-data="{ sidebarOpen: false, notificationOpen: false, profileOpen: false }">
    @php
        $navItems = [
            // General
            ['route' => 'admin.dashboard', 'name' => 'Dashboard', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>'],
            ['route' => 'admin.analytics.index', 'name' => 'Analitik', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" /></svg>'],
            // Sales
            ['route' => 'admin.orders.index', 'name' => 'Pesanan', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>'],
            // ['route' => 'admin.payments.verify', 'name' => 'Verifikasi Pembayaran', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>'],
            ['route' => 'admin.returns.index', 'name' => 'Pengembalian', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" /></svg>'],
            // Catalog
            ['route' => 'admin.products.index', 'name' => 'Produk', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4z" clip-rule="evenodd" /></svg>'],
            ['route' => 'admin.stocks.index', 'name' => 'Stok', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" /></svg>'],
            ['route' => 'admin.categories.index', 'name' => 'Kategori', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" /></svg>'],
            // Content
            ['route' => 'admin.posts.index', 'name' => 'Blog', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 16c1.255 0 2.443-.29 3.5-.804V4.804zM14.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 0114.5 16c1.255 0 2.443-.29 3.5-.804v-10A7.968 7.968 0 0014.5 4z" /></svg>'],
            ['route' => 'admin.testimonials.index', 'name' => 'Testimoni', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" /><path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h1a2 2 0 002-2V9a2 2 0 00-2-2h-1z" /></svg>'],
            // Customers
            ['route' => 'admin.users.index', 'name' => 'Pengguna', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>'],
            ['route' => 'admin.messages.index', 'name' => 'Pesan Masuk', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>'],
            // Marketing
            ['route' => 'admin.coupons.index', 'name' => 'Kupon', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 5a3 3 0 013-3h8a3 3 0 013 3v8a3 3 0 01-3 3H8a3 3 0 01-3-3V5zm3 0a1 1 0 00-1 1v8a1 1 0 001 1h8a1 1 0 001-1V6a1 1 0 00-1-1H8z" clip-rule="evenodd" /></svg>'],
            // Settings
            ['route' => 'admin.expenses.index', 'name' => 'Pengeluaran', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M8.433 7.418c.158-.103.346-.195.574-.277a6.98 6.98 0 011.022-.107c.328.002.657.028.976.076.319.047.63.119.926.217.297.099.577.22.84.365.264.145.504.31.717.495a1 1 0 101.22-1.582A8.94 8.94 0 0013.5 5.694a8.963 8.963 0 00-1.544-.46A8.97 8.97 0 0010 5c-.682 0-1.35.074-1.994.22-1.28.28-2.427.786-3.42 1.472a1 1 0 101.087 1.718z" /><path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" /><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12z" /></svg>'],
            ['route' => 'admin.shipping-methods.index', 'name' => 'Pengiriman', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" /><path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v5.05a2.5 2.5 0 014.9 0H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z" /></svg>'],
            ['route' => 'admin.payment-methods.index', 'name' => 'Metode Bayar', 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>'],
        ];
    @endphp

    <div class="relative min-h-screen md:flex">
        <!-- Mobile menu backdrop -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-30 w-64 transform bg-slate-800 text-slate-300 transition-transform duration-300 md:relative md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            x-cloak
        >
            <!-- Logo -->
            <div class="flex h-16 items-center justify-center px-4">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white hover:text-slate-200">SahroolFlora</a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-1 overflow-y-auto px-2 pb-4">
                @foreach ($navItems as $item)
                    @php
                        // Handle routes that might not exist yet gracefully
                        $routeExists = Route::has($item['route']);
                        $href = $routeExists ? route($item['route']) : '#';
                        $isActive = $routeExists ? Route::is(str_replace('.index', '.*', $item['route'])) : false;
                    @endphp
                    <a href="{{ $href }}"
                        class="flex items-center rounded-md px-3 py-2.5 text-sm font-medium transition-colors duration-200
                               {{ $isActive ? 'bg-slate-900 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                        <span class="mr-3 w-5">{!! $item['icon'] !!}</span>
                        <span>{{ $item['name'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <!-- Main content -->
        <div class="flex flex-1 flex-col">
            <!-- Top bar -->
            <header class="sticky top-0 z-10 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6 lg:px-8">
                <!-- Hamburger button -->
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-600 md:hidden">
                    <span class="sr-only">Buka sidebar</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <!-- Spacer to push icons to the right -->
                <div class="flex-1"></div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications dropdown -->
                    <div class="relative">
                        <button @click="notificationOpen = !notificationOpen; profileOpen = false" class="relative rounded-full p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="sr-only">Lihat notifikasi</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if (isset($notifications) && $notifications->isNotEmpty())
                                <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex h-3 w-3 rounded-full bg-red-500"></span></span>
                            @endif
                        </button>
                        <div x-show="notificationOpen" @click.outside="notificationOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-80 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-cloak>
                            <div class="py-1">
                                <div class="border-b border-slate-200 px-4 py-2">
                                    <p class="font-semibold text-slate-700">Notifikasi</p>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    @forelse($notifications ?? [] as $notification)
                                        <a href="{{ route('admin.orders.show', $notification->id) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-100">
                                            <p class="font-medium">Pesanan Baru #{{ $notification->id }}</p>
                                            <p class="text-xs text-slate-500">dari {{ $notification->user->name }}</p>
                                        </a>
                                    @empty
                                        <p class="px-4 py-3 text-sm text-slate-500">Tidak ada notifikasi baru.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile dropdown -->
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen; notificationOpen = false" class="flex items-center space-x-2 rounded-full p-1 text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="sr-only">Buka menu user</span>
                            <span class="hidden text-sm font-medium text-slate-700 sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                        <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" x-cloak>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">Pengaturan Akun</a>
                            <div class="border-t border-slate-100"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
