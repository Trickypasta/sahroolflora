@extends('layouts.admin')
@section('title', 'Detail Pelanggan: ' . $user->name)

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Profil Pelanggan</h1>
            <p class="text-slate-500">Detail riwayat interaksi untuk <span class="font-semibold">{{ $user->name }}</span>.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition-all hover:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
            &larr; Kembali ke Daftar Pengguna
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Info & Statistik --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-slate-700">Informasi Kontak</h2>
                <div class="space-y-2 text-sm text-slate-600">
                    <p><strong class="font-medium text-slate-800">Nama:</strong> {{ $user->name }}</p>
                    <p><strong class="font-medium text-slate-800">Email:</strong> {{ $user->email }}</p>
                    <p><strong class="font-medium text-slate-800">Terdaftar Sejak:</strong> {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <h2 class="text-lg font-semibold mb-2 text-slate-700">Total Belanja</h2>
                <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500 mt-1">dari {{ $completedOrdersCount }} pesanan selesai</p>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-slate-700">Riwayat Pesanan</h2>
                <div class="overflow-y-auto max-h-80">
                    <div class="divide-y divide-slate-200">
                        @forelse ($user->orders->sortByDesc('created_at') as $order)
                            <div class="py-3 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="font-medium text-blue-600 hover:underline">Pesanan #{{ $order->id }}</a>
                                    <p class="text-xs text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="font-semibold text-slate-800">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    <p class="text-xs text-slate-500">{{ ucfirst($order->status) }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-sm py-4 text-center">Belum ada riwayat pesanan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-lg font-semibold mb-4 border-b pb-2 text-slate-700">Riwayat Pesan Kontak</h2>
                <div class="text-slate-500 text-sm py-4 text-center">
                    <p>Fitur ini belum diimplementasikan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
