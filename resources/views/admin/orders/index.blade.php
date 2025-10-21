@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Pesanan</h1>

    <div class="mb-6 border-b border-slate-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @php
                $tabs = [
                    'pending' => 'Pesanan Baru',
                    'processing' => 'Siap Dikirim',
                    'shipped' => 'Dalam Pengiriman',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp

            @foreach ($tabs as $tabStatus => $tabName)
                <a href="{{ route('admin.orders.index', ['status' => $tabStatus]) }}"
                    class="{{ $status == $tabStatus ? 'border-blue-500 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}
                          whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    {{ $tabName }}
                    @if (isset($statusCounts[$tabStatus]) && $statusCounts[$tabStatus] > 0)
                        <span
                            class="ml-2 inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                   {{ $status == $tabStatus ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ $statusCounts[$tabStatus] }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID Pesanan</th>
                        <th scope="col" class="px-6 py-3">Nama Customer</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-medium text-blue-600">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->user->name }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @include('partials.order-status-badge', ['status' => $order->status])
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="font-medium text-blue-600 hover:underline">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-500">Tidak ada pesanan dengan status
                                ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
