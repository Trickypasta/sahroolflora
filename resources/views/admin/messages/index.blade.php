@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
<h1 class="text-3xl font-bold mb-6">Pesan Masuk dari Pengunjung</h1>
            <div class="bg-white p-6 rounded-lg shadow-md w-full">
                <div class="space-y-4">
                    @forelse ($messages as $message)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="font-semibold text-lg">{{ $message->name }} <span class="text-sm font-normal text-gray-500">&lt;{{ $message->email }}&gt;</span></p>
                                <span class="text-xs text-gray-400">{{ $message->created_at->format('d M Y, H:i') }}</span>
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