@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <main class="py-10">
        <h1 class="text-3xl font-bold mb-6">Manajemen Produk</h1>
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Produk Baru</a>
                </div>

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2 text-left">Gambar</th>
                            <th class="border px-4 py-2 text-left">Nama</th>
                            <th class="border px-4 py-2 text-left">Harga</th>
                            <th class="border px-4 py-2 text-left">Stok</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="border px-4 py-2">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" class="h-16 w-16 object-cover">
                                    @else
                                        <span class="text-xs text-gray-500">No Image</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2 font-semibold">{{ $product->name }}</td>
                                <td class="border px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">{{ $product->stock->quantity ?? 0 }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 text-sm">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-2 text-center text-gray-500">Belum ada data produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

@endsection