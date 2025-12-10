@extends('components.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="text-success mb-0">{{ $category->name }}</h1>
            <span class="text-muted">{{ $foods->total() }} items available</span>
        </div>
        <a href="{{ route('guest.categories.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Back to Category
        </a>
    </div>

    <div class="row g-3">
        @foreach ($foods as $food)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="row g-0 align-items-center">
                    <div class="col-4">
                        <img src="{{ asset('storage/' . $food->image) }}" class="img-fluid rounded-start" alt="{{ $food->name }}" style="height:100px; object-fit:cover;">
                    </div>
                    <div class="col-8">
                        <div class="card-body position-relative pt-3 pb-1">
                            <span class="badge bg-light-success text-success position-absolute top-0 end-0 mt-2 me-2 rounded-pill px-3 py-2 shadow-sm">
                                Rp {{ number_format($food->price, 0, ',', '.') }}
                            </span>
                            <h6 class="text-muted mb-1">{{ $category->name }}</h6>
                            <h5 class="card-title mb-1">{{ $food->name }}</h5>
                            <p class="card-text small text-muted mb-1">{{ Str::limit($food->description, 60) }}</p>
                            <div class="justify-content-center align-items-center">
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fas fa-shopping-cart me-1"></i> Pesan
                                </button>
                            </div>
                        </div>
                    </div>
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


<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Diperlukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center">
                <p>Silakan login terlebih dahulu untuk melakukan pemesanan.</p>
                <a href="{{ route('register.page') }}" class="btn btn-primary">Login / Daftar</a>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-success {
        background-color: #e6f4ea;
    }
</style>
@endsection