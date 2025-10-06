<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Stock;
use App\Models\ContactMessage;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // 1. Pendapatan Bulan Ini
        $revenueThisMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total_amount');

        // 2. Pesanan Baru (Perlu Diproses)
        $newOrdersCount = Order::where('status', 'processing')->count();

        // 3. Pelanggan Baru Bulan Ini
        $newCustomersThisMonthCount = User::whereHas('roles', fn($q) => $q->where('name', 'customer'))
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();
            
        // 4. Pesanan & Rata-rata Nilai Pesanan Bulan Ini
        $ordersThisMonthCount = Order::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $averageOrderValue = $ordersThisMonthCount > 0 ? $revenueThisMonth / $ordersThisMonthCount : 0;
            
        // 5. Data Grafik Penjualan 7 Hari Terakhir
        $salesDataForChart = Order::where('status', 'completed')->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))->where('created_at', '>=', $now->copy()->subDays(6))->groupBy('date')->orderBy('date', 'ASC')->get()->pluck('total', 'date');
        $chartLabels = []; $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = $salesDataForChart[$date->format('Y-m-d')] ?? 0;
        }

        // 6. Produk Terlaris
        $topProducts = DB::table('order_items')->join('products', 'order_items.product_id', '=', 'products.id')->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))->groupBy('products.name')->orderBy('total_sold', 'desc')->limit(5)->get();
            
        // 7. Hitung Keuntungan Bersih (Net Profit) Bulan Ini
        $totalCostThisMonth = DB::table('orders')->join('order_items', 'orders.id', '=', 'order_items.order_id')->join('products', 'order_items.product_id', '=', 'products.id')->where('orders.status', 'completed')->whereYear('orders.created_at', $now->year)->whereMonth('orders.created_at', $now->month)->sum(DB::raw('order_items.quantity * products.cost_price'));
        $totalExpensesThisMonth = Expense::whereYear('expense_date', $now->year)->whereMonth('expense_date', $now->month)->sum('amount');
        $netProfitThisMonth = $revenueThisMonth - $totalCostThisMonth - $totalExpensesThisMonth;
        
        // Data Tambahan Dashboard
        $lowStockProducts = Stock::where('quantity', '<=', 5)->with('product')->get();
        $latestMessages = ContactMessage::latest()->limit(5)->get();

        // Kirim semua data ke view
        return view('admin.dashboard', [
            'revenueThisMonth' => $revenueThisMonth,
            'ordersThisMonthCount' => $ordersThisMonthCount,
            'newCustomersThisMonthCount' => $newCustomersThisMonthCount,
            'averageOrderValue' => $averageOrderValue,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'topProducts' => $topProducts,
            'netProfitThisMonth' => $netProfitThisMonth, // Ini variabel yang penting
            'lowStockProducts' => $lowStockProducts,
            'latestMessages' => $latestMessages
        ]);
    }
}