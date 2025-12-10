@extends('components.app')
@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-4">
    @if(session('success'))
    <div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="orderSuccessModalLabel">Berhasil!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="mb-4">
        <h1 class="display-5 fw-bold text-success">Detail Pesanan #ORD{{ $order->id }}</h1>
        <p class="text-muted">Informasi lengkap pesanan pelanggan</p>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white fw-bold">Informasi Pemesan</div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-white fw-bold">Status Pesanan</div>
        <div class="card-body">
            @php
            $badge = match($order->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'canceled' => 'danger',
            default => 'secondary'
            };
            @endphp
            <p>
                <span class="badge bg-{{ $badge }}">{{ ucfirst($order->status) }}</span>
            </p>

            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mt-3">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-center">
                    <label for="status" class="form-label me-2 mb-0">Ubah Status:</label>
                    <select name="status" class="form-select w-auto me-2">
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white fw-bold">Item Pesanan</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Makanan</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->food->name }}</td>
                        <td>Rp {{ number_format($item->price, 2, '.', ',') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->quantity, 2, '.', ',') }}</td>
                        @php $total += $item->price * $item->quantity; @endphp
                    </tr>
                    @endforeach
                    <tr class="table-light fw-bold">
                        <td colspan="4" class="text-end">Total</td>
                        <td>Rp {{ number_format($total, 2, '.', ',') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#orderSuccessModal').modal('show');
    });
</script>
@endpush