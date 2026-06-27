@extends('layouts.app')

@section('title', 'Daftar - SIGANA')
@section('body_class', 'auth-page')

@push('styles')
<style>
/* Sembunyikan navbar & footer khusus halaman auth */
body.auth-page #mainNavbar,
body.auth-page footer.footer {
  display: none !important;
}

body.auth-page {
  overflow: hidden;
}

.auth-hero {
  min-height: 100vh;
  height: 100vh;
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #0a2540 0%, #173f66 45%, #0d2f52 100%);
}

/* Pattern grid halus */
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

.auth-card {
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.98);
}

.brand-cyan {
  color: #38bdf8;
}

.brand-red-light {
  color: #f87171;
}

.auth-heading {
  color: #ffffff !important;
  font-size: 1.6rem;
}

.password-toggle {
  background: none;
  border: none;
  z-index: 3;
}

.password-toggle:hover,
.password-toggle:focus {
  color: #1d4ed8 !important;
}

/* Logo bulat dengan ring putih, beranimasi melayang */
.auth-logo-ring {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.95);
  padding: 8px;
  box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.15), 0 16px 32px rgba(0,0,0,0.35);
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
  50%      { transform: translateY(-10px); }
}

/* Gelembung */
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

@keyframes bubble-rise {
  0% {
    transform: translateY(0) translateX(0) scale(1);
    opacity: 0;
  }
  10% {
    opacity: 0.7;
  }
  50% {
    transform: translateY(-50vh) translateX(15px) scale(1.05);
  }
  90% {
    opacity: 0.5;
  }
  100% {
    transform: translateY(-105vh) translateX(-10px) scale(0.95);
    opacity: 0;
  }
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

@media (max-width: 991px) {
  .auth-hero {
    height: auto;
    min-height: 100vh;
    overflow-y: auto;
    padding: 30px 0;
  }
  body.auth-page {
    overflow: auto;
  }
  .auth-hero .row { flex-direction: column; }
  .auth-hero .col-lg-5 {
    width: 100%;
    max-width: 100%;
  }
}

@media (max-width: 767.98px) {
  html:has(body.auth-page) { overflow: hidden !important; }
  .auth-hero {
    height: 100vh !important;
    overflow: hidden !important;
    padding: 0 !important;
  }
  .auth-card {
    max-width: 280px !important;
    margin: 0 auto !important;
  }
  .auth-card .card-body {
    padding: 0.9rem !important;
  }
  .auth-card .auth-logo-ring {
    width: 80px !important;
    height: 80px !important;
    box-shadow: none !important;
    animation: none !important;
  }
  .auth-card h5 {
    font-size: 0.9rem !important;
    margin-bottom: 0.6rem !important;
  }
  .auth-card h6 {
    font-size: 0.82rem !important;
  }
  .auth-card .form-label {
    font-size: 0.73rem !important;
    margin-bottom: 0.15rem !important;
  }
  .auth-card .form-control-sm {
    font-size: 0.75rem !important;
    padding: 0.35rem 0.6rem !important;
  }
  .auth-card .mb-2 {
    margin-bottom: 0.45rem !important;
  }
  .auth-card .btn {
    font-size: 0.8rem !important;
    padding: 0.45rem !important;
  }
  .auth-card .form-check-label {
    font-size: 0.7rem !important;
  }
  .auth-card .small,
  .auth-card small {
    font-size: 0.68rem !important;
  }
}

@media (max-height: 750px) and (min-width: 992px) {
  .auth-logo-ring { width: 90px; height: 90px; }
  .auth-heading { font-size: 1.3rem; }
}
</style>
@endpush
@section('content')
<section class="auth-hero d-flex align-items-center">

  {{-- Gelembung animasi --}}
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

      {{-- Kolom Kiri: Logo + Brand + Tagline --}}
      <div class="col-lg-5 text-center text-white px-4 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
        <div class="auth-logo-ring mx-auto mb-3">
          <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA">
        </div>
        <h2 class="fw-bold mb-2 auth-heading">
          Bergabung Bersama <span class="brand-cyan">SI</span> <span class="brand-red-light">GANA</span>
        </h2>
        <p class="text-white-50 mb-0 small" style="max-width: 420px; margin: 0 auto;">
          Daftar sekarang dan jadi bagian dari gerakan tanggap bencana dan donasi yang cepat, aman, dan transparan.
        </p>
      </div>

      {{-- Kolom Kanan: Form Daftar --}}
      <div class="col-lg-5 px-3 py-3" data-aos="fade-left" data-aos-delay="200">
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
            <h5 class="mb-3">
              <i class="fa-solid fa-user-plus me-2" style="color: #38bdf8;"></i>Daftar Akun SIGANA
            </h5>

          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-2">
              <label for="registerName" class="form-label small mb-1">Nama Lengkap</label>
              <input type="text" name="name" class="form-control form-control-sm @error('name') is-invalid @enderror" id="registerName"
                placeholder="Nama lengkap Anda" value="{{ old('name') }}" required autofocus>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-2">
              <label for="registerEmail" class="form-label small mb-1">Alamat Email</label>
              <input type="email" name="email" class="form-control form-control-sm @error('email') is-invalid @enderror" id="registerEmail"
                placeholder="nama@email.com" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-2">
              <label for="registerPhone" class="form-label small mb-1">No. HP</label>
              <input type="tel" name="phone" class="form-control form-control-sm @error('phone') is-invalid @enderror" id="registerPhone"
                placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required
                inputmode="numeric" pattern="[0-9]*" maxlength="15"
                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
              @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-2">
              <label for="registerPassword" class="form-label small mb-1">Kata Sandi</label>
              <div class="position-relative">
                <input type="password" name="password" class="form-control form-control-sm pe-5 @error('password') is-invalid @enderror" id="registerPassword"
                  placeholder="••••••••" required>
                <button type="button" class="btn btn-link p-0 position-absolute top-50 end-0 translate-middle-y me-3 text-muted password-toggle" onclick="togglePassword('registerPassword', this)" tabindex="-1">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
              @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-2">
              <label for="registerPasswordConfirm" class="form-label small mb-1">Konfirmasi Kata Sandi</label>
              <div class="position-relative">
                <input type="password" name="password_confirmation" class="form-control form-control-sm pe-5" id="registerPasswordConfirm"
                  placeholder="••••••••" required>
                <button type="button" class="btn btn-link p-0 position-absolute top-50 end-0 translate-middle-y me-3 text-muted password-toggle" onclick="togglePassword('registerPasswordConfirm', this)" tabindex="-1">
                  <i class="fa-solid fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="form-check mb-2">
              <input class="form-check-input @error('agree') is-invalid @enderror" type="checkbox" name="agree" id="agreeTerms" required>
              <label class="form-check-label text-muted small" for="agreeTerms">
                Saya setuju dengan <a href="#" class="text-decoration-none">Syarat & Ketentuan</a> SIGANA
              </label>
              @error('agree')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

              <button type="submit" class="btn btn-masuk w-100 py-2 fw-semibold">Daftar</button>

              <div class="text-center mt-2 small text-muted">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Masuk Sekarang</a>
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