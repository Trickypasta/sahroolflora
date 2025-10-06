@extends('layouts.app')

@section('title', 'SahroolFlora - Hubungi Kami')

@section('content')

    <!-- 1. Header Halaman -->
    <div class="bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Hubungi Kami</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Punya pertanyaan atau butuh bantuan? Kami siap membantu!</p>
        </div>
    </div>

    <!-- 2. Konten Utama (Form & Info Kontak) -->
    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Kolom Kiri: Form Kontak -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-lg text-gray-600 mb-8">Isi form di bawah ini dan tim kami akan segera membalas Anda.</p>
                    
                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Anda</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600 transition">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Anda</label>
                            <input type="email" name="email" id="email" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600 transition">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Anda</label>
                            <textarea name="message" id="message" rows="5" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-green-600 focus:border-green-600 transition"></textarea>
                        </div>
                        <div>
                            <button type="submit" 
                                    class="w-full bg-green-700 text-white font-bold py-3 px-6 rounded-full hover:bg-green-800 transition-colors duration-300 text-lg">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Kolom Kanan: Info Kontak & Peta -->
                <div class="pt-2">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Informasi Kontak</h2>
                    <div class="space-y-6 text-gray-700">
                        <!-- Alamat -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-8 w-8 text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Alamat</h3>
                                <p>Jl. Raya Bojong Gede, Kab. Bogor, Jawa Barat</p>
                            </div>
                        </div>
                        <!-- Telepon -->
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-8 w-8 text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Telepon</h3>
                                <p>+62 812 3456 7890</p>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                             <div class="flex-shrink-0 h-8 w-8 text-green-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Email</h3>
                                <p>info@sahroolflora.test</p>
                            </div>
                        </div>
                    </div>

                    <!-- Peta -->
                    <div class="mt-10">
                        <div class="aspect-video w-full overflow-hidden rounded-lg shadow-md">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63430.4379927696!2d106.7579178125633!3d-6.46114422967272!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c2079ec059a3%3A0x401576d14fed960!2sBojonggede%2C%20Bogor%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1696095681958!5m2!1sen!2sid" 
                                    class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection