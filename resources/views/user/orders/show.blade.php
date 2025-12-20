@extends('components.app')

@section('title', 'Detail Order #' . $order->id)

@section('content')
<div class="container py-4">
    <h2 class="text-success mb-4">🧾 Detail Pesanan #ORD{{ $order->id }}</h2>

    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Makanan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Jenis Pemesanan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->food->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        <td>
                            @if($item->order_type == 0)
                                <span class="badge bg-info">Dine In</span>
                            @elseif($item->order_type == 1)
                                <span class="badge bg-secondary">Takeaway</span>
                            @else
                                <span class="badge bg-dark">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr class="fw-bold fs-5">
                        <td colspan="3" class="text-end">Total</td>
                        <td colspan="2" class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Status Order: </strong>
                @if($order->status === 'pending')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                @elseif($order->status === 'processing')
                    <span class="badge bg-info">Diproses</span>
                @elseif($order->status === 'completed')
                    <span class="badge bg-success">Selesai</span>
                @elseif($order->status === 'canceled')
                    <span class="badge bg-danger">Dibatalkan</span>
                @elseif($order->status === 'refunded')
                    <span class="badge bg-primary">Refunded</span>
                @endif
            </p>
            
            <p><strong>Status Pembayaran: </strong>
                @if($transaction && $transaction->payment_status === 'paid')
                    <span class="badge bg-success">Lunas</span>
                @elseif($transaction && $transaction->payment_status === 'pending')
                    <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                @else
                    <span class="badge bg-danger">Belum Dibayar</span>
                @endif
            </p>
        </div>
        
        <div class="col-md-6 text-end">
            <a href="{{ route('member.orders.index') }}" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>

            {{-- TOMBOL BAYAR (Hanya muncul jika status pending) --}}
            @if($order->status === 'pending')
                <a href="{{ route('payment.show', $order->id) }}" class="btn btn-success">
                    <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                </a>
            @endif
        </div>
    </div>
</div>
@endsection