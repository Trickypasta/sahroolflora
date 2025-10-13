@extends('layouts.app')

@section('title', 'Riwayat Pesanan - SahroolFlora')

@section('content')

    <div class="bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <h1 class="font-lora text-3xl font-extrabold tracking-tight text-gray-900">Akun Saya</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <aside class="md:col-span-1">
                @include('partials.account-sidebar')
            </aside>

            <div class="md:col-span-3">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h2 class="text-xl font-bold text-gray-900">Riwayat Pesanan Anda</h2>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <div class="p-4 sm:p-6 grid grid-cols-3 sm:grid-cols-5 gap-4 items-center hover:bg-gray-50">
                                <div class="col-span-2 sm:col-span-2">
                                    <p class="text-sm font-semibold text-green-700">#{{ $order->id }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d F Y') }}</p>
                                </div>
                                <div class="text-sm text-gray-900 font-medium">
                                    <span class="sm:hidden">Total: </span>
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                                <div>
                                    @include('partials.order-status-badge', ['status' => $order->status])
                                </div>
                                <div class="text-right">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="text-sm font-medium text-green-600 hover:text-green-800">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                Anda belum memiliki riwayat pesanan.
                            </div>
                        @endforelse
                    </div>

                    @if ($orders->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
