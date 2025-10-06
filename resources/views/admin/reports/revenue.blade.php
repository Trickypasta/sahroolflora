@extends('layouts.admin')
@section('title', 'Laporan Pendapatan')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Laporan Pendapatan</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form action="{{ route('admin.reports.revenue') }}" method="GET">
            <div class="flex items-end space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Filter</button>
                <a href="{{ route('admin.reports.revenue') }}"
                    class="text-gray-600 px-4 py-2 rounded-md hover:bg-gray-200">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Kartu Total Pengeluaran --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Total Pengeluaran (Periode)</h2>
            <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
        </div>

        {{-- Kartu Keuntungan Bersih --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Keuntungan Bersih (Periode)</h2>
            <p class="text-3xl font-bold mt-2 {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format($netProfit, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <div class="mb-4">
            <h2 class="text-xl font-semibold">Total Pendapatan (Periode Terpilih)</h2>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2 text-left">Order ID</th>
                    <th class="border px-4 py-2 text-left">Tanggal</th>
                    <th class="border px-4 py-2 text-left">Customer</th>
                    <th class="border px-4 py-2 text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">#{{ $order->id }}</td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="border px-4 py-2">{{ $order->user->name }}</td>
                        <td class="border px-4 py-2 text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Tidak ada data pendapatan
                            untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
