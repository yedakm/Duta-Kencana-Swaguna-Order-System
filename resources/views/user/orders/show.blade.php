@extends('components.app')

@section('content')
<div class="container py-4">
    <h2 class="text-success mb-4">🧾 Detail Pesanan #ORD{{ $order->id }}</h2>

    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

    <table class="table table-striped mt-3">
        <thead>
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
            <tr class="fw-bold">
                <td colspan="4" class="text-end">Total</td>
                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Status Order: </strong>
        @if($order->status === 'pending')
        <span class="badge bg-warning">Menunggu</span>
        @elseif($order->status === 'processing')
        <span class="badge bg-info">Diproses</span>
        @elseif($order->status === 'completed')
        <span class="badge bg-success">Selesai</span>
        @elseif($order->status === 'canceled')
        <span class="badge bg-danger">Dibatalkan</span>
        @endif
    </p>

    <p><strong>Status Pembayaran: </strong>
        @if($transaction->payment_status === 'paid')
        <span class="badge bg-success">Lunas</span>
        @elseif($transaction->payment_status === 'pending')
        <span class="badge bg-warning">Menunggu Pembayaran</span>
        @else
        <span class="badge bg-danger">Belum Dibayar</span>
        @endif
    </p>

    <a href="{{ route('member.orders.index') }}" class="btn btn-success mt-3">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Pesanan
    </a>
    @if($order->status === 'pending')
    <div class="mt-3 text-end">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Pay Now
                </button>
            </div>
    @endif
</div>
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="paymentForm" method="POST" action="{{ route('member.orders.pay', $order->id) }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" id="qris" value="QRIS" required>
            <label class="form-check-label" for="qris">
            <img src="{{ asset('logo/qris.png') }}" alt="QRIS" width="120" class="me-2">
            QRIS
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" id="debit" value="Debit Card" required>
            <label class="form-check-label" for="debit">
                <img src="{{ asset('logo/debitcard.png') }}" alt="debit" width="150" class="me-2">
                Debit Card
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" id="credit" value="Credit Card" required>
            <label class="form-check-label" for="credit">
                <img src="{{ asset('logo/creditcard.png') }}" alt="credit" width="150" class="me-2">
                Credit Card
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment_method" id="ewallet" value="e-Wallet" required>
            <label class="form-check-label" for="ewallet">
                <img src="{{ asset('logo/ewallet.png') }}" alt="ewallet" width="150" class="me-2">
            E-Wallet
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Bayar</button>
        </div>
      </form>
    </div>
  </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('paymentForm').onsubmit = function(e) {
    e.preventDefault();
    var form = this;
    var data = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: data
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            var paymentModal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
            paymentModal.hide();

            setTimeout(function() {
                Swal.fire({
                    title: 'Transaksi Berhasil!',
                    text: 'Pembayaran kamu telah diterima.',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                }).then(() => {
                    window.location.href = "{{ route('member.orders.show', $order->id) }}";
                });
            }, 400);
        }
    });
};
</script>
@endpush



@endsection
