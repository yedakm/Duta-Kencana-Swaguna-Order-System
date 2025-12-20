<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\Category;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard laporan (Summary Cards).
     */
    public function index()
    {
        // 1. Top Customer (User dengan order terbanyak)
        $topCustomer = User::withCount('orders')
            ->orderByDesc('orders_count')
            ->first();

        // 2. Top Food (Makanan paling laku terjual)
        $topFood = Food::select('foods.id', 'foods.name', 'foods.image')
            ->join('order_items', 'order_items.food_id', '=', 'foods.id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('foods.id', 'foods.name', 'foods.image')
            ->orderByDesc('total_sold')
            ->first();

        // 3. Monthly Revenue (Pendapatan bulan ini)
        $monthlyRevenue = Order::where('status', 'completed') // Pastikan hanya yang completed
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        // 4. Top Category (Kategori terlaris bulan ini)
        $topCategory = Category::select('categories.id', 'categories.name')
            ->join('foods', 'foods.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.food_id', '=', 'foods.id')
            ->selectRaw('SUM(order_items.quantity) as total_orders')
            ->whereMonth('order_items.created_at', now()->month)
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_orders')
            ->first();

        // 5. Statistik Completion Rate
        $totalOrders = Order::count();
        $completedOrders = Order::where('status', 'completed')->count();
        $canceledOrders = Order::where('status', 'canceled')->count();
        
        $completionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0;
        $cancelRate = $totalOrders > 0 ? round(($canceledOrders / $totalOrders) * 100, 2) : 0;

        return view('admin.reports.index', compact(
            'topCustomer',
            'topFood',
            'monthlyRevenue',
            'topCategory',
            'completionRate',
            'cancelRate'
        ));
    }

    /**
     * Memuat partial view berdasarkan jenis laporan yang diklik (AJAX).
     */
    public function load($type)
    {
        // Daftar laporan yang valid
        $validReports = ['top-customer', 'top-food', 'completion-rate', 'top-category', 'monthly-revenue', 'sales-period'];

        if (!in_array($type, $validReports)) {
            return response('Laporan tidak ditemukan.', 404);
        }

        // KHUSUS: Jika tipe adalah 'sales-period', kembalikan view filter input tanggal
        if ($type === 'sales-period') {
            return view('admin.reports.partials.sales_filter');
        }

        // UNTUK YANG LAIN: Ambil data dari database
        $data = $this->getReportData($type);

        // Kembalikan view detail sesuai tipe
        // Contoh: top-customer -> admin.reports.details.top_customer
        return view("admin.reports.details." . str_replace('-', '_', $type), $data);
    }

    /**
     * Memproses Filter Tanggal Penjualan (AJAX).
     */
    public function filterSales(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Ambil data order yang 'completed' dalam rentang tanggal tersebut
        // Menggunakan with('customer') atau 'user' tergantung nama relasi di model Order Anda
        $orders = Order::with('user') 
            ->where('status', 'completed')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_price');

        // Kembalikan partial view tabel hasil
        return view('admin.reports.partials.sales_table', compact('orders', 'totalRevenue'));
    }

    /**
     * Helper untuk mengambil data detail berdasarkan tipe laporan.
     */
    protected function getReportData($type)
    {
        return match ($type) {
            'top-customer' => [
                'customers' => User::withCount('orders')
                    ->orderByDesc('orders_count')
                    ->take(10)
                    ->get()
            ],

            'top-food' => [
                'foods' => Food::select('foods.id', 'foods.name', 'foods.image', DB::raw('SUM(order_items.quantity) as total_sold'))
                    ->join('order_items', 'order_items.food_id', '=', 'foods.id')
                    ->groupBy('foods.id', 'foods.name', 'foods.image')
                    ->orderByDesc('total_sold')
                    ->take(10)
                    ->get()
            ],

            'completion-rate' => [
                'orders' => Order::with('user') // Pastikan relasi user/customer dimuat
                    ->whereIn('status', ['completed', 'canceled'])
                    ->latest()
                    ->take(50) // Batasi biar tidak terlalu berat
                    ->get()
            ],

            'top-category' => [
                'categories' => Category::select('categories.id', 'categories.name', DB::raw('SUM(order_items.quantity) as total_orders'))
                    ->join('foods', 'foods.category_id', '=', 'categories.id')
                    ->join('order_items', 'order_items.food_id', '=', 'foods.id')
                    ->whereMonth('order_items.created_at', now()->month)
                    ->groupBy('categories.id', 'categories.name')
                    ->orderByDesc('total_orders')
                    ->take(10)
                    ->get()
            ],

            'monthly-revenue' => [
                'revenues' => Order::selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
                    ->where('status', 'completed')
                    ->whereYear('created_at', now()->year)
                    ->groupByRaw('MONTH(created_at)')
                    ->orderBy('month')
                    ->get()
            ],
            
            default => []
        };
    }
}