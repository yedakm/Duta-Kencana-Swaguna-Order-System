<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  @auth
  <meta name="user-id" content="{{ auth()->user()->id }}">
  @endauth
  @vite(['resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PT Duta Kencana Swaguna - @yield('title')</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" sizes="64x64">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <style>
    body,
    html {
      margin: 0;
      padding: 0;
      height: 100%;
    }

    .navbar {
      position: sticky;
      top: 0;
      z-index: 1030;
      width: 100%;
    }

    .main-content {
      padding-top: 0;
    }

    .footer {
      background-color: #2c3e50 !important;
    }

    .footer a:hover {
      color: #3498db !important;
      text-decoration: underline !important;
    }

    .social-icons a {
      transition: all 0.3s ease;
    }

    .social-icons a:hover {
      transform: translateY(-3px);
      color: #3498db !important;
    }

    .text-primary {
      color: #3498db !important;
    }

    .container,
    .container-fluid {
      padding-left: 1.5rem;
      padding-right: 1.5rem;
    }

    .hero-section {
      background: linear-gradient(135deg, #3498db, #2c3e50);
    }

    .card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 10px;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #3498db;
      border-color: #3498db;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
      transform: translateY(-2px);
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100">
  @include('components.navbar')

  <main class="container-fluid">
    <main class="flex-fill">
      <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080;">
        @if(session('success'))
        <div id="successToast" class="toast align-items-center text-bg-success bg-gradient border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              ✔ {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        @endif

        @if(session('error'))
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
            <div class="toast-body">
              ❌ {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
        </div>
        @endif
      </div>
      @yield('styles')
      @yield('content')
    </main>
  </main>

  @include('components.footer')

  @auth
    @include('components.logout-modal')
  @endauth
  @if (!auth()->check())
    @include('components.login')
  @endif
  
  @stack('modals')
  @stack('scripts')

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var toastElList = [].slice.call(document.querySelectorAll('.toast'))
      toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, {
          delay: 2500
        }).show()
      })
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll(".love-toggle").forEach(function(btn) {
        btn.addEventListener("click", function() {
          const icon = this.querySelector("i");

          if (icon.classList.contains("text-danger")) {
            icon.classList.remove("text-danger");
            icon.classList.add("text-secondary");
          } else {
            icon.classList.remove("text-secondary");
            icon.classList.add("text-danger");
          }
          icon.classList.add("fa-bounce");
          setTimeout(() => icon.classList.remove("fa-bounce"), 400);
        });
      });
    });
  </script>
</body>
</html>