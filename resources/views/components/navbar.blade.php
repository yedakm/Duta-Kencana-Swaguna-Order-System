@php
$prefix = 'guest';
if (auth()->check()) {
    $prefix = auth()->user()->role === 'admin' ? 'admin' : 'member';
}
@endphp

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c3e50;">
    <div class="container">
        @auth
            @if (Auth::user()->role === 'admin')
                <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-leaf me-2"></i>DeliGreen Admin
                </a>
            @else
                <a class="navbar-brand fw-bold" href="{{ route('member.dashboard') }}">
                    <i class="fas fa-leaf me-2"></i>DeliGreen
                </a>
            @endif
        @endauth

        @guest
            <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">
                <i class="fas fa-leaf me-2"></i>DeliGreen
            </a>
        @endguest

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item mx-1">
                    <a class="nav-link py-2 px-3 rounded {{ request()->routeIs('guest.foods.*') ? 'active bg-white text-dark' : '' }}"
                        href="{{ route($prefix . '.foods.index') }}">
                        <i class="fas fa-utensils me-1"></i> Menu
                    </a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link py-2 px-3 rounded {{ request()->routeIs('guest.categories.*') ? 'active bg-white text-dark' : '' }}"
                        href="{{ route($prefix . '.categories.index') }}">
                        <i class="fas fa-tags me-1"></i> Categories
                    </a>
                </li>

                @if(auth()->check() && auth()->user()->role === 'admin')
                <li class="nav-item mx-1">
                    <a class="nav-link py-2 px-3 rounded {{ request()->routeIs('admin.users.*') ? 'active bg-white text-dark' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users me-1"></i> Users
                    </a>
                </li>
                @endif

                @auth
                <li class="nav-item mx-1">
                    <a class="nav-link py-2 px-3" href="{{ route($prefix . '.orders.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i> Order
                    </a>
                </li>
                @if (auth()->user()->role === 'admin')
                <li class="nav-item mx-1">
                    <a class="nav-link py-2 px-3" href="{{ route($prefix . '.reports.index') }}">
                        <i class="fas fa-chart-line ms-1"></i> Reports
                    </a>
                </li>
                @endif
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center text-white" id="userDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fs-4 me-1"></i>{{ Auth::user()->name }}
                        <span class="d-none d-lg-inline ms-1"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('register.page') }}">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>