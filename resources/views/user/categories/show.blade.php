@extends('components.app')

@section('content')

<div class="container py-4">
    <h1 class="text-success mb-4">{{ $category->name }}</h1>

    <div class="row g-4">
        @foreach($foods as $food)
        <div class="col-6 col-md-4">
            <div class="card">
                <img src="{{ asset('storage/' . $food->image) }}" style="height: 200px; object-fit: cover;" class="card-img-top" alt="{{ $food->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">{{ $food->description }}</p>
                    <p class="fw-bold">Rp {{ number_format($food->price, 0, ',', '.') }}</p>

                    <form action="{{ route('member.orders.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                        <button class="btn btn-success btn-sm">
                            <i class="fas fa-shopping-cart me-1"></i> Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if ($foods->hasPages())
    <div class="mt-4">
        {{ $foods->links() }}
    </div>
    @endif
</div>
@endsection

@once
@push('scripts')
<script>
    const currentStatuses = {};

    @foreach ($orders as $order)
        currentStatuses[{{ $order->id }}] = "{{ $order->status }}";
    @endforeach

    setInterval(() => {
        Object.entries(currentStatuses).forEach(([id, oldStatus]) => {
            fetch(`/order-status/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== oldStatus) {
                        currentStatuses[id] = data.status;
                        showNotification(`Status pesanan dengan ID #ORD${id} telah diperbarui ke "${data.status}"`);
                    }
                });
        });
    }, 5000);

    function showNotification(message) {
        const notif = document.createElement('div');
        notif.textContent = message;
        notif.style.position = 'fixed';
        notif.style.bottom = '20px';
        notif.style.right = '20px';
        notif.style.backgroundColor = '#38c172';
        notif.style.color = 'white';
        notif.style.padding = '10px 20px';
        notif.style.borderRadius = '10px';
        notif.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';
        notif.style.zIndex = 9999;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 5000);
    }
</script>
@endpush
@endonce