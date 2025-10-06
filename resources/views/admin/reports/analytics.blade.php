@extends('layouts.admin')
@section('title', 'Analitik & Statistik')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Analitik & Statistik</h1>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form action="{{ route('admin.analytics.index') }}" method="GET">
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
                <a href="{{ route('admin.analytics.index') }}"
                    class="text-gray-600 px-4 py-2 rounded-md hover:bg-gray-200">Reset</a>
            </div>
        </form>
    </div>

    <div class="space-y-8">

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Laporan Penjualan (Periode Terpilih)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 text-center">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-blue-500">Total Pendapatan</h3>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-blue-500">Jumlah Pesanan</h3>
                    <p class="text-2xl font-bold">{{ $orders->count() }}</p>
                </div>
            </div>
            <div class="mt-6">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Laporan Produk Terlaris (Periode Terpilih)</h2>
            <table class="w-full border-collapse">
                <tbody>
                    @forelse ($topProducts as $product)
                        <tr>
                            <td class="border px-4 py-2 text-center font-bold">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $product->name }}</td>
                            <td class="border px-4 py-2 text-center">{{ $product->total_sold }} unit</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Tidak ada produk terjual
                                pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">Laporan Pengunjung</h2>
            <p class="text-gray-500">Fitur ini membutuhkan integrasi dengan Google Analytics.</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 text-center">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-gray-500">Pengguna Baru</h3>
                    <p class="text-2xl font-bold">N/A</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-gray-500">Jumlah Sesi</h3>
                    <p class="text-2xl font-bold">N/A</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-gray-500">Rata-rata Durasi Sesi</h3>
                    <p class="text-2xl font-bold">N/A</p>
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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
