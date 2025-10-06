@extends('layouts.admin')

@section('title', 'Buat Postingan Baru')

@section('content')
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-6">Buat Postingan Baru</h1>
                <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block font-semibold mb-2">Judul</label>
                        <input type="text" name="title" id="title" class="w-full border rounded-md px-4 py-2">
                    </div>
                    <div class="mb-4">
                        <label for="body" class="block font-semibold mb-2">Isi Artikel</label>
                        <textarea name="body" id="body" rows="10" class="w-full border rounded-md px-4 py-2"></textarea>
                    </div>
                    <div class="mb-6">
                        <label for="image" class="block font-semibold mb-2">Gambar Sampul</label>
                        <input type="file" name="image" id="image" class="w-full">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Simpan</button>
                </form>
            </div>
@endsection