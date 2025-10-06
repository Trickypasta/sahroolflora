@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-6">Manajemen Pesanan</h1>
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2 text-left">ID Pesanan</th>
                            <th class="border px-4 py-2 text-left">Nama Customer</th>
                            <th class="border px-4 py-2 text-left">Tanggal</th>
                            <th class="border px-4 py-2 text-left">Total</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">#{{ $order->id }}</td>
                                <td class="border px-4 py-2">{{ $order->user->name }}</td>
                                <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="border px-4 py-2">
                                    @switch($order->status)
                                        @case('pending')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-200 text-yellow-800">
                                                Menunggu
                                            </span>
                                        @break

                                        @case('processing')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-200 text-blue-800">
                                                Diproses
                                            </span>
                                        @break

                                        @case('shipped')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-200 text-purple-800">
                                                Dikirim
                                            </span>
                                        @break

                                        @case('completed')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">
                                                Selesai
                                            </span>
                                        @break

                                        @case('cancelled')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-200 text-red-800">
                                                Dibatalkan
                                            </span>
                                        @break

                                        @default
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="text-blue-500 hover:underline">Lihat Detail</a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">Belum ada pesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

@endsection