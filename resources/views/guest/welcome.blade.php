@extends('components.app')

@section('content')

@if(session('showLoginModal'))
<script>
    window.onload = () => {
        const modal = new bootstrap.Modal(document.getElementById('loginModal'));
        modal.show();
    };
</script>
@endif

<link rel="stylesheet" href="{{ asset('css/guest.css') }}">
<section class="hero-section py-5" style="background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80'); background-size: cover; min-height: 80vh;">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-6">
                <h1 class="display-3 fw-bold text-success mb-4">DeliGreen</h1>
                <p class="lead mb-4">Makan sehat jadi mudah dengan pesanan online kami. Mulai hidup sehat hari ini!</p>
                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                    <a href="{{ route('guest.foods.index') }}" class="btn btn-outline-success btn-lg px-4">
                        <i class="bi bi-egg-fried me-2"></i> Lihat Menu
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="categories" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">Kategori Pilihan</h2>
            <p class="text-muted">Temukan makanan sesuai kebutuhan dietmu</p>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($categories as $category)
            <div class="col">
                <div class="card shadow-sm h-100 border-0 hover-shadow transition">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-2x text-success mb-2"></i>
                        <h5 class="card-title text-dark fw-semibold">{{ $category->name }}</h5>
                        <p class="text-muted small mb-0">{{ $category->foods_count }} menu tersedia</p>
                        <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Lihat Menu</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="menu" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">Menu Populer</h2>
            <p class="text-muted">Favorit pelanggan kami</p>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($popularFoods as $food)
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body">
                        <div class="image-wrapper">
                            <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->slug }}" style="object-fit: cover; height: 200px;">
                        </div>
                        <div class="card-title">
                            <h5>{{ $food->name }}</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-success fw-bold">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="card-text text-muted small">{{ Str::limit($food->description, 50) }}</p>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0">
                        <a href="#" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-shopping-cart me-1"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                Lihat Menu Lengkap <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-success">Apa Kata Mereka?</h2>
            <p class="text-muted">Testimonial pelanggan puas</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach([
                                ['name' => 'Sarah', 'comment' => 'Makanannya fresh dan pengiriman cepat!'],
                                ['name' => 'Budi', 'comment' => 'Sudah langganan 2 tahun, kesehatan membaik.'],
                                ['name' => 'Dewi', 'comment' => 'Anak-anak suka smoothienya, gizinya terjamin.']
                                ] as $key => $testi)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <div class="text-center p-3">
                                        <img src="https://i.pravatar.cc/100?img={{ $key + 3 }}"
                                            class="rounded-circle mb-3"
                                            width="80"
                                            alt="{{ $testi['name'] }}">
                                        <p class="lead fst-italic mb-3">"{{ $testi['comment'] }}"</p>
                                        <h5 class="text-success">{{ $testi['name'] }}</h5>
                                        <div class="text-warning">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection