@extends('layouts.admin')

@section('title', 'Edit Postingan')

@section('content')
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-6">Edit Postingan</h1>
                <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="block font-semibold mb-2">Judul</label>
                        <input type="text" name="title" id="title" class="w-full border rounded-md px-4 py-2" value="{{ old('title', $post->title) }}">
                    </div>
                    <div class="mb-4">
                        <label for="body" class="block font-semibold mb-2">Isi Artikel</label>
                        <textarea name="body" id="body" rows="10" class="w-full border rounded-md px-4 py-2">{{ old('body', $post->body) }}</textarea>
                    </div>
                    <div class="mb-6">
                        <label for="image" class="block font-semibold mb-2">Ganti Gambar Sampul (Opsional)</label>
                        <input type="file" name="image" id="image" class="w-full">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="mt-4 h-32">
                        @endif
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Update</button>
                    <a href="{{ route('admin.posts.index') }}" class="text-gray-600 ml-4">Batal</a>
                </form>
            </div>
@endsection