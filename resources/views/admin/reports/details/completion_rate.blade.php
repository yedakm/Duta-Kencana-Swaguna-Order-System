<h4 class="mb-3">📈 Detail Order Completion Rate</h4>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>#ORD{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->customer->name ?? '-' }}</td>
                <td>
                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : 'danger' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>$ {{ number_format($order->total_price, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>