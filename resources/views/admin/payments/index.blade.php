@extends('layouts.admin')
@section('title', 'Manajemen Metode Pembayaran')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Metode Pembayaran</h1>
    @include('partials.notification')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Tambah Metode Baru</h2>
                <form action="{{ route('admin.payment-methods.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block font-semibold">Nama Metode</label>
                        <input type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 mt-1" placeholder="Contoh: Transfer Bank BCA" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-semibold">Deskripsi / Instruksi</label>
                        <textarea name="description" id="description" rows="3" class="w-full border rounded-md px-3 py-2 mt-1" placeholder="Contoh: No. Rek: 1234567890 a/n SahroolFlora"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" class="mr-2" checked>
                            Aktifkan metode ini
                        </label>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md w-full">Simpan</button>
                </form>
            </div>
        </div>
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Daftar Metode Pembayaran</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2 text-left">Nama</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paymentMethods as $method)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">
                                    <p class="font-semibold">{{ $method->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $method->description }}</p>
                                </td>
                                <td class="border px-4 py-2">
                                    @if($method->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-200 text-green-800">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                                    <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Belum ada metode pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection