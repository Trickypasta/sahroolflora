<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        // Ambil SEMUA testimoni, dengan relasi ke user & produk, lalu paginasi
        $testimonials = Testimonial::with(['user', 'product'])->latest()->paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);
        return back()->with('success', 'Ulasan berhasil disetujui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
