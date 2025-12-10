@extends('components.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📄 Detail Laporan Order Completion</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#ORD{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->customer->name ?? '-' }}</td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'danger' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>${{ number_format($order->total_price, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection