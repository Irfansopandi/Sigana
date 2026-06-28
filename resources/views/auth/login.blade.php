@extends('layouts.app')

@section('title', 'Login - SIGANA')
@section('body_class', 'auth-page')
@push('styles')
<style>
body.auth-page #mainNavbar,
body.auth-page footer.footer {
  display: none !important;
}

html:has(body.auth-page) {
  overflow: hidden !important;
}
.auth-hero {
  min-height: 100vh;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #0a2540 0%, #173f66 45%, #0d2f52 100%);
  display: flex;
  align-items: center;
  justify-content: center;
}


.auth-hero::before {
  content: "";
  position: absolute;
  inset: 0;
  background-image:
    linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: 38px 38px;
  pointer-events: none;
  z-index: 1;
}

.auth-hero > .container {
  margin-top: -60px;
}
.auth-card {
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.98);
}

.brand-cyan { color: #38bdf8; }
.brand-red-light { color: #f87171; }
.auth-heading { color: #ffffff !important; }

.password-toggle {
  background: none;
  border: none;
  position: absolute !important;
  top: 0 !important;
  right: 0.75rem !important;
  height: 38px !important;
  transform: none !important;
  display: flex !important;
  align-items: center !important;
  z-index: 5;
  padding: 0 !important;
}
.password-toggle:hover,
.password-toggle:focus {
  color: #1d4ed8 !important;
}

.form-control.is-invalid {
  background-image: none !important;
}
.btn-outline-secondary:hover {
  background-color: #f8faff !important;
  border-color: #4285f4 !important;
  color: #3c4043 !important;
}
.btn-outline-secondary img {
  filter: grayscale(100%);
  transition: filter 0.2s;
}

.btn-outline-secondary:hover img {
  filter: grayscale(0%); /* hover: warna asli Google */
}
.auth-logo-ring {
  width: 160px;
  height: 160px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.95);
  padding: 10px;
  box-shadow: 0 0 0 6px rgba(255, 255, 255, 0.15), 0 20px 40px rgba(0,0,0,0.35);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  animation: logo-float 4s ease-in-out infinite;
}

.auth-logo-ring img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

@keyframes logo-float {
  0%, 100% { transform: translateY(0); }
  50%      { transform: translateY(-14px); }
}

.bubbles {
  position: absolute;
  inset: 0;
  z-index: 1;
  overflow: hidden;
  pointer-events: none;
}

.bubbles span {
  position: absolute;
  bottom: -60px;
  display: block;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.12);
  border: 1px solid rgba(255, 255, 255, 0.18);
  animation: bubble-rise linear infinite;
}
.btn-masuk {
  background: linear-gradient(135deg, #38bdf8, #7dd3fc) !important;
  color: #ffffff;
  border: none;
  transition: all 0.2s ease;
}

.btn-masuk:hover {
  background: linear-gradient(135deg, #10689f, #1705b5)!important;
  color: #ffffff !important;
  box-shadow: 0 4px 15px rgba(21, 18, 209, 0.4);
}

@keyframes bubble-rise {
  0%   { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
  10%  { opacity: 0.7; }
  50%  { transform: translateY(-50vh) translateX(15px) scale(1.05); }
  90%  { opacity: 0.5; }
  100% { transform: translateY(-105vh) translateX(-10px) scale(0.95); opacity: 0; }
}

@media (max-width: 991px) {
  .auth-hero .row { flex-direction: column; }
  .auth-hero .col-lg-5 { width: 100%; max-width: 100%; }
}

@media (max-width: 767.98px) {
  html:has(body.auth-page) { overflow: hidden !important; }
  .auth-hero {
    height: 100vh !important;
    overflow: hidden !important;
    align-items: center !important;
    justify-content: center !important;
  }
  .auth-card {
    max-width: 280px !important;
    margin: 0 auto !important;
  }
  .auth-card .card-body {
    padding: 1rem !important;
  }
  .auth-card .auth-logo-ring {
    width: 80px !important;
    height: 80px !important;
    box-shadow: none !important;
    animation: none !important;
  }
  .auth-card h5 {
    font-size: 0.92rem !important;
    margin-bottom: 0.7rem !important;
  }
  .auth-card h6 {
    font-size: 0.82rem !important;
  }
  .auth-card .form-label {
    font-size: 0.75rem !important;
    margin-bottom: 0.2rem !important;
  }
  .auth-card .form-control {
    font-size: 0.78rem !important;
    padding: 0.4rem 0.65rem !important;
  }
  .auth-card .mb-3 {
    margin-bottom: 0.55rem !important;
  }
  .auth-card .btn {
    font-size: 0.8rem !important;
    padding: 0.45rem !important;
  }
  .auth-card .small,
  .auth-card small {
    font-size: 0.7rem !important;
  }
}
</style>
@endpush

@section('content')
<section class="auth-hero d-flex align-items-center" style="padding-bottom: 80px;">

  <div class="bubbles">
    <span style="left: 6%;  width: 22px; height: 22px; animation-duration: 14s; animation-delay: 0s;"></span>
    <span style="left: 14%; width: 14px; height: 14px; animation-duration: 10s; animation-delay: 2s;"></span>
    <span style="left: 22%; width: 30px; height: 30px; animation-duration: 18s; animation-delay: 1s;"></span>
    <span style="left: 33%; width: 16px; height: 16px; animation-duration: 12s; animation-delay: 4s;"></span>
    <span style="left: 45%; width: 24px; height: 24px; animation-duration: 16s; animation-delay: 0.5s;"></span>
    <span style="left: 55%; width: 12px; height: 12px; animation-duration: 9s;  animation-delay: 3s;"></span>
    <span style="left: 64%; width: 28px; height: 28px; animation-duration: 17s; animation-delay: 2.5s;"></span>
    <span style="left: 73%; width: 18px; height: 18px; animation-duration: 11s; animation-delay: 1.5s;"></span>
    <span style="left: 82%; width: 26px; height: 26px; animation-duration: 15s; animation-delay: 0s;"></span>
    <span style="left: 90%; width: 15px; height: 15px; animation-duration: 13s; animation-delay: 3.5s;"></span>
    <span style="left: 96%; width: 20px; height: 20px; animation-duration: 19s; animation-delay: 2s;"></span>
    <span style="left: 38%; width: 10px; height: 10px; animation-duration: 8s;  animation-delay: 5s;"></span>
    <span style="left: 60%; width: 20px; height: 20px; animation-duration: 20s; animation-delay: 4.5s;"></span>
  </div>

  <div class="container position-relative" style="z-index: 2;">
    <div class="row align-items-center justify-content-center g-4 g-lg-5">

      {{-- Kolom Kiri --}}
      <div class="col-lg-5 text-center text-white px-4 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
        <div class="auth-logo-ring mx-auto mb-4">
          <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA">
        </div>
        <h2 class="fw-bold mb-2 auth-heading">
          Selamat Datang di <span class="brand-cyan">SI</span> <span class="brand-red-light">GANA</span>
        </h2>
        <p class="text-white-50 mb-0" style="max-width: 420px; margin: 0 auto;">
          Gerbang Anda menuju sistem tanggap bencana dan donasi yang cepat, aman, dan transparan.
        </p>
      </div>

      {{-- Kolom Kanan: Form Login --}}
      <div class="col-lg-5 px-3 py-5" data-aos="fade-left" data-aos-delay="200">
        <div class="card border-0 shadow-lg auth-card mx-auto" style="max-width: 460px;">
          <div class="card-body p-3 p-md-4">
            {{-- Logo mini khusus mobile (d-flex d-lg-none) --}}
            <div class="d-flex d-lg-none flex-column align-items-center mb-3">
              <div class="auth-logo-ring mb-2" style="width:80px;height:80px;">
                <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA">
              </div>
              <h6 class="fw-bold mb-0">
                <span class="brand-cyan">SI</span><span style="color:#f87171;">GANA</span>              
              </h6>
            </div>
            <h5 class="mb-4">
              <i class="fa-solid fa-right-to-bracket me-2" style="color: #38bdf8;"></i>Masuk Ke SIGANA
            </h5>
            @if(session('relawan_registered'))
              <div class="alert alert-success rounded-3 mb-3" style="font-size:0.82rem;">
                  <i class="fa-solid fa-circle-check me-1"></i> {{ session('relawan_registered') }}
              </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
              @csrf

              {{-- Email --}}
              <div class="mb-3">
                <label for="loginEmail" class="form-label">Alamat Email</label>
                <input type="email" name="email"
                  class="form-control @error('email') is-invalid @enderror"
                  id="loginEmail" placeholder="nama@email.com"
                  value="{{ old('email') }}" required autofocus>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password --}}
              <div class="mb-3">
                <label for="loginPassword" class="form-label">Kata Sandi</label>
                <div class="position-relative">
                  <input type="password" name="password"
                    class="form-control pe-5 @error('password') is-invalid @enderror"
                    id="loginPassword" placeholder="••••••••" required>
                  <button type="button" class="password-toggle text-muted"
                    onclick="togglePassword('loginPassword', this)" tabindex="-1">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                  @error('password')
                    <div class="invalid-feedback d-block mt-1">
                      <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                  <label class="form-check-label text-muted small" for="rememberMe">Ingat saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa Sandi?</a>
              </div>  
              <div class="mb-3">
                <label class="form-label">
                    Berapa hasil dari <strong>{{ session('captcha_question') }}</strong>?
                </label>
                <input type="number" name="captcha"
                class="form-control @error('captcha') in-user-invalid @enderror"
                placeholder="Masukan jawaban....." min="1" max="10" required>
                @error('captcha')
                <div class="invalid-feedback">{{ $message }}</div>    
                @enderror
              </div>

              <button type="submit" class="btn btn-masuk w-100 py-2 fw-semibold" style="background: linear-gradient(135deg, #17a8ec, #38bdf8); color: #ffffff; border: none;">Masuk</button>
                <div class="d-flex align-items-center my-3">
                  <hr class="flex-grow-1">
                  <span class="mx-2 text-muted small">atau</span>
                  <hr class="flex-grow-1">
                </div>

                <a href="{{ route('google.redirect') }}" class="btn btn-outline-secondary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                  <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" height="20" alt="Google">
                  <span>Masuk dengan Google</span>
                </a>

              <div class="text-center mt-3 small text-muted">
                Belum punya akun? <a href="{{ route('register.create') }}" class="text-decoration-none">Daftar Sekarang</a>
              </div>
            </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const icon = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
@endpush