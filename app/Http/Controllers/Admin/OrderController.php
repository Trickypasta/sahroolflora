<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    // Menampilkan detail satu pesanan
    public function show(Order $order)
    {
        // Eager load relasi untuk efisiensi query
        $order->load('user', 'address', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Mengupdate status pesanan
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diupdate!');
    }

    public function addTrackingNumber(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'status' => 'shipped', // Otomatis ubah status jadi 'dikirim'
        ]);

        return back()->with('success', 'Nomor resi berhasil ditambahkan dan status diubah menjadi Dikirim.');
    }
}
