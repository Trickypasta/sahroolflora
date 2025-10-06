@extends('layouts.admin')
@section('title', 'Manajemen Pengiriman')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Opsi Pengiriman</h1>
    @include('partials.notification')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Tambah Opsi Baru</h2>
                <form action="{{ route('admin.shipping-methods.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block font-semibold">Nama Metode (Contoh: JNE Reguler)</label>
                        <input type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 mt-1" required>
                    </div>
                    <div class="mb-4">
                        <label for="cost" class="block font-semibold">Biaya (Rp)</label>
                        <input type="number" name="cost" id="cost" class="w-full border rounded-md px-3 py-2 mt-1" required>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md w-full">Simpan</button>
                </form>
            </div>
        </div>
        <div class="md:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Daftar Opsi Pengiriman</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2 text-left">Nama</th>
                            <th class="border px-4 py-2 text-right">Biaya</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shippingMethods as $method)
                            <tr>
                                <td class="border px-4 py-2">{{ $method->name }}</td>
                                <td class="border px-4 py-2 text-right">Rp {{ number_format($method->cost, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('admin.shipping-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Belum ada opsi pengiriman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection