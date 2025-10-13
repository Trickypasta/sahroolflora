@extends('layouts.app')

@section('title', 'Pesanan Berhasil - SahroolFlora')

@section('content')
<div class="bg-white">
    <div class="max-w-4xl mx-auto text-center py-24 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto h-12 w-12 text-green-500">
            <svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
        </div>
        <h1 class="mt-4 font-lora text-4xl font-extrabold text-gray-900">Terima Kasih!</h1>
        <p class="mt-2 text-lg text-gray-600">Pesanan Anda telah kami terima dan akan segera kami proses. Detail pesanan dapat Anda lihat di halaman Riwayat Pesanan.</p>
        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('orders.index') }}" 
               class="inline-block bg-transparent border border-gray-400 text-gray-800 font-bold py-3 px-8 rounded-full hover:bg-gray-100">
                Lihat Pesanan Saya
            </a>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-green-700 text-white font-bold py-3 px-8 rounded-full hover:bg-green-800">
                Kembali Belanja
            </a>
        </div>
    </div>
</div>
@endsection