@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Verifikasi Pembayaran</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">ID Pesanan</th>
                    <th class="border px-4 py-2 text-left">Customer</th>
                    <th class="border px-4 py-2 text-left">Tanggal</th>
                    <th class="border px-4 py-2 text-right">Total</th>
                    <th class="border px-4 py-2 text-left">Metode Bayar</th>
                    <th class="border px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pendingOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-bold">#{{ $order->id }}</td>
                        <td class="border px-4 py-2">{{ $order->user->name }}</td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $order->payment_method }}</td>
                        <td class="border px-4 py-2 text-center">
                            <form action="{{ route('admin.payments.verify.store', $order->id) }}" method="POST" onsubmit="return confirm('Yakin pembayaran untuk pesanan ini sudah diterima?');">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600">Verifikasi</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center text-gray-500">Tidak ada pembayaran yang perlu diverifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection