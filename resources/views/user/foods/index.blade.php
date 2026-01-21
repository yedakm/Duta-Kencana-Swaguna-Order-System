@extends('components.app')

@section('title', 'Our Menus')
@section('content')
<div class="modal fade" id="orderTypeModal" tabindex="-1" aria-labelledby="orderTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="orderModalLabel">Pilih Opsi Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                    <p class="fs-5">Silakan pilih opsi pemesanan Anda:</p>
                </div>
                <div class="d-grid gap-3">
                    <button class="btn btn-success btn-lg py-3 select-order-type" id="takeawayBtn" data-type="takeaway">

                        <i class="fas fa-shopping-bag me-2"></i> Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="text-success fw-bold mb-2">Daftar Menu</h1>
            <p class="text-muted">Temukan berbagai pilihan makanan lezat untuk dipesan</p>
        </div>
        <div class="d-flex">
            <div class="cart-icon position-relative me-3">
                <a href="{{ route('member.orders.index') }}" class="btn btn-success rounded-circle p-2">
                    <i class="fas fa-shopping-cart fs-5"></i>
                </a>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    @if(session('cart') && count(session('cart')) > 0)
                        {{ count(session('cart')) }}
                    @else
                        0
                    @endif
                    <span class="visually-hidden">Items in cart</span>
                </span>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4" id="filterCard">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <form action="{{ route('member.foods.index') }}" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control form-control-lg"
                                placeholder=" Cari menu..." value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <form action="{{ route('member.foods.index') }}" method="GET">
                        @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif

                        <div class="input-group">
                            <span class="input-group-text bg-success text-white">
                                <i class="fas fa-tag"></i>
                            </span>
                            <select class="form-select form-select-lg" name="category">
                                <option value="">&nbsp;Semua Kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}"
                                    {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-success" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
        @foreach($foods as $food)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 overflow-hidden">
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $food->image) }}" 
                         class="card-img-top" 
                         alt="{{ $food->name }}"
                         style="height: 200px; object-fit: cover;">
                </div>
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0">{{ $food->name }}</h5>
                        <span class="badge bg-success bg-opacity-10 text-success">
                            {{ $food->category->name }}
                        </span>
                    </div>
                    
                    <p class="card-text text-muted small mb-3 food-description">
                        {{ $food->description }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="fw-bold text-success fs-5">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <form action="{{ route('member.orders.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                        <input type="hidden" name="orderType" value="" class="order-type-input">

                        <button type="button" class="btn btn-success btn-sm add-to-cart-btn"
                            data-food-id="{{ $food->id }}">
                            <i class="fas fa-shopping-cart me-1"></i> Tambah ke Keranjang
                        </button>
                    </form>   
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($foods->isEmpty())
    <div class="text-center py-5">
        <div class="py-5">
            <i class="fas fa-utensils fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">Tidak ada makanan ditemukan</h4>
            <p class="text-muted mb-4">Coba kata kunci lain atau filter kategori berbeda</p>
            <a href="{{ route('member.foods.index') }}" class="btn btn-success px-4">
                <i class="fas fa-sync me-2"></i> Reset Pencarian
            </a>
        </div>
    </div>
    @endif

    @if ($foods->hasPages())
    <div class="mt-5">
        <nav aria-label="Food pagination">
            {{ $foods->links() }}
        </nav>
    </div>
    @endif
</div>


<style>
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .food-description {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 40px;
    }
    
    .cart-icon .badge {
        font-size: 0.7rem;
        padding: 0.35em 0.6em;
    }
    
    .input-group-text {
        border: none;
    }
    
    .form-control, .form-select {
        border-left: none;
        padding-left: 0;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    
    .card-img-top {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }
    
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .badge {
        font-weight: 500;
    }
    
    .pagination .page-link {
        color: #000000;
        border: 1px solid #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .pagination .page-link:hover {
        color: #000000;
        background-color: #e9ecef;
    }
    
    @media (max-width: 768px) {
        .input-group-text, .form-select, .form-control {
            font-size: 1rem !important;
        }
        
        .btn {
            padding: 0.5rem 1rem;
        }
        
        h1 {
            font-size: 1.75rem;
        }
        
        .card-body {
            padding: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        #filterCard {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            margin-bottom: 0;
            border-radius: 16px 16px 0 0;
            display: none;
        }
        
        #filterCard.active {
            display: block;
            animation: slideUp 0.3s ease-out;
        }
        
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        
        .row-cols-sm-2 > .col {
            flex: 0 0 auto;
            width: 100%;
        }
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentForm = null;

        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                currentForm = this.closest('form');
                const modal = new bootstrap.Modal(document.getElementById('orderTypeModal'));
                modal.show();
            });
        });

        document.querySelectorAll('.select-order-type').forEach(button => {
            button.addEventListener('click', function () {
                const orderType = this.getAttribute('data-type');
                if (currentForm) {
                    currentForm.querySelector('.order-type-input').value = orderType;
                    currentForm.submit();
                }
            });
        });

        const filterToggle = document.getElementById('filterToggle');
        const filterCard = document.getElementById('filterCard');

        if (filterToggle && filterCard) {
            filterToggle.addEventListener('click', () => {
                filterCard.classList.toggle('active');
            });
        }

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 576 &&
                filterCard &&
                filterCard.classList.contains('active') &&
                !filterCard.contains(e.target) &&
                e.target !== filterToggle) {
                filterCard.classList.remove('active');
            }
        });
    });
</script>
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
@endsection