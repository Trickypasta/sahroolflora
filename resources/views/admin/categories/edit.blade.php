@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Kategori: {{ $category->name }}</h1>

    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-semibold mb-2">Ganti Gambar Kategori (Opsional)</label>
                <input type="file" name="image" id="image" class="w-full text-sm">
                @if ($category->image)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Gambar Saat Ini:</p>
                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-24 w-24 object-cover rounded-md">
                    </div>
                @endif
            </div>
            
            <div class="flex items-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">Update Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="text-gray-600 ml-4">Batal</a>
            </div>
        </form>
    </div>
@endsection