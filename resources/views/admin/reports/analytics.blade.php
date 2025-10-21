@extends('layouts.admin')
@section('title', 'Analitik & Statistik')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Analitik & Statistik</h1>

    {{-- Form Filter Tanggal --}}
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form action="{{ route('admin.analytics.index') }}" method="GET">
            <div class="flex items-end space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-slate-700">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="mt-1 block w-full border-slate-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Filter</button>
                <a href="{{ route('admin.analytics.index') }}"
                    class="text-slate-600 px-4 py-2 rounded-lg hover:bg-slate-100">Reset</a>
            </div>
        </form>
    </div>

    <div class="space-y-8">
        {{-- Laporan Penjualan & Grafik --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Laporan Penjualan (Periode Terpilih)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-center">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-500">TOTAL PENDAPATAN</h3>
                    <p class="text-3xl font-bold text-blue-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-500">JUMLAH PESANAN</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $orders->count() }}</p>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto">
                <div class="min-w-[800px] h-96 relative">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Laporan Produk Terlaris --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Laporan Produk Terlaris (Periode Terpilih)</h2>
            <table class="w-full text-sm text-left text-slate-500">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50">
                    <tr>
                        <th class="px-6 py-3">No.</th>
                        <th class="px-6 py-3">Nama Produk</th>
                        <th class="px-6 py-3 text-center">Jumlah Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($topProducts as $product)
                        <tr class="bg-white border-b hover:bg-slate-50">
                            <td class="px-6 py-4 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-center">{{ $product->total_sold }} unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-slate-500">Tidak ada produk terjual pada
                                periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Statistik Pelanggan & Interaksi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-center">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-500">TOTAL PELANGGAN</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalCustomers }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-500">PELANGGAN BARU (Bulan Ini)</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $newCustomersThisMonth }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-500">TOTAL PESAN MASUK</h3>
                    <p class="text-3xl font-bold text-blue-900">{{ $totalContactMessages }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: @json($chartData),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }

        });
    </script>
@endpush
