<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl text-gray-800">SahroolFlora Admin</a>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-blue-500">Manajemen Kategori</a>
                <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-blue-500">Manajemen Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="text-gray-600 hover:text-blue-500">Manajemen Order</a>
                <a href="{{ route('admin.posts.index') }}" class="text-gray-600 hover:text-blue-500">Blog</a>
                <a href="{{ route('admin.messages.index') }}" class="text-gray-600 hover:text-blue-500">Pesan Masuk</a>
                <a href="{{ route('admin.testimonials.index') }}" class="text-gray-600 hover:text-blue-500">Testimoni</a>

            </div>
            <div class="flex items-center">
                <span class="text-gray-700 font-semibold flex items-center pr-4">
                    Halo, {{ Auth::user()->name ?? 'Admin' }}!
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-700 hover:text-red-200">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>