<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan sistem TABS.
     */
    public function index(Request $request)
    {
        // Tentukan status yang valid untuk tabs
        $validStatuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        // Ambil status dari URL, default-nya 'pending'
        $status = in_array($request->query('status'), $validStatuses) ? $request->query('status') : 'pending';

        // Ambil data pesanan berdasarkan status yang dipilih
        $orders = Order::with('user')
            ->where('status', $status)
            ->latest()
            ->paginate(15)
            ->withQueryString(); // Agar pagination tetap membawa status

        // Ambil jumlah pesanan untuk setiap status (untuk badge di tabs)
        $statusCounts = Order::selectRaw('status, count(*) as count')
            ->whereIn('status', $validStatuses)
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'status', 'statusCounts'));
    }

    /**
     * Menampilkan detail satu pesanan (tidak perlu diubah, sudah benar).
     */
    public function show(Order $order)
    {
        $order->load('user', 'address', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Aksi 1: Mengkonfirmasi pembayaran (mengubah status dari pending -> processing).
     */
    public function confirmPayment(Order $order)
    {
        if ($order->status == 'pending') {
            $order->update(['status' => 'processing']);
            return back()->with('success', 'Pembayaran berhasil dikonfirmasi. Pesanan siap diproses.');
        }
        return back()->with('error', 'Aksi tidak valid.');
    }

    /**
     * Aksi 2: Mengirim pesanan (mengubah status dari processing -> shipped).
     */
    public function shipOrder(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        if ($order->status == 'processing') {
            $order->update([
                'tracking_number' => $request->tracking_number,
                'status' => 'shipped',
            ]);
            return back()->with('success', 'Nomor resi berhasil ditambahkan dan pesanan ditandai terkirim.');
        }
        return back()->with('error', 'Aksi tidak valid.');
    }

    /**
     * Aksi 3: Menyelesaikan pesanan (mengubah status dari shipped -> completed).
     */
    public function completeOrder(Order $order)
    {
        if ($order->status == 'shipped') {
            $order->update(['status' => 'completed']);
            return back()->with('success', 'Pesanan berhasil diselesaikan.');
        }
        return back()->with('error', 'Aksi tidak valid.');
    }

    /**
     * Aksi 4: Membatalkan pesanan.
     */
    public function cancelOrder(Order $order)
    {
        // Hanya batalkan jika belum selesai
        if (!in_array($order->status, ['completed', 'cancelled'])) {
            $order->update(['status' => 'cancelled']);
            // Di sini lu bisa tambahin logika untuk balikin stok (jika perlu)
            return back()->with('success', 'Pesanan berhasil dibatalkan.');
        }
        return back()->with('error', 'Aksi tidak valid.');
    }
}
