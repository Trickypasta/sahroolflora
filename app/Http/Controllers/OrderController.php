<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        // Ganti get() menjadi paginate(). Angka 10 adalah jumlah pesanan per halaman.
        $orders = Auth::user()->orders()
            ->with('returnRequest')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Menampilkan halaman detail pesanan & pembayaran
    public function show(Order $order)
    {
        // Pastikan hanya pemilik pesanan yang bisa melihat halaman ini
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.show', compact('order'));
    }

    // Mengkonfirmasi pembayaran (simulasi)
    public function showTrackForm()
    {
        return view('orders.track');
    }

    // Method untuk mencari dan menampilkan hasil
    public function findOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'email' => 'required|email', 
        ]);

        // Cari pesanan berdasarkan ID DAN email
        $order = Order::where('id', $request->order_id)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->first();

        if ($order) {
            return view('orders.track', compact('order'));
        } else {
            return back()->with('error', 'Kombinasi ID Pesanan dan Email tidak ditemukan.');
        }
    }
}
