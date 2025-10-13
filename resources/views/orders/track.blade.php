@extends('layouts.app')

@section('title', 'Lacak Pesanan - SahroolFlora')

@section('content')

    <div class="bg-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
            <h1 class="font-lora text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Lacak Pesanan</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Lihat status terkini dari pesanan Anda di sini.</p>
        </div>
    </div>

    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-16 sm:py-24 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Masukkan Detail Pesanan</h2>
                    <p class="mt-2 text-gray-600">Gunakan ID Pesanan dan email yang sama seperti saat Anda checkout.</p>
                    <div class="mt-8 bg-white p-8 rounded-lg shadow-sm">
                        <form action="{{ route('orders.track.find') }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label for="order_id" class="block text-sm font-medium text-gray-700">ID Pesanan</label>
                                <input type="text" name="order_id" id="order_id" required placeholder="Contoh: 22"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Pemesan</label>
                                <input type="email" name="email" id="email" required placeholder="contoh@email.com"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                            <div>
                                <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800">
                                    Lacak Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Status Pesanan Anda</h2>
                    <div class="mt-8">
                        @if (isset($order))
                            <div class="bg-white p-8 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Hasil untuk Pesanan #{{ $order->id }}
                                </h3>
                                <p class="text-sm text-gray-500 mb-6">Dipesan pada {{ $order->created_at->format('d F Y') }}
                                </p>

                                <dl class="space-y-4 border-t border-gray-200 pt-6">
                                    <div class="flex justify-between items-center">
                                        <dt class="text-gray-600">Status Pesanan:</dt>
                                        <dd>@include('partials.order-status-badge', [
                                            'status' => $order->status,
                                        ])</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Total Pembayaran:</dt>
                                        <dd class="font-semibold text-gray-900">Rp
                                            {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                                    </div>
                                    @if ($order->tracking_number)
                                        <div class="flex justify-between">
                                            <dt class="text-gray-600">Nomor Resi:</dt>
                                            <dd class="font-semibold text-green-700">{{ $order->tracking_number }}</dd>
                                        </div>
                                    @endif
                                </dl>

                                <div class="mt-6 border-t border-gray-200 pt-6 text-center">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="text-sm font-medium text-green-700 hover:text-green-800">
                                        Lihat Detail Pesanan Lengkap &rarr;
                                    </a>
                                </div>
                            </div>
                        @elseif (session('error') || isset($error))
                            <div class="border-l-4 border-red-400 bg-red-50 p-4 rounded-md">
                                <p class="text-sm font-medium text-red-700">{{ session('error') ?? $error }}</p>
                            </div>
                        @else
                            {{-- Tampilan Default Sebelum Mencari --}}
                            <div class="bg-white p-8 rounded-lg shadow-sm text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                                <p class="mt-4 text-gray-500">Hasil pelacakan akan muncul di sini setelah Anda memasukkan
                                    detail pesanan.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
