<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function revenue(Request $request)
    {
        // 1. Tentukan rentang tanggal
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        // 2. Ambil data pesanan dan hitung total PENDAPATAN
        $orders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, Carbon::parse($endDate)->endOfDay()])
            ->with('user')
            ->latest()
            ->get();
        $totalRevenue = $orders->sum('total_amount');

        // 3. Ambil data pengeluaran dan hitung total PENGELUARAN
        $totalExpenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->sum('amount');

        // 4. BARU hitung KEUNTUNGAN BERSIH
        $netProfit = $totalRevenue - $totalExpenses;

        // 5. Kirim semua data ke view
        return view('admin.reports.revenue', compact(
            'orders',
            'totalRevenue',
            'startDate',
            'endDate',
            'totalExpenses',
            'netProfit'
        ));
    }

    public function analytics(Request $request)
    {
        // 1. Tentukan rentang tanggal
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::now()->startOfMonth();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : Carbon::now()->endOfMonth();

        // 2. Ambil data pesanan sesuai rentang tanggal
        $ordersQuery = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate->copy()->endOfDay()]);

        // 3. Hitung statistik penjualan
        $totalRevenue = $ordersQuery->sum('total_amount');
        $orders = $ordersQuery->get();

        // 4. Ambil produk terlaris pada periode tersebut
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)->get();

        // 5. Siapkan data untuk grafik penjualan harian
        $salesDataForChart = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')->orderBy('date', 'ASC')->pluck('total', 'date');

        $chartLabels = [];
        $chartData = [];
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $chartLabels[] = $currentDate->format('d M');
            $chartData[] = $salesDataForChart[$currentDate->format('Y-m-d')] ?? 0;
            $currentDate->addDay();
        }

        // 6. Kirim semua data ke view
        return view('admin.reports.analytics', [
            'orders' => $orders,
            'totalRevenue' => $totalRevenue,
            'topProducts' => $topProducts,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }

    public function topCustomers()
    {
        $topCustomers = User::whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        })
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->withSum(['orders' => function ($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->take(10) // Ambil 10 customer teratas
            ->get();

        // Ubah nama kolom agar lebih mudah dibaca di view
        $topCustomers = $topCustomers->map(function ($customer) {
            $customer->total_spent = $customer->orders_sum_total_amount;
            return $customer;
        });

        return view('admin.reports.customers', compact('topCustomers'));
    }
}
