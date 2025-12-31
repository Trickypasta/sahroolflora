@extends('layouts.admin')

@section('title', 'Analitik & Statistik')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard Analitik</h1>
            <p class="text-slate-500 text-sm mt-1">Pantau performa toko Anda secara real-time.</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto no-print">
            <form action="{{ route('admin.analytics.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                <div class="flex items-center gap-2 bg-white p-1 rounded-lg border border-slate-300 shadow-sm">
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="border-0 focus:ring-0 text-sm text-slate-600 bg-transparent py-1">
                    <span class="text-slate-400 text-xs">s/d</span>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="border-0 focus:ring-0 text-sm text-slate-600 bg-transparent py-1">
                </div>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    Terapkan
                </button>
            </form>

            <button onclick="window.print()"
                class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                PDF
            </button>
        </div>
    </div>

    <div class="print-header hidden mb-6 text-center border-b pb-4">
        <h2 class="text-2xl font-bold text-slate-900">Laporan Performa Toko</h2>
        <p class="text-slate-600 text-sm">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pendapatan</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-green-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pesanan</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $orders->count() }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
        </div>

        {{-- Card 3: Customers --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pelanggan</p>
                <div class="flex items-end gap-2">
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalCustomers }}</p>
                    @if ($newCustomersThisMonth > 0)
                        <span
                            class="text-xs font-medium text-green-600 bg-green-100 px-1.5 py-0.5 rounded mb-1">+{{ $newCustomersThisMonth }}
                            baru</span>
                    @endif
                </div>
            </div>
            <div class="p-3 bg-indigo-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        {{-- Card 4: Messages --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Pesan Masuk</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalContactMessages }}</p>
            </div>
            <div class="p-3 bg-amber-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    {{-- CHART SECTION --}}
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 mb-8 break-inside-avoid">
        <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
            </svg>
            Grafik Pendapatan Harian
        </h2>
        <div class="relative w-full h-[350px]">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden break-inside-avoid">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-lg font-bold text-slate-800">Produk Terlaris</h2>
            <p class="text-sm text-slate-500">Produk dengan penjualan tertinggi periode ini.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Rank</th>
                        <th class="px-6 py-3 font-semibold">Nama Produk</th>
                        <th class="px-6 py-3 font-semibold text-right">Total Terjual</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($topProducts as $product)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 w-16">
                                @if ($loop->iteration == 1)
                                    <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded font-bold text-xs">🥇
                                        #1</span>
                                @elseif($loop->iteration == 2)
                                    <span class="bg-gray-100 text-gray-700 py-1 px-2 rounded font-bold text-xs">🥈
                                        #2</span>
                                @elseif($loop->iteration == 3)
                                    <span class="bg-orange-100 text-orange-800 py-1 px-2 rounded font-bold text-xs">🥉
                                        #3</span>
                                @else
                                    <span class="text-slate-500 font-bold ml-2">#{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-indigo-600">{{ $product->total_sold }}</span>
                                <span class="text-slate-400 text-xs ml-1">unit</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400 italic">
                                Belum ada data penjualan untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- CHART JS CONFIG --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart');

            // Bikin Gradient Warna biar Chartnya Ganteng
            const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Indigo muda
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)'); // Transparan

            new Chart(ctx, {
                type: 'line', // Ganti jadi LINE biar lebih elegan buat time-series
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($chartData),
                        backgroundColor: gradient,
                        borderColor: '#4f46e5', // Warna garis Indigo
                        borderWidth: 2,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true, // Area di bawah garis diwarnai
                        tension: 0.3 // Garisnya melengkung halus (curved)
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    let value = context.parsed.y;
                                    return new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(value);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#64748b',
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000) + 'k';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                color: '#64748b'
                            }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        @media print {

            nav,
            aside,
            header,
            .no-print,
            form {
                display: none !important;
            }

            body,
            main,
            .flex,
            .md\:ml-64,
            .min-h-screen {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                background-color: white !important;
                overflow: visible !important;
                height: auto !important;
            }

            /* Judul Print */
            .print-header {
                display: block !important;
            }

            /* Perbaikan Visual Print */
            .bg-white {
                border: none !important;
                box-shadow: none !important;
            }

            .shadow-sm,
            .shadow-md {
                box-shadow: none !important;
                border: 1px solid #eee !important;
            }

            /* Chart resizing */
            canvas {
                max-height: 300px !important;
                width: 100% !important;
            }

            /* Page Break */
            .break-inside-avoid {
                page-break-inside: avoid;
            }
        }
    </style>
@endpush