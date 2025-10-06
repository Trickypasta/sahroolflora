<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Menampilkan semua testimoni
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    // Menyetujui testimoni
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);
        return back()->with('success', 'Testimoni berhasil disetujui!');
    }

    // Menghapus testimoni
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus!');
    }
}