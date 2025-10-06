@extends('layouts.app')

@section('title', 'Pesanan Berhasil - SahroolFlora')

@section('content')
    @include('partials.notification')

    <div class="py-10">
        <div class="max-w-2xl mx-auto text-center">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-3xl font-bold text-green-500 mb-4">Terima Kasih!</h1>
                <p class="text-lg text-gray-700">Pesanan Anda telah kami terima dan akan segera kami proses.</p>
                <a href="{{ route('products.index') }}"
                    class="mt-8 inline-block bg-blue-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600">
                    Kembali Belanja
                </a>
            </div>
        </div>
    </div>
@endsection
