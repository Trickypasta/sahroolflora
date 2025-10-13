@extends('layouts.app')

@section('title', 'FAQ (Tanya Jawab) - SahroolFlora')

@section('content')

    <div class="bg-[#F8F7F3]">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Frequently Asked Questions
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Jawaban untuk pertanyaan yang paling sering diajukan.</p>
        </div>
    </div>

    <div class="bg-white">
        <div class="max-w-4xl mx-auto py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
            <div class="divide-y divide-gray-200">

                {{-- Loop sebanyak jumlah form di admin --}}
                @for ($i = 1; $i <= 5; $i++)
                    {{-- Hanya tampilkan jika pertanyaan tidak kosong --}}
                    @if (isset($settings['faq_q' . $i]) && !empty($settings['faq_q' . $i]))
                        <div x-data="{ open: false }" class="py-6">
                            <h3>
                                <button @click="open = !open"
                                    class="flex w-full items-start justify-between text-left text-gray-500">
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $settings['faq_q' . $i] }}
                                    </span>
                                    <span class="ml-6 flex h-7 items-center">
                                        <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                        </svg>
                                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                        </svg>
                                    </span>
                                </button>
                            </h3>
                            <div x-show="open" x-collapse class="pt-4 prose max-w-none text-gray-600">
                                <p>{{ $settings['faq_a' . $i] ?? 'Jawaban belum tersedia.' }}</p>
                            </div>
                        </div>
                    @endif
                @endfor

            </div>
        </div>
    </div>

    <section class="py-16 sm:py-24 bg-[#F8F7F3]">
        <div class="max-w-3xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold text-gray-800">Masih Punya Pertanyaan?</h2>
            <p class="mt-4 text-lg text-gray-600">Jangan ragu untuk menghubungi tim kami jika Anda tidak menemukan jawaban
                di sini.</p>
            <a href="{{ route('contact.show') }}"
                class="mt-8 inline-block bg-green-700 text-white font-bold py-3 px-8 rounded-full hover:bg-green-800 transition">
                Hubungi Kami
            </a>
        </div>
    </section>

@endsection
