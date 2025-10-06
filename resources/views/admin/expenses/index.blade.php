@extends('layouts.admin')
@section('title', 'Manajemen Pengeluaran')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Pengeluaran</h1>

    @include('partials.notification')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Form Input --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Catat Pengeluaran Baru</h2>
                <form action="{{ route('admin.expenses.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="description" class="block font-semibold">Deskripsi</label>
                        <input type="text" name="description" id="description" class="w-full border rounded-md px-3 py-2 mt-1" required>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="block font-semibold">Jumlah (Rp)</label>
                        <input type="number" step="0.01" name="amount" id="amount" class="w-full border rounded-md px-3 py-2 mt-1" required>
                    </div>
                    <div class="mb-4">
                        <label for="expense_date" class="block font-semibold">Tanggal</label>
                        <input type="date" name="expense_date" id="expense_date" class="w-full border rounded-md px-3 py-2 mt-1" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md w-full hover:bg-blue-600">Simpan Pengeluaran</button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Pengeluaran --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Daftar Pengeluaran</h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2 text-left">Tanggal</th>
                                <th class="border px-4 py-2 text-left">Deskripsi</th>
                                <th class="border px-4 py-2 text-right">Jumlah</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $expense)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $expense->expense_date->format('d M Y') }}</td>
                                    <td class="border px-4 py-2">{{ $expense->description }}</td>
                                    <td class="border px-4 py-2 text-right">Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                                        <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada data pengeluaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection