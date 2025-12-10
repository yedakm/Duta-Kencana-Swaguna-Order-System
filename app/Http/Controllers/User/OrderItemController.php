<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;

class OrderItemController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $orders = Order::withCount('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();


        $statusNotif = null;

        foreach (session()->all() as $key => $val) {
            if (Str::startsWith($key, 'status_updated_for_user_id_')) {
                $userId = str_replace('status_updated_for_user_id_', '', $key);
                if ((int) $userId === auth()->id()) {
                    $statusNotif = $val;
                    break;
                }
            }
        }
        return view('user.orders.index', compact('cart', 'orders', 'statusNotif'));
    }

    public function show($id)
    {
        $order = Order::with('items.food')->findOrFail($id);
        $transaction = Transaction::where('order_id', $order->id)->first();
        return view('user.orders.show', compact('order', 'transaction'));
    }

    public function addToCart(Request $request)
    {
        $food = Food::findOrFail($request->food_id);

        $cart = session()->get('cart', []);

        $request->validate([
            'orderType' => 'required|in:dine_in,takeaway',
        ]);

        if (isset($cart[$food->id])) {
            $cart[$food->id]['quantity'] += 1;
        } else {
            $cart[$food->id] = [
                'name' => $food->name,
                'price' => $food->price,
                'quantity' => 1,
                'orderType' => $request->orderType,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Makanan ditambahkan ke keranjang.');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->food_id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function updateCart(Request $request)
    {
        $foodId = $request->input('food_id');
        $quantity = max(1, (int) $request->input('quantity'));

        $cart = session()->get('cart', []);

        if (!isset($cart[$foodId])) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Item tidak ditemukan di keranjang.'], 404);
            }
            return back()->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $cart[$foodId]['quantity'] = $quantity;
        session()->put('cart', $cart);

        $subtotal = $cart[$foodId]['price'] * $quantity;
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total' => $total,
            ]);
        }

        return back()->with('success', 'Jumlah makanan diperbarui.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            return back()->with('error', 'Keranjang Anda kosong.');
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;

        foreach ($cart as $food_id => $item) {
            $itemPrice = floatval(str_replace(',', '', $item['price']));

            $orderTypeValue = $item['orderType'] === 'takeaway' ? 1 : 0;

            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $food_id,
                'user_id' => auth()->id(),
                'quantity' => $item['quantity'],
                'price' => $itemPrice,
                'order_type' => $orderTypeValue,
            ]);

            $total += $itemPrice * $item['quantity'];
        }

        $order->update(['total_price' => $total]);

        Transaction::create([
            'invoice_id' => Str::uuid(),
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'payment_method' => null,
            'amount' => $total,
            'payment_status' => 'pending',
        ]);

        session()->forget('cart');

        return redirect()->route('member.orders.show', $order->id)->with('success', 'Checkout berhasil! Mohon lanjutkan pembayaran🙏');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }


    public function pay(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        Transaction::updateOrCreate(
            ['order_id' => $order->id],
            [
                'user_id' => auth()->id(),
                'transaction_date' => now(),
                'payment_method' => $request->payment_method,
                'payment_status' => 'paid'
            ]
        );

        $order->status = 'processing';
        $order->save();

        $user = $order->user;

        $user->point += $order->total_price * 0.1;
        $user->save();

        return response()->json(['success' => true]);
    }
}
