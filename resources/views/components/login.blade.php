@push('modals')
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="{{ route('login') }}" method="POST">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Login ke PT Duta Kencana Swaguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
  
            <div class="mb-3">
              <label for="login-email">Email</label>
              <input type="email" class="form-control" id="login-email" name="email" required autofocus value="{{ old('email') }}">
            </div>
  
            <div class="mb-3">
              <label for="login-password">Password</label>
              <input type="password" class="form-control" id="login-password" name="password" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Login</button>
          </div>
  
          <div class="text-center mb-3">
            <small class="text-muted">
              Belum punya akun? <a href="{{ route('register.page') }}" class="text-primary">Daftar di sini</a>
            </small>
          </div>
        </form>
      </div>
    </div>
  </div>
@endpush

@push('scripts')
  @if(session('error'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginModalEl = document.getElementById('loginModal');
      const loginModal = new bootstrap.Modal(loginModalEl, {
        backdrop: true
      });
      loginModal.show();

      loginModalEl.addEventListener('hidden.bs.modal', function() {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
        document.body.classList.remove('modal-open');
        document.body.style = '';
      });
    });
  </script>
  @endif
@endpush