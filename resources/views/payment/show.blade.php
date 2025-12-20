@extends('components.app')

@section('title', 'Pembayaran Order')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Konfirmasi Pembayaran</h4>
                </div>
                <div class="card-body text-center p-5">
                    <h5 class="text-muted mb-3">Total Tagihan</h5>
                    <h1 class="text-success fw-bold mb-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h1>
                    
                    <p class="mb-1">Order ID: <strong>#ORD{{ $order->id }}</strong></p>
                    <p class="mb-4">Pelanggan: {{ $order->user->name }}</p>

                    <button id="pay-button" class="btn btn-primary btn-lg w-100 rounded-pill">
                        <i class="fas fa-lock me-2"></i> Bayar Sekarang
                    </button>
                    
                    <div class="mt-3">
                        <a href="{{ route('member.orders.index') }}" class="text-muted text-decoration-none small">
                            Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('payment.success', $order->id) }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran!");
                    window.location.reload();
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    window.location.reload();
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
@endpush