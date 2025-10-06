<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return back()->with('error', 'Kode kupon tidak valid!');
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'percent_off' => $coupon->percent_off
        ]);

        return back()->with('success', 'Kupon berhasil diterapkan!');
    }

    public function remove()
    {
        session()->forget('coupon');
        return back()->with('success', 'Kupon berhasil dihapus.');
    }

    public function index()
    {
        // Ambil semua kupon dari database
        $coupons = \App\Models\Coupon::all();
        return view('coupons.index', compact('coupons'));
    }
}
