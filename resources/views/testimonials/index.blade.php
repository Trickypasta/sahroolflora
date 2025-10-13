@extends('layouts.app')

@section('title', 'Testimoni Pelanggan - SahroolFlora')

@section('content')

    <!-- 1. Header Halaman -->
    <div class="bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Apa Kata Mereka?</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Cerita tulus dari para pelanggan yang telah membawa keindahan alam ke rumah mereka.</p>
        </div>
    </div>

    <!-- 2. Konten Utama -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
            
            @if ($testimonials->isNotEmpty())
                <!-- Grid Testimoni -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                        <div class="border border-gray-200 rounded-lg p-6 flex flex-col">
                            <!-- Rating Bintang (SVG) -->
                            <div class="flex items-center mb-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-5 w-5 flex-shrink-0 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>

                            <!-- Komentar (dibuat flex-grow agar mendorong info user ke bawah) -->
                            <p class="text-gray-700 italic flex-grow">"{{ $testimonial->comment }}"</p>

                            <!-- Info User -->
                            <div class="flex items-center mt-6 pt-4 border-t border-gray-200">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center font-bold text-green-800">
                                        {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-900">{{ $testimonial->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $testimonial->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Link Paginasi -->
                <div class="mt-16">
                    {{ $testimonials->links() }}
                </div>

            @else
                <!-- Tampilan Jika Testimoni Kosong -->
                <div class="text-center bg-gray-50 rounded-lg py-16">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h2 class="mt-4 text-xl font-semibold text-gray-800">Belum Ada Testimoni</h2>
                    <p class="mt-2 text-gray-600">Jadilah yang pertama memberikan ulasan untuk produk kami!</p>
                </div>
            @endif

        </div>
    </div>

    <!-- 3. CTA (Call to Action) -->
    <section class="bg-[#F8F7F3]">
        <div class="max-w-4xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold sm:text-4xl">
                <span class="block">Lihat Apa yang Membuat Pelanggan Kami Senang</span>
            </h2>
            <a href="{{ route('products.index') }}" 
               class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-full text-white bg-green-700 hover:bg-green-800 sm:w-auto">
                Belanja Sekarang
            </a>
        </div>
    </section>

@endsection