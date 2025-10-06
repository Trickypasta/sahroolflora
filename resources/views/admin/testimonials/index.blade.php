@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <main class="py-10">
        <h1 class="text-3xl font-bold mb-6">Manajemen Testimoni</h1>
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="space-y-4">
                    @forelse ($testimonials as $testimonial)
                        <div class="border rounded-lg p-4 @if(!$testimonial->is_approved) bg-yellow-50 @endif">
                            <div class="flex justify-between items-start">
                                <div>
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
                                    <small class="text-gray-500">{{ $testimonial->created_at->format('d M Y') }}</small>
                                </div>
                                <div class="flex items-center space-x-2 flex-shrink-0">
                                    @if(!$testimonial->is_approved)
                                        <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600">Setujui</button>
                                        </form>
                                    @else
                                        <span class="px-3 py-1 text-sm rounded-md bg-green-200 text-green-800">Disetujui</span>
                                    @endif

                                    <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus testimoni ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md text-sm hover:bg-red-600">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            <p>Belum ada testimoni yang masuk.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
@endsection