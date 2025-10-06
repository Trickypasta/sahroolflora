<?php
namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    // Untuk menampilkan semua testimoni yang sudah disetujui (approve)
    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)->with('user')->latest()->get();
        return view('testimonials.index', compact('testimonials'));
    }

    // Untuk menyimpan testimoni baru dari customer
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id|unique:testimonials,order_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ], [
            'order_id.unique' => 'Anda sudah pernah memberikan ulasan untuk pesanan ini.'
        ]);

        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403); // Pastikan user adalah pemilik order
        }

        Testimonial::create([
            'user_id' => Auth::id(),
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false, // Default-nya belum disetujui
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda! Testimoni Anda akan kami review terlebih dahulu.');
    }
}