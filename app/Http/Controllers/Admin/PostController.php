<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    public function index()
    {
        // Ganti get() jadi paginate() biar gak lemot kalau post udah banyak
        $posts = Post::with('user')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(StorePostRequest $request)
    {
        // Validasi sekarang otomatis ditangani oleh StorePostRequest
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        }

        Auth::user()->posts()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
            'image' => $path, // Kirim $path yang mungkin null
            'published_at' => now(),
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dibuat!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();
        $dataToUpdate = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'body' => $validated['body'],
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Simpan gambar baru dan tambahkan path ke data yang akan diupdate
            $dataToUpdate['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($dataToUpdate);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus!');
    }
}