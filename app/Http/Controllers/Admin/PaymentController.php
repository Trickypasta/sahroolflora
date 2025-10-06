<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller // <-- NAMA KELAS BARU
{
    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')->with('user')->latest()->get();
        return view('admin.payments.verify', compact('pendingOrders'));
    }

    public function verify(Order $order)
    {
        if ($order->status == 'pending') {
            $order->update(['status' => 'processing']);
            return back()->with('success', "Pembayaran untuk Pesanan #{$order->id} berhasil diverifikasi.");
        }
        return back()->with('error', "Pesanan #{$order->id} tidak bisa diverifikasi.");
    }
}
