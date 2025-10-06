@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard Analitik</h1>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md mb-8">
        <h2 class="text-2xl font-bold mb-4 text-red-600">Peringatan Stok Menipis (<= 5)</h2>
                <div class="space-y-2">
                    @forelse ($lowStockProducts as $stock)
                        <div
                            class="flex justify-between items-center p-2 rounded @if ($loop->odd) bg-red-50 @endif">
                            <span>{{ $stock->product->name ?? 'Produk Dihapus' }}</span>
                            <span class="font-bold text-red-700">{{ $stock->quantity }} unit</span>
                        </div>
                    @empty
                        <p class="text-gray-500">Semua stok aman.</p>
                    @endforelse
                </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-gray-500">Pengunjung (Bulan Ini)</h3>
        <p class="text-3xl font-bold mt-2">N/A</p>
        <p class="text-xs text-gray-400 mt-1">Data dari Google Analytics</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500">Pendapatan Bulan Ini</h3>
            <p class="text-3xl font-bold mt-2">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500">Pesanan Bulan Ini</h3>
            <p class="text-3xl font-bold mt-2">{{ $ordersThisMonthCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500">Pelanggan Baru Bulan Ini</h3>
            <p class="text-3xl font-bold mt-2">{{ $newCustomersThisMonthCount }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-gray-500">Nilai Pesanan Rata-rata</h3>
            <p class="text-3xl font-bold mt-2">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</p>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Grafik Penjualan (7 Hari Terakhir)</h2>
            <canvas id="salesChart"></canvas>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h2 class="text-xl font-bold mb-2">Keuntungan Bersih</h2>
                <p class="text-sm text-gray-500 mb-4">(Bulan Ini)</p>
                @if ($netProfitThisMonth >= 0)
                    <p class="text-3xl font-bold text-green-500">Rp {{ number_format($netProfitThisMonth, 0, ',', '.') }}
                    </p>
                @else
                    <p class="text-3xl font-bold text-red-500">- Rp
                        {{ number_format(abs($netProfitThisMonth), 0, ',', '.') }}</p>
                @endif
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
                        label: 'Pendapatan',
                        data: @json($chartData),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
