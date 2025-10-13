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
        $request->validate(['order_id' => 'required|integer']);

        $order = Order::find($request->order_id);

        if ($order) {
            return view('orders.track', compact('order'));
        } else {
            return view('orders.track', ['error' => 'Pesanan dengan ID tersebut tidak ditemukan.']);
        }
    }
}
