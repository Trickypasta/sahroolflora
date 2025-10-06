<footer class="bg-[#F8F7F3] text-gray-800">
    <div class="max-w-7xl mx-auto pt-16 pb-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
            
            <div>
                <h3 class="font-semibold text-gray-900 tracking-wide">Layanan Pelanggan</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('faq') }}" class="text-base text-gray-500 hover:text-gray-900 transition">FAQ</a></li>
                    <li><a href="{{ route('contact.show') }}" class="text-base text-gray-500 hover:text-gray-900 transition">Kontak Kami</a></li>
                    <li><a href="{{ route('orders.track.form') }}" class="text-base text-gray-500 hover:text-gray-900 transition">Lacak Pesanan</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 tracking-wide">Konten</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('posts.index') }}" class="text-base text-gray-500 hover:text-gray-900 transition">Blog</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-base text-gray-500 hover:text-gray-900 transition">Semua Produk</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-semibold text-gray-900 tracking-wide">Tentang Kami</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('about') }}" class="text-base text-gray-500 hover:text-gray-900 transition">Cerita Kami</a></li>
    
                </ul>
            </div>

            <div class="col-span-2 pt-8 md:pt-0">
                <h3 class="font-lora text-3xl font-bold text-gray-900">Get The Dirt.</h3>
                <p class="mt-2 text-base text-gray-500">Dapatkan tips, penawaran eksklusif, & diskon 10% untuk pesanan pertama Anda.</p>
                <form action="#" method="POST" class="mt-4 flex flex-col sm:flex-row items-center">
                    @csrf
                    <input type="email" name="email" required class="w-full px-4 py-3 text-base text-gray-900 bg-white border border-gray-300 rounded-md focus:ring-green-700 focus:border-green-700" placeholder="Enter your email here ...">
                    <button type="submit" class="mt-3 sm:mt-0 sm:ml-3 w-full sm:w-auto px-6 py-3 bg-green-700 text-white font-semibold rounded-md hover:bg-green-800 transition">
                        Subscribe
                    </button>
                </form>
                <div class="mt-6 flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">[Icon Instagram]</a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">[Icon Facebook]</a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">[Icon TikTok]</a>
                    <a href="https://shopee.co.id/sahroolflora_?entryPoint=ShopBySearch&searchKeyword=sahroolflora" class="text-gray-400 hover:text-gray-500">Shopee</a>
                </div>
            </div>
        </div>

        <div class="mt-12 border-t border-gray-200 pt-8 flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center text-4xl font-lora font-bold text-gray-800">
                <span>SahroolFlora</span>
            </div>
            <p class="text-sm text-gray-400 mt-4 md:mt-0">Copyright {{ date('Y') }} — SahroolFlora, Inc.</p>
            <div class="flex space-x-4 mt-4 md:mt-0 text-sm text-gray-500">
                <a href="{{ route('terms') }}" class="hover:text-gray-900">Terms of Use</a>
                <a href="{{ route('privacy') }}" class="hover:text-gray-900">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>