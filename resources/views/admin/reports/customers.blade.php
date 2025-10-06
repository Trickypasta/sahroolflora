@extends('layouts.admin')
@section('title', 'Laporan Pelanggan')
@section('content')
    <h1 class="text-3xl font-bold mb-6">Laporan Pelanggan Teratas</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <p class="text-gray-600 mb-4">Daftar pelanggan diurutkan berdasarkan total belanja dari pesanan yang sudah selesai (completed).</p>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">Peringkat</th>
                    <th class="border px-4 py-2 text-left">Nama Customer</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-center">Jumlah Pesanan</th>
                    <th class="border px-4 py-2 text-right">Total Belanja</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topCustomers as $customer)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2 font-bold text-center">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $customer->name }}</td>
                        <td class="border px-4 py-2">{{ $customer->email }}</td>
                        <td class="border px-4 py-2 text-center">{{ $customer->orders_count }}</td>
                        <td class="border px-4 py-2 text-right font-semibold">Rp {{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Belum ada data pesanan yang selesai.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection