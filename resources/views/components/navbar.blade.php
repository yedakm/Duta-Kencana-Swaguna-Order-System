@php

$prefix = 'guest';

if (auth()->check()) {

    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'member';

}

@endphp



<style>

    /* Navbar dengan Background Hijau Cerah agar Teks Hitam Jelas */

    .navbar-green-custom {

        background-color: #20c997; /* Hijau Teal/Mint Cerah */

        /* Opsi lain jika ingin hijau daun: background-color: #4ade80; */

        

        box-shadow: 0 4px 12px rgba(0,0,0,0.1);

        font-family: 'Poppins', sans-serif;

    }



    /* Style Tulisan Menu (Hitam) */

    .nav-link-black {

        color: #000000 !important; /* Hitam Pekat */

        font-weight: 600;

        font-size: 0.95rem;

        transition: all 0.3s ease;

    }



    /* Efek Hover: Berubah Putih atau Hijau Tua */

    .nav-link-black:hover, .nav-link-black.active {

        color: #144431 !important; /* Hijau Gelap saat hover */

        transform: translateY(-1px);

    }



    /* Tombol Login (Outline Hitam) */

    .btn-login-black {

        border: 2px solid #000;

        color: #000;

        font-weight: 700;

        border-radius: 50px;

        padding: 8px 30px;

        background: transparent;

        transition: 0.3s;

    }



    .btn-login-black:hover {

        background-color: #000;

        color: #20c997; /* Teks berubah jadi hijau background */

        box-shadow: 0 4px 10px rgba(0,0,0,0.2);

    }

</style>



<nav class="navbar navbar-expand-lg navbar-light navbar-green-custom sticky-top py-3">

    <div class="container">

        

        <a class="navbar-brand fw-bold d-flex align-items-center text-dark" style="font-size: 1.3rem;"

           href="{{ route(auth()->check() && auth()->user()->role === 'admin' ? 'admin.dashboard' : (auth()->check() ? 'member.dashboard' : 'welcome')) }}">

            <i class="fas fa-leaf me-2 fs-3"></i> 

            

            <span>PT Duta Kencana Swaguna</span>

        </a>



        <button class="navbar-toggler border-2 border-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">

            <span class="navbar-toggler-icon"></span>

        </button>



        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

                <li class="nav-item mx-2">

                    <a class="nav-link nav-link-black {{ request()->routeIs('guest.foods.*') ? 'active' : '' }}" href="{{ route($prefix . '.foods.index') }}">

                        Menu Sehat

                    </a>

                </li>

                <li class="nav-item mx-2">

                    <a class="nav-link nav-link-black {{ request()->routeIs('guest.categories.*') ? 'active' : '' }}" href="{{ route($prefix . '.categories.index') }}">

                        Kategori

                    </a>

                </li>



                @auth

                    @if(auth()->user()->role === 'admin')

                    <li class="nav-item mx-2">

                        <a class="nav-link nav-link-black" href="{{ route('admin.users.index') }}">Users</a>

                    </li>

                    <li class="nav-item mx-2">

                        <a class="nav-link nav-link-black" href="{{ route($prefix . '.reports.index') }}">Laporan</a>

                    </li>

                    @endif

                    <li class="nav-item mx-2">

                        <a class="nav-link nav-link-black" href="{{ route($prefix . '.orders.index') }}">Pesanan</a>

                    </li>

                @endauth

            </ul>



            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-3">

                @auth

                    @if(auth()->user()->role !== 'admin')

                    <li class="nav-item me-2">

                        <a href="{{ route($prefix . '.orders.index') }}" class="position-relative text-dark fs-5">

                            <i class="bi bi-cart-fill"></i>

                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-dark border border-light rounded-circle" style="width:10px; height:10px;"></span>

                        </a>

                    </li>

                    @endif



                    <li class="nav-item dropdown">

                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center text-dark fw-bold" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">

                                {{ substr(Auth::user()->name, 0, 1) }}

                            </div>

                            <span class="d-none d-lg-block">{{ Auth::user()->name }}</span>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2">

                            <li><a class="dropdown-item" href="#">Profile</a></li>

                            <li><hr class="dropdown-divider"></li>

                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>

                        </ul>

                    </li>

                @else

                    <li class="nav-item">

                        <a class="nav-link fw-bold text-dark" href="{{ route('register.page') }}">Daftar</a>

                    </li>

                    <li class="nav-item">

                        <button type="button" class="btn btn-login-black" data-bs-toggle="modal" data-bs-target="#loginModal">

                            Masuk

                        </button>

                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>