<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title text-success">
                Hasil Laporan Penjualan
            </h5>
            <div class="bg-light p-2 rounded border">
                <strong>Total Pendapatan:</strong> 
                <span class="text-success fw-bold fs-5">Rp {{ number_format($totalRevenue, 2, ',', '.') }}</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID Order</th>
                        <th>Customer</th>
                        <th>Tanggal Transaksi</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-bold">#ORD{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-secondary text-white me-2 rounded-circle d-flex justify-content-center align-items-center" style="width: 30px; height: 30px; font-size: 12px;">
                                    {{ substr($order->customer->name ?? 'G', 0, 1) }}
                                </div>
                               {{ $order->user->name ?? 'Guest' }}
                            </div>
                        </td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'canceled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="text-end fw-bold">Rp {{ number_format($order->total_price, 2, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i><br>
                            Tidak ada data transaksi pada periode tanggal ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>