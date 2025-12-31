@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Pesan Masuk dari Pengunjung</h1>
    <div class="bg-white p-6 rounded-lg shadow-md w-full">
        <div class="space-y-4">
            @forelse ($messages as $message)
                <div class="border rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-semibold text-lg">{{ $message->name }} <span
                                class="text-sm font-normal text-gray-500">&lt;{{ $message->email }}&gt;</span></p>
                        <span class="text-xs text-gray-400">{{ $message->created_at->format('d M Y, H:i') }}</span>
                        <div class="flex-shrink-0">
                            <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST"
                                @submit.prevent="openModal($event.target)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800"
                                    title="Hapus Pesan">
                                    Hapus
                                </button>
                            </form>
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $message->email }}&su=Balasan%20untuk%20{{ $message->name }}&body=Halo%20{{ $message->name }},%0A%0ATerima%20kasih%20telah%20menghubungi%20kami."
                                target="_blank"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-4 flex items-center">
                                
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z" />
                                </svg>
                                Balas via Gmail
                            </a>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $message->message }}</p>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">
                    <p>Belum ada pesan yang masuk.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
