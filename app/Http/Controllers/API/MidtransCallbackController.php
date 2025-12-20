<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // Konfigurasi Server Key
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response(['message' => 'Invalid notification'], 400);
        }

        $transactionStatus = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Cari Order
        $order = Order::find($orderId);
        if (!$order) {
            return response(['message' => 'Order not found'], 404);
        }

        // Logic Status Midtrans
        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $this->updateStatus($order, 'pending');
                } else {
                    $this->updateStatus($order, 'completed', $type);
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $this->updateStatus($order, 'completed', $type);
        } else if ($transactionStatus == 'pending') {
            $this->updateStatus($order, 'pending');
        } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $this->updateStatus($order, 'canceled');
        }

        return response(['message' => 'Callback received successfully']);
    }

    // Fungsi Helper untuk Update Data dan Poin
    private function updateStatus($order, $status, $paymentMethod = null)
    {
        // Cek dulu apakah statusnya berubah dari yang lama
        if ($order->status != $status) {
            
            // 1. Update Order
            $order->update(['status' => $status]);

            // 2. Update Transaksi
            $trx = Transaction::where('order_id', $order->id)->first();
            if ($trx) {
                $paymentStatus = ($status == 'completed') ? 'paid' : $status;
                $trx->update([
                    'payment_status' => $paymentStatus,
                    'payment_method' => $paymentMethod ?? 'midtrans',
                    'transaction_date' => now()
                ]);
            }

            // 3. TAMBAH POIN USER (Hanya jika status berubah jadi Completed)
            if ($status == 'completed') {
                $user = $order->user;
                if ($user) {
                    $user->point += $order->total_price * 0.1; // Logika poin Anda
                    $user->save();
                }
            }
        }
    }
}