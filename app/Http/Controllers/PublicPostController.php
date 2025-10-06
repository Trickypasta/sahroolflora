<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
class PublicPostController extends Controller
{
    public function index()
    {
        $posts = Post::whereNotNull('published_at')->latest()->get();
        return view('posts.index', compact('posts'));
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}