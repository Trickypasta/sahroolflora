<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shippingMethods = ShippingMethod::all();
        return view('admin.shipping.index', compact('shippingMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
        ]);

        ShippingMethod::create($request->all());

        return back()->with('success', 'Metode pengiriman berhasil ditambahkan!');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return back()->with('success', 'Metode pengiriman berhasil dihapus.');
    }
}
