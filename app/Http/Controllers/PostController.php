<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
// Impor Form Request yang baru dibuat
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    // =================================================================
    // METHOD UNTUK HALAMAN PUBLIK (YANG DILIHAT PENGUNJUNG)
    // =================================================================

    /**
     * Menampilkan halaman daftar blog untuk publik.
     */
    public function showPublicIndex()
    {
        // Ambil post yang sudah 'published' dan paginasi
        $posts = Post::whereNotNull('published_at')
                     ->latest('published_at')
                     ->paginate(9);
                     
        return view('posts.index', compact('posts'));
    }

    /**
     * Menampilkan satu artikel blog untuk publik.
     */
    public function showPublicPost(Post $post)
    {
        // Menggunakan Route Model Binding berdasarkan slug
        return view('posts.show', compact('post'));
    }

    // =================================================================
    // METHOD UNTUK HALAMAN ADMIN (CRUD)
    // =================================================================

    /**
     * Menampilkan daftar post di dashboard admin.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Menampilkan form untuk membuat post baru.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Menyimpan post baru ke database.
     */
    public function store(StorePostRequest $request)
    {
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
        }

        Auth::user()->posts()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $path,
            'published_at' => now(), // Otomatis publish saat dibuat
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit post.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Mengupdate post di database.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $path = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $path,
        ]);

        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil diupdate!');
    }

    /**
     * Menghapus post dari database.
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus!');
    }
}