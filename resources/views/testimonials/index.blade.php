@extends('layouts.app')

@section('title', 'Testimoni Pelanggan - SahroolFlora')

@section('content')
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-center mb-8">Apa Kata Mereka?</h1>

            <div class="space-y-6">
                @forelse ($testimonials as $testimonial)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-600">
                                    {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-lg">{{ $testimonial->user->name }}</p>
                                <div class="flex items-center my-1">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <span class="text-yellow-400">★</span>
                                    @endfor
                                    @for ($i = $testimonial->rating; $i < 5; $i++)
                                        <span class="text-gray-300">★</span>
                                    @endfor
                                </div>
                                <p class="text-gray-700 mt-2">{{ $testimonial->comment }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-6 text-center">
                        <p class="text-gray-600">Belum ada testimoni.</p>
                    </div>
                @endforelse
            </div>
        </div>
@endsection