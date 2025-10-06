<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->get();
        return view('admin.stocks.index', compact('stocks'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $stock->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Stok berhasil diupdate!');
    }
}
