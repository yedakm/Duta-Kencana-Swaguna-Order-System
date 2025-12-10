@extends('components.app')

@section('title', 'Our Menu Categories')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-success mb-0">Daftar Kategori</h1>
        <span class="text-muted">{{ $categories->total() }} kategori tersedia</span>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($categories as $category)
        <div class="col">
            <a href="{{ route('member.categories.show', $category->id) }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 border-0 hover-shadow transition">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-2x text-success mb-2"></i>
                        <h5 class="card-title text-dark fw-semibold">{{ $category->name }}</h5>
                        <p class="text-muted small mb-0">{{ $category->foods_count }} menu tersedia</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $categories->links() }}
    </div>
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