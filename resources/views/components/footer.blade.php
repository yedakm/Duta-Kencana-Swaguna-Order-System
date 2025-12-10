<footer class="footer mt-auto py-4 bg-dark text-white">
    <div class="container">
        <div class="row">

            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold text-primary mb-3">DeliGreen</h5>
                <p class="mb-2">Healthy food delivery system for better lifestyle.</p>
                <div class="social-icons mt-3">
                    <a href="https://www.facebook.com/deligreen/" class="text-white me-3"><i class="fa-brands fa-facebook"></i></a>
                    <a href="https://www.instagram.com/deligreen/" class="text-white me-3"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://x.com/deligreen/" class="text-white me-3"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://wa.me/6282100000000/" class="text-white"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
                <img src="{{ asset('logo/logo-deligreen.png') }}" alt="Logo DeliGreen" class="img-fluid mt-3"
                    style="max-width: 200px;">
            </div>

            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold text-primary mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    @php
                    $role = auth()->check() ? auth()->user()->role : 'guest';
                    @endphp

                    @if($role === 'admin')
                    <li class="mb-2"><a href="{{ route('admin.foods.index') }}" class="text-white text-decoration-none">Food</a></li>
                    <li class="mb-2"><a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none">Categories</a></li>
                    <li class="mb-2"><a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none">Users</a></li>
                    <li class="mb-2"><a href="{{ route('admin.orders.index') }}" class="text-white text-decoration-none">Orders</a></li>
                    <li class="mb-2"><a href="{{ route('admin.reports.index') }}" class="text-white text-decoration-none">Reports</a></li>
                    @elseif($role === 'member')
                    <li class="mb-2"><a href="{{ route('member.foods.index') }}" class="text-white text-decoration-none">Food</a></li>
                    <li class="mb-2"><a href="{{ route('member.categories.index') }}" class="text-white text-decoration-none">Categories</a></li>
                    <li class="mb-2"><a href="{{ route('member.orders.index') }}" class="text-white text-decoration-none">Orders</a></li>
                    @else
                    <li class="mb-2"><a href="{{ route('guest.foods.index') }}" class="text-white text-decoration-none">Food</a></li>
                    <li class="mb-2"><a href="{{ route('guest.categories.index') }}" class="text-white text-decoration-none">Categories</a></li>
                    @endif
                </ul>


            </div>

            <div class="col-md-4">
                <h5 class="fw-bold text-primary mb-3">Contact Us</h5>
                <p><i class="fas fa-envelope me-2"></i> admin@deligreen.web.id</p>
                <p><i class="fas fa-phone me-2"></i> (021) 456-7890</p>
                <p><i class="fas fa-map-marker-alt me-2"></i> Surabaya, Indonesia</p>
            </div>
        </div>

        <hr class="my-4 bg-light opacity-25">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; 2025 DeliGreen. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Privacy Policy</a>
                <a href="#" class="text-white text-decoration-none">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>