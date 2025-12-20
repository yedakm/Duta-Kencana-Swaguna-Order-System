<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function show(Order $order)
    {
        // Security check
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Jika sudah lunas, langsung redirect history
        if ($order->status == 'completed') {
            return redirect()->route('member.orders.index')->with('success', 'Order ini sudah lunas.');
        }

        // Setup Parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
            ],
        ];

        // Buat Snap Token
        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }

        return view('payment.show', compact('order', 'snapToken'));
    }

    public function success(Order $order)
    {
        return redirect()->route('member.orders.index')->with('success', 'Pembayaran berhasil! Pesanan sedang diproses.');
    }
}