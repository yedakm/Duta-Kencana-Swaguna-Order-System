@extends('components.app')

@section('content')
<div class="container-fluid py-4">
    <div class="modal fade" id="confirmDeleteCustomerModal" tabindex="-1" aria-labelledby="confirmDeleteCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteCustomerModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus customer <strong id="customerName"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteCustomerForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-4 text-success fw-bold">Detail Pelanggan</h1>
            <p class="lead text-muted">Informasi pelanggan dan riwayat pesanan</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">Data Pelanggan</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>No. HP:</strong> {{ $user->phone }}</li>
                <li class="list-group-item"><strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d M Y') }}</li>
            </ul>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Riwayat Pesanan</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#ORD{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>Rp {{ number_format($order->total_price, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'completed') bg-success 
                                    @elseif($order->status == 'pending') bg-warning 
                                    @else bg-danger @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-outline-danger"
                    data-id="{{ $user->id }}"
                    data-name="{{ $user->name }}"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteCustomerModal">
                    <i class="fas fa-trash-alt me-1"></i> Hapus Customer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButton = document.querySelector('[data-bs-target="#confirmDeleteCustomerModal"]');
        const customerName = document.getElementById('customerName');
        const deleteForm = document.getElementById('deleteCustomerForm');

        if (deleteButton) {
            deleteButton.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');

                customerName.textContent = name;
                deleteForm.action = `/admin/customers/${id}`;
            });
        }
    });
</script>
@endpush