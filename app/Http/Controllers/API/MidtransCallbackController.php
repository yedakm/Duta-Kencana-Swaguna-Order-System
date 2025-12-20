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
        // --- TAMBAHAN BARU UNTUK REFUND ---
        else if ($transactionStatus == 'refund' || $transactionStatus == 'partial_refund') {
            $this->updateStatus($order, 'refunded', $type);
        }
        // ----------------------------------

        return response(['message' => 'Callback received successfully']);
    }

    // Fungsi Helper untuk Update Data dan Poin
   private function updateStatus($order, $status, $paymentMethod = null)
    {
        if ($order->status != $status) {
            
            // Simpan status lama untuk pengecekan
            $oldStatus = $order->status;

            // 1. Update Order
            $order->update(['status' => $status]);

            // 2. Update Transaksi
            $trx = Transaction::where('order_id', $order->id)->first();
            if ($trx) {
                // Mapping status pembayaran
                $payStatus = match($status) {
                    'completed' => 'paid',
                    'refunded' => 'refunded',
                    default => $status
                };
                
                $trx->update([
                    'payment_status' => $payStatus,
                    'payment_method' => $paymentMethod ?? 'midtrans',
                    'updated_at' => now()
                ]);
            }

            // 3. LOGIKA POIN (Tambah atau Tarik Kembali)
            $user = $order->user;
            if ($user) {
                $points = $order->total_price * 0.1; // Rumus poin Anda

                // A. Jika status jadi COMPLETED -> Tambah Poin
                if ($status == 'completed' && $oldStatus != 'completed') {
                    $user->point += $points;
                    $user->save();
                }

                // B. Jika status jadi REFUNDED -> Tarik Poin Kembali
                if ($status == 'refunded' && $oldStatus == 'completed') {
                    // Cek biar poin tidak minus (opsional)
                    if ($user->point >= $points) {
                        $user->point -= $points;
                    } else {
                        $user->point = 0;
                    }
                    $user->save();
                }
            }
        }
    }
}