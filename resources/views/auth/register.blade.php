@extends('components.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card shadow-sm border-0" style="max-width: 400px; width: 100%;">
    <div class="card-body p-4">
      <h2 class="text-success fw-bold mb-4 text-center">Daftar PT Duta Kencana Swaguna</h2>
      <p class="text-muted text-center mb-4">Buat akun baru untuk mulai pesan makanan sehat.</p>

      <form method="POST" action="{{ route('register.verify') }}">
        @csrf

        <div class="mb-3">
          <label for="register-name" class="form-label text-muted">Nama Lengkap</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="register-name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" aria-describedby="nameHelp">
          @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label text-muted">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" aria-describedby="emailHelp">
          @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="register-phone" class="form-label text-muted">Nomor HP</label>
          <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="register-phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" pattern="^(08|628)[0-9]{7,13}$" aria-describedby="phoneHelp">
          @error('phone')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="register-address" class="form-label text-muted">Alamat</label>
          <textarea class="form-control @error('address') is-invalid @enderror" id="register-address" name="address" rows="2" required autocomplete="street-address" aria-describedby="addressHelp">{{ old('address') }}</textarea>
          @error('address')
          <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="register-password" class="form-label text-muted">Password</label>
          <div class="input-group">
            <input type="password" class="form-control @error('password') is-invalid @enderror"
              id="register-password" name="password" required autocomplete="new-password">
            <span class="input-group-text" onclick="togglePassword('register-password', this)" style="cursor:pointer;">
              <i class="fa-solid fa-eye" id="toggleIcon-password"></i>
            </span>
          </div>
          @error('password')
          <div class="invalid-feedback d-block">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-4">
          <label for="password_confirmation" class="form-label text-muted">Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            <span class="input-group-text" onclick="togglePassword('password_confirmation', this)" style="cursor:pointer;">
              <i class="fa-solid fa-eye" id="toggleIcon-password_confirmation"></i>
            </span>
          </div>
        </div>

        <button type="submit" class="btn btn-success w-100 fw-semibold">Daftar</button>

        <div class="text-center mt-3">
          <small class="text-muted">
            Sudah punya akun?
            <a href="{{ route('welcome') }}" class="text-primary">Login di sini</a>
          </small>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
  <script>
    function togglePassword(inputId, el) {
      const input = document.getElementById(inputId);
      const icon = el.querySelector("i");
  
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>
@endpush