<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();
        return view('admin.payments.index', compact('paymentMethods'));
    }

    public function create()
    {
        return redirect()->route('admin.payment-methods.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payments.edit', compact('paymentMethod'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', 'Metode pembayaran berhasil diupdate!');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return back()->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}