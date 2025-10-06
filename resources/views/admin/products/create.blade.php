@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Tambah Produk Baru</h1>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="5" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                    <div>
                        <label for="stock" class="block text-sm font-medium text-slate-700 mb-1">Stok</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Kategori</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @forelse ($categories as $category)
                            <label class="flex items-center text-sm text-slate-600">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-2">
                                {{ $category->name }}
                            </label>
                        @empty
                            <p class="text-slate-500 col-span-full text-sm">Belum ada kategori. Silakan buat dulu di menu Kategori.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <label for="images" class="block text-sm font-medium text-slate-700 mb-1">Gambar Produk (Bisa lebih dari satu)</label>
                    <input type="file" name="images[]" id="images" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple>
                </div>
            </div>

            <div class="border-t border-slate-200 mt-6 pt-6 flex items-center gap-4">
                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan Produk</button>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-800">Batal</a>
            </div>
        </form>
    </div>
@endsection