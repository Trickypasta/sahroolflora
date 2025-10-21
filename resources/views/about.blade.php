@extends('layouts.app')

@section('title', 'Tentang Kami - SahroolFlora')

@section('content')

    <section class="relative h-64 bg-cover bg-center text-white"
        style="background-image: url('https://images.unsplash.com/photo-1501004318641-b39e6451bec6?q=80&w=2874');">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 flex items-center justify-center h-full text-center">
            <h1 class="font-lora text-5xl font-extrabold tracking-tight">Cerita Kami</h1>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center " data-aos="fade-up" >
                <div>
                    @if (isset($settings['general_logo']) && $settings['general_logo'])
                        <img src="{{ asset('storage/' . $settings['general_logo']) }}" alt="Logo SahroolFlora"
                            class="rounded-lg shadow-lg w-full h-auto object-contain">
                    @else
                        {{-- Gambar default jika logo belum di-upload --}}
                        <img src="{{ asset('sahroolicon.jpg') }}"
                            alt="Petani tanaman hias lokal" class="rounded-lg shadow-lg aspect-[4/3] object-cover">
                    @endif
                </div>
                <div class="prose prose-lg max-w-none text-gray-700">
                    <p>
                        {!! nl2br(
                            e($settings['about_story'] ?? 'Cerita tentang SahroolFlora belum diisi. Silakan isi melalui panel admin.'),
                        ) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-[#F8F7F3]">
        <div class="max-w-3xl mx-auto px-4 text-center" data-aos="fade-up" >
            <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Visi Kami</h2>
            <p class="mt-4 font-lora text-2xl text-gray-600 leading-relaxed"> 
                "{{ $settings['about_vision'] ?? 'Visi perusahaan belum diisi.' }}"
            </p>
        </div>
    </section>

    <section class="py-16 sm:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Misi Kami</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Empat pilar utama yang menjadi landasan kami dalam
                    bekerja.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
                <div class="flex space-x-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-lg" >
                        <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">{{ $settings['about_mission_1_title'] ?? 'Mendukung UMKM' }}
                        </h3>
                        <p class="mt-1 text-gray-600">
                            {{ $settings['about_mission_1_desc'] ?? 'Mendukung UMKM dan petani tanaman lokal agar lebih berkembang secara digital.' }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-lg" >
                        <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">{{ $settings['about_mission_2_title'] ?? 'Produk Sehat' }}</h3>
                        <p class="mt-1 text-gray-600">
                            {{ $settings['about_mission_2_desc'] ?? 'Memberikan kemudahan akses bagi customer untuk mendapatkan informasi dan produk yang sesuai.' }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-lg">
                        <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">{{ $settings['about_mission_3_title'] ?? 'Dukung Petani Lokal' }}
                        </h3>
                        <p class="mt-1 text-gray-600">
                            {{ $settings['about_mission_3_desc'] ?? 'Mendukung perekonomian petani tanaman hias lokal dengan sistem yang adil dan transparan.' }}
                        </p>
                    </div>
                </div>
                <div class="flex space-x-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center bg-green-100 rounded-lg">
                        <svg class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-9.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            <path d="M12 14l9-5-9-5-9 5 9 5z" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">{{ $settings['about_mission_4_title'] ?? 'Edukasi & Komunitas' }}
                        </h3>
                        <p class="mt-1 text-gray-600">
                            {{ $settings['about_mission_4_desc'] ?? 'Mengedukasi masyarakat tentang manfaat dan cara merawat tanaman untuk lingkungan yang lebih hijau.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#F8F7F3]">
        <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="500">
            <h2 class="text-3xl font-bold sm:text-4xl">
                <span class="block">Siap Menghijaukan Rumah Anda?</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-gray-600">Temukan teman hijau baru Anda di koleksi pilihan kami.</p>
            <a href="{{ route('products.index') }}"
                class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-full text-white bg-green-700 hover:bg-green-800 sm:w-auto">
                Jelajahi Koleksi Kami
            </a>
        </div>
    </section>

@endsection
