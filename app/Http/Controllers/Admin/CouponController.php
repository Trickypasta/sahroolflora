<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'nullable|numeric|required_if:type,fixed',
            'percent_off' => 'nullable|numeric|required_if:type,percent',
        ]);

        Coupon::create($request->all());

        return back()->with('success', 'Kupon berhasil dibuat!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success', 'Kupon berhasil dihapus.');
    }
}