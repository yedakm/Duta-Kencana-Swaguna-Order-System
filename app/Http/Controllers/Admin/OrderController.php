<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::query();

        if (request('status')) {
            $orders->where('status', request('status'));
        }

        if (request('date')) {
            $orders->whereDate('created_at', request('date'));
        }

        $orders = $orders->with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.food']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status'); 
        $order->save();

        


        return back()->with('success', 'Status berhasil diperbarui');
    }

}
