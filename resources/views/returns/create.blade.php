@extends('layouts.app')

@section('title', 'Ajukan Pengembalian - SahroolFlora')

@section('content')
    <div class="py-10">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4">Ajukan Pengembalian untuk Pesanan #{{ $order->id }}</h1>
                <p class="text-gray-600 mb-6">Jelaskan alasan Anda mengapa ingin mengembalikan produk dari pesanan ini.</p>
                <form action="{{ route('returns.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="mb-4">
                        <label for="reason" class="block text-gray-700 font-semibold mb-2">Alasan Pengembalian</label>
                        <textarea name="reason" id="reason" rows="5" class="w-full px-4 py-2 border rounded-md" placeholder="Contoh: Tanaman yang diterima tidak sesuai atau rusak." required></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-600">Kirim Permintaan</button>
                        <a href="{{ route('orders.show', $order->id) }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection