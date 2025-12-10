@extends('components.app')

@section('styles')
<style>
    .dashboard-card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .category-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .category-card:hover {
        transform: scale(1.03);
    }

    .category-card img {
        transition: transform 0.5s ease;
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        color: white;
        padding: 20px 15px 15px;
    }

    .promo-carousel .carousel-item {
        border-radius: 15px;
        overflow: hidden;
        height: 300px;
    }

    .promo-carousel .carousel-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .food-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .food-card-img {
        height: 180px;
        object-fit: cover;
    }

    .order-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    .stats-card {
        border-radius: 15px;
        padding: 20px;
        color: white;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .stats-card::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
    }

    .stats-card i {
        font-size: 2.5rem;
        opacity: 0.3;
        position: absolute;
        top: 20px;
        right: 20px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="display-4 text-success fw-bold mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                    <p class="lead text-muted mb-0">Apa yang ingin kamu pesan hari ini?</p>
                </div>
                <div class="mt-3 mt-md-0 d-flex align-items-center gap-3">
                    <a href="{{ route('member.foods.index') }}" class="btn btn-success btn-lg px-4">
                        <i class="fas fa-plus me-2"></i> Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-4">
            <div class="stats-card bg-primary">
                <h5 class="fw-bold">Poin Saya</h5>
                <h2 class="fw-bold">{{ number_format($userPoints) }}</h2>
                <p>Dapat ditukar dengan promo</p>
                <i class="fas fa-coins"></i>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stats-card bg-success">
                <h5 class="fw-bold">Pesanan Aktif</h5>
                <h2 class="fw-bold">{{ $activeOrdersCount }}</h2>
                <p>Sedang diproses</p>
                <i class="fas fa-truck"></i>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stats-card bg-info">
                <h5 class="fw-bold">Total Pesanan</h5>
                <h2 class="fw-bold">{{ $totalOrdersCount }}</h2>
                <p>Sejak bergabung</p>
                <i class="fas fa-history"></i>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-success mb-0">Promo Spesial untuk Kamu</h3>
                <a href="#" class="text-success">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel">
                <div class="carousel-inner rounded-3">
                    <div class="carousel-item active">
                        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80"
                            class="d-block w-100" alt="Promo 1">
                        <div class="carousel-caption d-md-block text-start" style="bottom: 80px;">
                            <h3 class="fw-bold">Diskon 30%</h3>
                            <p>Untuk semua menu salad hingga akhir bulan</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80"
                            class="d-block w-100" alt="Promo 2">
                        <div class="carousel-caption d-md-block text-start" style="bottom: 80px;">
                            <h3 class="fw-bold">Paket Keluarga</h3>
                            <p>Diskon 25% untuk pesanan di atas Rp 200.000</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-success mb-0">Kategori Makanan</h3>
                <a href="{{ route('member.categories.index') }}" class="text-success">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
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
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-success mb-0">Rekomendasi untuk Anda</h3>
                <a href="{{ route('member.foods.index') }}" class="text-success">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach($recommendedFoods as $food)
                <div class="col d-flex">
                    <div class="card shadow-sm food-card flex-fill d-flex flex-column">
                        <img src="{{ asset('storage/' . $food->image) }}"
                            class="food-card-img"
                            alt="{{ $food->slug }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $food->name }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($food->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="text-success fw-semibold">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="text-success mb-0">Riwayat Pesanan Terakhir</h3>
                <a href="{{ route('member.orders.cart') }}" class="text-success">Lihat Semua <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="card dashboard-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Tanggal</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="fw-bold">#ORD{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>{{ $order->items_count }} items</td>
                                    <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span id="order-status-{{ $order->id }}" class="badge order-badge 
                                            {{ $order->status === 'completed' ? 'bg-success' : '' }}
                                            {{ $order->status === 'canceled' ? 'bg-danger' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-info' : '' }}
                                            {{ $order->status === 'pending' ? 'bg-warning' : '' }}">

                                            @switch($order->status)
                                                @case('completed')
                                                    selesai
                                                    @break
                                                @case('canceled')
                                                    dibatalkan
                                                    @break
                                                @case('processing')
                                                    diproses
                                                    @break
                                                @default
                                                    menunggu
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@once
@push('scripts')
<script>
    const currentStatuses = {};

    @foreach ($recentOrders as $order)
        currentStatuses[{{ $order->id }}] = "{{ $order->status }}";
    @endforeach

    setInterval(() => {
        Object.entries(currentStatuses).forEach(([id, oldStatus]) => {
            fetch(`/order-status/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status !== oldStatus) {
                        currentStatuses[id] = data.status;
                        updateStatusDisplay(id, data.status);
                        showNotification(`Status pesanan dengan ID #ORD${id} telah diperbarui ke "${data.status}"`);
                    }
                });
        });
    }, 5000);

    function updateStatusDisplay(id, status) {
        const statusElem = document.getElementById(`order-status-${id}`);
        if (!statusElem) return;

        statusElem.textContent = status;

        statusElem.className = 'badge order-badge'; 
        switch (status.toLowerCase()) {
            case 'completed':
                statusElem.textContent = 'selesai';
                statusElem.classList.add('bg-success', 'text-white');
                break;
            case 'processing':
                statusElem.textContent = 'diproses';
                statusElem.classList.add('bg-info', 'text-white');
                break;
            case 'pending':
                statusElem.textContent = 'menunggu';
                statusElem.classList.add('bg-warning', 'text-white');
                break;
            case 'canceled':
                statusElem.textContent = 'dibatalkan';
                statusElem.classList.add('bg-danger', 'text-white');
                break;
            default:
                statusElem.classList.add('bg-info', 'text-white');
        }
    }

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