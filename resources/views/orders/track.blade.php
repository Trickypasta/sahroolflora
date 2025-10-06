@extends('layouts.app')
@section('title', 'Lacak Pesanan')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-3xl font-bold mb-6">Lacak Pesanan Anda</h1>

        <form action="{{ route('orders.track.find') }}" method="POST">
            @csrf
            <div class="flex">
                <input type="text" name="order_id" placeholder="Masukkan ID Pesanan Anda (Contoh: 12)" class="w-full border rounded-l-md px-4 py-3" required>
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-r-md hover:bg-blue-600 font-semibold">Lacak</button>
            </div>
        </form>

        @if(isset($order))
            <div class="text-left mt-8 border-t pt-6">
                <h2 class="text-2xl font-bold mb-4">Hasil Pelacakan untuk Pesanan #{{ $order->id }}</h2>
                <p class="text-lg"><strong>Status Pesanan:</strong> 
                    @php
                        $statusColors = [
                            'completed' => 'text-green-500',
                            'cancelled' => 'text-red-500',
                            'shipped' => 'text-indigo-500',
                            'processing' => 'text-blue-500',
                        ];
                    @endphp
                    <span class="font-bold {{ $statusColors[$order->status] ?? 'text-gray-500' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y') }}</p>
                <p><strong>Total:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
        @elseif(isset($error))
            <div class="text-left mt-8 border-t pt-6">
                <p class="text-red-500 font-bold">{{ $error }}</p>
            </div>
        @endif
    </div>
</div>
@endsection