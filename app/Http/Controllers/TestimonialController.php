<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input filter
        $request->validate([
            'rating' => 'nullable|integer|between:1,5',
            'sort' => 'nullable|in:latest,oldest,highest_rating,lowest_rating',
        ]);

        // Mulai query dengan eager loading relasi yang dibutuhkan
        $query = Testimonial::where('is_approved', true)
                            ->with(['user', 'product.images']);

        // Terapkan filter rating jika ada
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Terapkan sorting
        switch ($request->input('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'highest_rating':
                $query->orderBy('rating', 'desc')->latest();
                break;
            case 'lowest_rating':
                $query->orderBy('rating', 'asc')->latest();
                break;
            default: // latest
                $query->latest();
                break;
        }

        // Eksekusi query dengan paginasi
        $testimonials = $query->paginate(9)->withQueryString();

        return view('testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Pastikan user adalah pemilik order
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah user sudah pernah review produk ini dari order ini
        $existing = Testimonial::where('user_id', Auth::id())
                               ->where('order_id', $request->order_id)
                               ->where('product_id', $request->product_id)
                               ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk produk ini dari pesanan tersebut.');
        }

        Testimonial::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Tetap butuh approval admin
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}