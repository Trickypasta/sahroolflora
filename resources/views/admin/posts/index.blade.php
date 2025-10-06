@extends('layouts.admin')

@section('title', 'Manajemen Blog')

@section('content')
<h1 class="text-3xl font-bold mb-6">Manajemen Blog</h1>
            <div class="bg-white p-6 rounded-lg shadow-md w-full">
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('admin.posts.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Buat Postingan Baru</a>
                </div>
                <table class="w-full border-collapse">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border px-4 py-2 text-left">Judul</th>
                                <th class="border px-4 py-2 text-left">Penulis</th>
                                <th class="border px-4 py-2 text-left">Tanggal Terbit</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr>
                                    <td class="border px-4 py-2">{{ $post->title }}</td>
                                    <td class="border px-4 py-2">{{ $post->user->name }}</td>
                                    <td class="border px-4 py-2">
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : 'Draft' }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded-md text-sm hover:bg-yellow-600">Edit</a>
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white px-3 py-1 rounded-md text-sm hover:bg-red-600">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 p-4">Belum ada postingan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </table>
            </div>
@endsection
