@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Analitik</h1>

    @if ($lowStockProducts->count() > 0)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Peringatan Stok Menipis</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($lowStockProducts as $stock)
                                <li>
                                    <span class="font-semibold">{{ $stock->product->name ?? 'Produk Dihapus' }}</span>
                                    - Sisa: <span class="font-bold">{{ $stock->quantity }}</span> unit
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pendapatan (Bulan Ini)</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-red-400 uppercase tracking-wider">Pengeluaran (Bulan Ini)</h3>
            <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($expensesThisMonth, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pesanan</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $ordersThisMonthCount }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan Baru</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $newCustomersThisMonthCount }}</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total User (Visitor)</h3>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalVisitors ?? 0 }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Grafik Penjualan (7 Hari Terakhir)</h2>
            <div class="relative h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 text-center">
                <h2 class="text-lg font-bold text-gray-800 mb-1">Keuntungan Bersih</h2>
                <p class="text-xs text-gray-500 mb-4 uppercase tracking-wide">Estimasi Bulan Ini</p>

                @if ($netProfitThisMonth >= 0)
                    <p class="text-4xl font-extrabold text-green-500">Rp
                        {{ number_format($netProfitThisMonth, 0, ',', '.') }}</p>
                @else
                    <p class="text-4xl font-extrabold text-red-500">- Rp
                        {{ number_format(abs($netProfitThisMonth), 0, ',', '.') }}</p>
                @endif
                <p class="text-xs text-gray-400 mt-2">*Pendapatan - (Modal + Pengeluaran)</p>
            </div>

            {{-- Pesan Masuk Terbaru --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Pesan Terbaru</h2>
                <div class="space-y-4">
                    @forelse($latestMessages as $msg)
                        <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                            <p class="font-semibold text-sm text-gray-800">{{ $msg->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $msg->message }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $msg->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 text-center italic">Belum ada pesan masuk.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'line', 
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($chartData),
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderColor: '#3b82f6',
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointRadius: 4,
                        fill: true,
                        tension: 0.4 // Garis melengkung
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4]
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
