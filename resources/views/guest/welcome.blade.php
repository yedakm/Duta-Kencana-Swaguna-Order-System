@extends('components.app')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Custom Styling */
    body {
        font-family: 'Poppins', sans-serif;
    }
    
    .hero-bg {
        background: linear-gradient(to right, rgba(255,255,255,0.95), rgba(255,255,255,0.8)), 
                    url('https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Efek Parallax */
    }

    .btn-pill {
        border-radius: 50px;
        padding-left: 30px;
        padding-right: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-pill:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
    }

    .card-hover {
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
        border-color: #198754;
    }

    .category-card {
        cursor: pointer;
        transition: 0.3s;
    }
    .category-card:hover {
        background-color: #e9f7ef !important; /* Hijau muda pudar */
    }

    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: #198754;
        margin: 10px auto;
        border-radius: 2px;
    }
</style>

@if(session('showLoginModal'))
<script>
    window.onload = () => {
        const modal = new bootstrap.Modal(document.getElementById('loginModal'));
        modal.show();
    };
</script>
@endif

<section class="hero-bg py-5 d-flex align-items-center" style="min-height: 85vh;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class=""></i> Healthy Catering #1
                </span>
                <h1 class="display-3 fw-bold text-dark mb-4 lh-sm">
                    Nikmati Hidup Sehat <br>
                    <span class="text-success">Tanpa Ribet.</span>
                </h1>
                <p class="lead text-muted mb-5 w-75">
                    Solusi katering diet premium yang lezat, higienis, dan terjangkau. Pesan sekarang, kami antar sampai depan pintu.
                </p>
                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-success btn-lg btn-pill shadow" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt me-2"></i> Mulai Pesan
                    </button>
                    <a href="{{ route('guest.foods.index') }}" class="btn btn-outline-success btn-lg btn-pill bg-white">
                        <i class="bi bi-book me-2"></i> Lihat Menu
                    </a>
                </div>
                
                <div class="row mt-5 pt-4 border-top w-75">
                    <div class="col-auto me-4">
                        <h4 class="fw-bold mb-0">5k+</h4>
                        <small class="text-muted">Happy Clients</small>
                    </div>
                    <div class="col-auto">
                        <h4 class="fw-bold mb-0">100+</h4>
                        <small class="text-muted">Menu Sehat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="categories" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold section-title">Kategori Pilihan</h2>
            <p class="text-muted">Sesuaikan menu dengan kebutuhan nutrisi harianmu</p>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($categories as $category)
            <div class="col" data-aos="zoom-in" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card h-100 border-0 shadow-sm category-card rounded-4">
                    <div class="card-body text-center p-4">
                        <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-utensils fs-4 text-success"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">{{ $category->name }}</h6>
                        <p class="text-muted small mb-3">{{ $category->foods_count }} Menu</p>
                        <a href="#" class="btn btn-sm btn-outline-success rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section id="menu" class="py-5 bg-light bg-opacity-50">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold section-title">Menu Favorit Minggu Ini</h2>
            <p class="text-muted">Paling banyak dipesan oleh pelanggan setia kami</p>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($popularFoods as $food)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100 card-hover rounded-4 overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $food->image) }}" class="card-img-top" alt="{{ $food->slug }}" style="object-fit: cover; height: 220px;">
                        <span class="position-absolute top-0 end-0 bg-white text-success fw-bold px-3 py-1 m-3 rounded-pill shadow-sm small">
                            <i class="bi bi-star-fill text-warning"></i> Recommended
                        </span>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="mb-2">
                            <h5 class="fw-bold mb-1">{{ $food->name }}</h5>
                        </div>
                        <p class="card-text text-muted small mb-4">{{ Str::limit($food->description, 60) }}</p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                            <h5 class="text-success fw-bold mb-0">Rp {{ number_format($food->price, 0, ',', '.') }}</h5>
                            <button class="btn btn-success rounded-circle shadow-sm" style="width: 40px; height: 40px;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-success btn-pill px-5 py-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                Lihat Semua Menu <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="zoom-in">
                <i class="bi bi-quote display-1 text-success opacity-25"></i>
                <h2 class="fw-bold mb-4 mt-n4">Kata Mereka</h2>
                
                <div class="card border-0 shadow-sm rounded-4 bg-light">
                    <div class="card-body p-5">
                        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach([
                                ['name' => 'Sarah Amalia', 'comment' => 'Makanannya fresh banget! Pengiriman cepat dan rasanya enak, gak berasa lagi diet.'],
                                ['name' => 'Budi Santoso', 'comment' => 'Sudah langganan 2 tahun, kolesterol saya turun berkat menu catering ini.'],
                                ['name' => 'Dewi Persik', 'comment' => 'Anak-anak suka smoothienya. Solusi tepat buat ibu sibuk yang ingin keluarga tetap sehat.']
                                ] as $key => $testi)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <div class="text-center">
                                        <img src="https://i.pravatar.cc/100?img={{ $key + 10 }}" class="rounded-circle mb-3 border border-3 border-white shadow-sm" width="80" alt="{{ $testi['name'] }}">
                                        <p class="lead fst-italic mb-3 text-dark">"{{ $testi['comment'] }}"</p>
                                        <h6 class="fw-bold text-success mb-1">{{ $testi['name'] }}</h6>
                                        <div class="text-warning small">
                                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon bg-success rounded-circle" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon bg-success rounded-circle" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
      once: true,
      offset: 120,
      duration: 800,
  });
</script>

@endsection