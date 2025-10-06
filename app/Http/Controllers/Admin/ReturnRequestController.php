<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
class ReturnRequestController extends Controller
{
    public function index() {
        $requests = ReturnRequest::with('user', 'order')->latest()->get();
        return view('admin.returns.index', compact('requests'));
    }
    public function update(Request $request, ReturnRequest $returnRequest) {
        $request->validate(['status' => 'required|string|in:pending,approved,rejected']);
        $returnRequest->update(['status' => $request->status]);
        return back()->with('success', 'Status pengembalian diupdate!');
    }
}