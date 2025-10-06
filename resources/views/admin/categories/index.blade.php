@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manajemen Kategori</h1>

    @include('partials.notification')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Form Input --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Tambah Kategori Baru</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block font-semibold">Nama Kategori</label>
                        <input type="text" name="name" id="name" class="w-full border rounded-md px-3 py-2 mt-1" placeholder="Contoh: Tanaman Indoor" required>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block font-semibold">Gambar Kategori (Opsional)</label>
                        <input type="file" name="image" id="image" class="w-full mt-1 text-sm">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md w-full hover:bg-blue-600">Simpan Kategori</button>
                </form>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Kategori --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4">Daftar Kategori</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2 text-left">Gambar</th>
                                <th class="border px-4 py-2 text-left">Nama</th>
                                <th class="border px-4 py-2 text-left">Slug</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">
                                        <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/100x100.png?text=No+Image' }}" alt="{{ $category->name }}" class="h-16 w-16 object-cover rounded">
                                    </td>
                                    <td class="border px-4 py-2 font-semibold">{{ $category->name }}</td>
                                    <td class="border px-4 py-2">{{ $category->slug }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-yellow-600 hover:underline text-sm">Edit</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm ml-2">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-2 text-center text-gray-500">Belum ada data kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection