<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|unique:posts', 'body' => 'required', 'image' => 'nullable|image']);
        $path = $request->hasFile('image') ? $request->file('image')->store('posts', 'public') : null;

        Auth::user()->posts()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'image' => $path,
            'published_at' => now(),
        ]);
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dibuat!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|unique:posts,title,' . $post->id,
            'body' => 'required',
            'image' => 'nullable|image'
        ]);

        $path = $post->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Simpan gambar baru
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

    public function destroy(Post $post)
    {
        // Hapus gambar dari storage jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Postingan berhasil dihapus!');
    }
}