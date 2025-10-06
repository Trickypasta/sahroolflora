<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ReturnRequestController extends Controller
{
    public function create(Order $order)
    {
        if ($order->user_id !== Auth::id()) { abort(403); }
        return view('returns.create', compact('order'));
    }
    public function store(Request $request)
    {
        $request->validate(['order_id' => 'required|exists:orders,id', 'reason' => 'required|string']);
        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id()) { abort(403); }
        if ($order->returnRequest) { return back()->with('error', 'Anda sudah pernah mengajukan pengembalian.'); }
        $order->returnRequest()->create(['user_id' => Auth::id(), 'reason' => $request->reason]);
        return redirect()->route('orders.show', $order)->with('success', 'Permintaan pengembalian telah dikirim.');
    }
}