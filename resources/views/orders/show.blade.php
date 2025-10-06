@extends('layouts.app')
@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    @include('partials.notification')

    {{-- ====================================================================== --}}
    {{-- KONDISI 1: JIKA PESANAN MASIH PENDING (MENUNGGU PEMBAYARAN) --}}
    {{-- ====================================================================== --}}
    @if ($order->status == 'pending')
        <div class="bg-white p-8 rounded-lg shadow-md text-center">
            <h1 class="text-2xl font-bold mb-2">Menunggu Pembayaran</h1>
            <p class="text-gray-600 mb-6">Selesaikan pembayaran untuk pesanan #{{ $order->id }} agar dapat kami proses.</p>
            <div class="border-t border-b py-4 my-4">
                <p class="text-lg">Total Pembayaran:</p>
                <p class="text-4xl font-bold text-blue-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
            </div>
            <div class="text-left my-6 bg-gray-50 p-4 rounded-lg">
                <p class="font-semibold">Silakan transfer ke rekening berikut:</p>
                @php
                    $paymentMethod = \App\Models\PaymentMethod::where('name', $order->payment_method)->first();
                    $paymentInstruction = $paymentMethod->description ?? 'Hubungi admin untuk instruksi pembayaran.';
                @endphp
                <p><strong>{{ $order->payment_method }}</strong></p>
                <p class="text-gray-600">{!! nl2br(e($paymentInstruction)) !!}</p>
            </div>
            <p class="text-sm text-gray-500">Pesanan akan diproses oleh admin setelah pembayaran diverifikasi.</p>
        </div>

    {{-- ====================================================================== --}}
    {{-- SEMUA KONDISI LAIN AKAN MENAMPILKAN DETAIL YANG SAMA --}}
    {{-- ====================================================================== --}}
    @else
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-gray-600 mt-2">Status Pesanan Anda saat ini:</p>
            <div class="mt-2">
                @switch($order->status)
                    @case('processing') <span class="px-3 py-1 text-base font-semibold rounded-full bg-blue-200 text-blue-800">Diproses</span> @break
                    @case('shipped') <span class="px-3 py-1 text-base font-semibold rounded-full bg-indigo-200 text-indigo-800">Dikirim</span> @break
                    @case('completed') <span class="px-3 py-1 text-base font-semibold rounded-full bg-green-200 text-green-800">Selesai</span> @break
                    @case('cancelled') <span class="px-3 py-1 text-base font-semibold rounded-full bg-red-200 text-red-800">Dibatalkan</span> @break
                @endswitch
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md space-y-8">
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4">Informasi Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div><p><strong>Dikirim kepada:</strong> {{ $order->user->name }}</p><p><strong>Alamat:</strong> {{ $order->address->address_line }}, {{ $order->address->city }}</p></div>
                    <div>
                        <p><strong>Metode Pengiriman:</strong> {{ $order->shipping_method }}</p>
                        @if ($order->tracking_number)
                            <p><strong>Nomor Resi:</strong> <span class="font-bold text-indigo-600">{{ $order->tracking_number }}</span></p>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-semibold border-b pb-2 mb-4">Rincian Item</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ $item->product->images->isNotEmpty() ? asset('storage/' . $item->product->images->first()->path) : 'https://via.placeholder.com/100' }}" alt="{{ $item->product->name }}" class="h-16 w-16 object-cover rounded-md mr-4">
                            <div><p class="font-semibold">{{ $item->product->name ?? 'Produk Dihapus' }}</p><p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p></div>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($order->status == 'completed')
            <div class="bg-white p-8 rounded-lg shadow-md mt-8">
                @if (!$order->testimonial)
                    <h2 class="text-2xl font-bold mb-4">Tulis Ulasan Anda</h2>
                    <form action="{{ route('testimonials.store') }}" method="POST">@csrf<input type="hidden" name="order_id" value="{{ $order->id }}">...</form>
                @else
                    <p class="text-center text-gray-600">Anda sudah memberikan ulasan untuk pesanan ini.</p>
                @endif
            </div>
            <div class="mt-8 text-center">
                @if (!$order->returnRequest)
                    <a href="{{ route('returns.create', $order->id) }}" class="text-sm text-gray-600 hover:underline">Ajukan Pengembalian</a>
                @else
                    <p class="font-semibold">Status Pengembalian: {{ ucfirst($order->returnRequest->status) }}</p>
                @endif
            </div>
        @endif
    @endif
</div>
@endsection