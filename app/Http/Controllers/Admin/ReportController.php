<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $topCustomer = User::withCount('orders')
            ->orderByDesc('orders_count')
            ->first();

        $topFood = Food::select('foods.id', 'foods.name', 'foods.image')
            ->join('order_items', 'order_items.food_id', '=', 'foods.id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('foods.id', 'foods.name', 'foods.image')
            ->orderByDesc('total_sold')
            ->first();

        $monthlyRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');

        $topCategory = Category::select('categories.id', 'categories.name')
            ->join('foods', 'foods.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.food_id', '=', 'foods.id')
            ->selectRaw('SUM(order_items.quantity) as total_orders')
            ->whereMonth('order_items.created_at', now()->month)
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_orders')
            ->first();

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

    public function load($type)
    {
        if (!in_array($type, ['top-customer', 'top-food', 'completion-rate', 'top-category', 'monthly-revenue'])) {
            return response('Laporan tidak ditemukan.', 404);
        }

        $data = $this->getReportData($type);

        return view("admin.reports.details." . str_replace('-', '_', $type), $data);
    }

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
                'orders' => Order::with('customer')
                    ->whereIn('status', ['completed', 'canceled'])
                    ->latest()
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
                    ->whereYear('created_at', now()->year)
                    ->groupByRaw('MONTH(created_at)')
                    ->orderBy('month')
                    ->get()
            ]
        };
    }
}
