@extends('layouts.app')

@section('title', 'Gabung Relawan - SIGANA')
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
  padding: 40px 0;
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

.auth-card {
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.98);
}

.auth-hero > .container {
  margin-top: -40px;
}

.syarat-box {
  background: #f0fdf4;
  border: 1px solid #bbf7d0;
  border-radius: 10px;
  padding: 0.65rem 0.85rem;
  font-size: 0.75rem;
  color: #14532d;
  line-height: 1.5;
}
.syarat-box strong {
  color: #15803d;
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

.auth-logo-ring {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.95);
  padding: 8px;
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
  50%      { transform: translateY(-12px); }
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

.btn-daftar {
  background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
  color: #ffffff !important;
  border: none;
  border-radius: 10px;
  letter-spacing: 0.2px;
  box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
  transition: all 0.2s ease;
}

.btn-daftar:hover:not(:disabled) {
  background: linear-gradient(135deg, #0284c7, #0ea5e9) !important;
  color: #ffffff !important;
  box-shadow: 0 6px 18px rgba(14, 165, 233, 0.35);
  transform: translateY(-1px);
}

.btn-daftar:active:not(:disabled) {
  transform: translateY(0);
  box-shadow: 0 3px 10px rgba(14, 165, 233, 0.3);
}

.btn-daftar:disabled {
  background: linear-gradient(135deg, #94a3b8, #cbd5e1) !important;
  color: #f1f5f9 !important;
  box-shadow: none;
  opacity: 0.85;
  cursor: not-allowed;
}

.benefit-list {
  text-align: left;
  margin-top: 2rem;
  max-width: 440px;
}
.benefit-item {
  display: flex;
  gap: 12px;
  margin-bottom: 1.25rem;
}
.benefit-icon {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: rgba(56, 189, 248, 0.15);
  color: #38bdf8;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
  flex-shrink: 0;
}
.benefit-title {
  font-weight: 700;
  font-size: 0.88rem;
  color: #ffffff;
  margin-bottom: 2px;
}
.benefit-desc {
  font-size: 0.78rem;
  color: rgba(255, 255, 255, 0.7);
  line-height: 1.4;
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
  .auth-hero .col-lg-6 { width: 100%; max-width: 100%; }
  .benefit-list { margin-top: 1.5rem; }
}

@media (max-width: 767.98px) {
  html:has(body.auth-page) { overflow: auto !important; }
  body.auth-page { overflow: auto !important; height: auto !important; }
  .auth-hero {
    height: auto !important;
    min-height: 100vh !important;
    padding: 24px 0 !important;
    align-items: center !important;
    justify-content: center !important;
  }
  .auth-card {
    max-width: 100% !important;
    margin: 0 auto !important;
  }
  .auth-card .card-body {
    padding: 1.25rem !important;
  }
  .auth-card h5 {
    font-size: 0.95rem !important;
  }
  .auth-card .form-label {
    font-size: 0.75rem !important;
  }
  .auth-card .form-control, .auth-card .form-select {
    font-size: 0.78rem !important;
    padding: 0.45rem 0.75rem !important;
  }
  .auth-logo-ring {
    width: 90px !important;
    height: 90px !important;
    box-shadow: none !important;
    animation: none !important;
  }
}
</style>
@endpush

@section('content')
<section class="auth-hero">

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
  </div>

  <div class="container position-relative py-4" style="z-index: 2;">
    <div class="row align-items-center justify-content-center g-4 g-lg-5">

      {{-- Kolom Kiri: Logo & Benefit List --}}
      <div class="col-lg-5 text-center text-white px-4 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
        <div class="auth-logo-ring mx-auto mb-4">
          <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA">
        </div>
        <h2 class="fw-bold mb-1 auth-heading">
          Gabung Relawan <span class="brand-cyan">SI</span> <span class="brand-red-light">GANA</span>
        </h2>
        <p class="text-white-50 small mb-4" style="max-width: 420px; margin: 0 auto;">
          Mari berkontribusi langsung membantu sesama dan mempercepat pemulihan bencana.
        </p>

        {{-- Benefit list --}}
        <div class="benefit-list mx-auto">
          <div class="benefit-item">
            <div class="benefit-icon">
              <i class="fa-solid fa-award"></i>
            </div>
            <div>
              <p class="benefit-title">Sertifikat Resmi</p>
              <p class="benefit-desc">Dapatkan sertifikat digital apresiasi resmi setelah menyelesaikan penugasan tanggap bencana.</p>
            </div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">
              <i class="fa-solid fa-briefcase"></i>
            </div>
            <div>
              <p class="benefit-title">Pengalaman Lapangan</p>
              <p class="benefit-desc">Asah keahlian kepemimpinan, koordinasi, dan tanggap darurat langsung di lokasi bencana.</p>
            </div>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon">
              <i class="fa-solid fa-users"></i>
            </div>
            <div>
              <p class="benefit-title">Jejaring Sosial</p>
              <p class="benefit-desc">Bergabung dengan komunitas relawan kemanusiaan yang solid dari berbagai wilayah.</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Kolom Kanan: Form Registrasi --}}
      <div class="col-lg-6 px-3" data-aos="fade-left" data-aos-delay="200">
        <div class="card border-0 shadow-lg auth-card mx-auto" style="max-width: 480px;">
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
              <i class="fa-solid fa-hand-holding-heart me-2" style="color: #38bdf8;"></i>Pendaftaran Akun
            </h5>

            {{-- Alert error dari Laravel --}}
            @if ($errors->any())
            <div class="alert alert-danger rounded-3 mb-3 py-2" style="font-size:0.78rem;">
              <i class="fa-solid fa-circle-exclamation me-1"></i>
              <strong>Terdapat kesalahan:</strong>
              <ul class="mb-0 mt-1 ps-3">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <form action="{{ route('register.relawan.store') }}" method="POST" id="formRelawan">
              @csrf

              {{-- DATA DIRI --}}
              <div class="row g-2 mb-2">
                <div class="col-sm-6">
                  <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="name" id="inp_name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Nama lengkap" value="{{ old('name') }}" required>
                </div>
                <div class="col-sm-6">
                  <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                  <select name="jenis_kelamin" id="inp_jk"
                    class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih...</option>
                    <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </div>
              </div>

              <div class="row g-2 mb-2">
                <div class="col-sm-6">
                  <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                  <input type="date" name="tanggal_lahir" id="inp_tgl"
                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                    value="{{ old('tanggal_lahir') }}" required>
                  <div id="hint_tgl" style="font-size:0.72rem;margin-top:3px;"></div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                  <input type="tel" name="phone" id="inp_phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    placeholder="08xx-xxxx-xxxx"
                    inputmode="numeric" pattern="[0-9]*" maxlength="15"
                    value="{{ old('phone') }}" required>
                </div>
              </div>

              <div class="mb-2">
                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="inp_email"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="email@contoh.com" value="{{ old('email') }}" required>
              </div>

              <div class="row g-2 mb-2">
                <div class="col-sm-6">
                  <label class="form-label">Password <span class="text-danger">*</span></label>
                  <div class="position-relative">
                    <input type="password" name="password" id="inputPassword"
                      class="form-control pe-5 @error('password') is-invalid @enderror"
                      placeholder="Min. 8 karakter" required>
                    <button type="button" class="password-toggle"
                      onclick="togglePassword('inputPassword', this)" tabindex="-1">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                </div>
                <div class="col-sm-6">
                  <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                  <div class="position-relative">
                    <input type="password" name="password_confirmation" id="inputPasswordConfirm"
                      class="form-control pe-5" placeholder="Ulangi password" required>
                    <button type="button" class="password-toggle"
                      onclick="togglePassword('inputPasswordConfirm', this)" tabindex="-1">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>

              <div class="syarat-box mb-2">
                <i class="fa-solid fa-circle-info me-1" style="color:#0ea5e9;"></i>
                <strong>Syarat:</strong> WNI usia min. 17 tahun &bull; Bersedia mengikuti penugasan
                &bull; Akun aktif setelah verifikasi admin (1–3 hari kerja).
              </div>

              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="setuju" name="setuju" value="1"
                  {{ old('setuju') ? 'checked' : '' }} required>
                <label class="form-check-label text-muted" for="setuju" style="font-size:0.75rem;">
                  Saya menyetujui <a href="#" class="text-decoration-none" style="color:#0ea5e9;font-weight:600;">Syarat &amp; Ketentuan</a> SIGANA.
                </label>
              </div>

              <div id="err_form" class="alert alert-danger rounded-3 mb-2 py-2 d-none" style="font-size:0.78rem;"></div>

              <button type="submit" id="btnDaftar" class="btn btn-daftar w-100 py-2 fw-semibold" disabled>
                <i class="fa-solid fa-user-plus me-2"></i>Daftar Sebagai Relawan
              </button>
            </form>

            <div class="text-center mt-3 small text-muted">
              Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
              <span class="mx-1">|</span>
              <a href="{{ route('register.create') }}" class="text-decoration-none">Daftar Donatur</a>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
/* ── Only digits filter ── */
function onlyDigits(el, maxLen) {
  el.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, maxLen);
    checkForm();
  });
  el.addEventListener('keydown', function (e) {
    const allowed = ['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End'];
    if (!allowed.includes(e.key) && !/^\d$/.test(e.key)) e.preventDefault();
  });
  el.addEventListener('paste', function (e) {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, maxLen);
    this.value = pasted;
    checkForm();
  });
}

document.addEventListener('DOMContentLoaded', function () {
  onlyDigits(document.getElementById('inp_phone'), 15);

  ['inp_name','inp_jk','inp_tgl','inp_phone','inp_email','inputPassword','inputPasswordConfirm'].forEach(id => {
    const el = document.getElementById(id);
    if (el) { el.addEventListener('input', checkForm); el.addEventListener('change', checkForm); }
  });
  document.getElementById('setuju').addEventListener('change', checkForm);
  checkForm();
});

/* ── Real-time age check ── */
document.getElementById('inp_tgl').addEventListener('input', function () {
  const tgl = this.value;
  const hint = document.getElementById('hint_tgl');
  if (tgl) {
    const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
    hint.innerHTML = age >= 17
      ? '<span style="color:#22c55e;"><i class="fa-solid fa-circle-check me-1"></i>Usia valid.</span>'
      : '<span style="color:#ef4444;"><i class="fa-solid fa-circle-xmark me-1"></i>Usia minimal 17 tahun.</span>';
  } else {
    hint.innerHTML = '';
  }
  checkForm();
});

/* ── Enable / Disable submit button ── */
function checkForm() {
  const name  = document.getElementById('inp_name').value.trim();
  const jk    = document.getElementById('inp_jk').value;
  const tgl   = document.getElementById('inp_tgl').value;
  const phone = document.getElementById('inp_phone').value.trim();
  const email = document.getElementById('inp_email').value.trim();
  const pass  = document.getElementById('inputPassword').value;
  const pass2 = document.getElementById('inputPasswordConfirm').value;
  const agree = document.getElementById('setuju').checked;

  let ageOk = false;
  if (tgl) {
    const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
    ageOk = age >= 17;
  }

  const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  const ok = name && jk && tgl && ageOk && /^\d{10,15}$/.test(phone)
          && emailOk && pass.length >= 8 && pass === pass2 && agree;

  document.getElementById('btnDaftar').disabled = !ok;
}

/* ── Password toggle ── */
function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const icon  = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  }
}

/* ── Submit loading state ── */
document.getElementById('formRelawan').addEventListener('submit', function (e) {
  const msgs = [];
  const name  = document.getElementById('inp_name').value.trim();
  const jk    = document.getElementById('inp_jk').value;
  const tgl   = document.getElementById('inp_tgl').value;
  const phone = document.getElementById('inp_phone').value.trim();
  const email = document.getElementById('inp_email').value.trim();
  const pass  = document.getElementById('inputPassword').value;
  const pass2 = document.getElementById('inputPasswordConfirm').value;
  const agree = document.getElementById('setuju').checked;

  if (!name)                       msgs.push('Nama lengkap wajib diisi.');
  if (!jk)                         msgs.push('Jenis kelamin wajib dipilih.');
  if (!tgl) {
    msgs.push('Tanggal lahir wajib diisi.');
  } else {
    const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
    if (age < 17) msgs.push('Usia minimal pendaftaran relawan adalah 17 tahun.');
  }
  if (!/^\d{10,15}$/.test(phone))  msgs.push('Nomor HP harus 10–15 digit angka.');
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) msgs.push('Format email tidak valid.');
  if (pass.length < 8)             msgs.push('Password minimal 8 karakter.');
  if (pass !== pass2)              msgs.push('Konfirmasi password tidak cocok.');
  if (!agree)                      msgs.push('Anda harus menyetujui Syarat & Ketentuan.');

  const errBox = document.getElementById('err_form');
  if (msgs.length) {
    e.preventDefault();
    errBox.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i><strong>Mohon perbaiki:</strong><ul class="mb-0 mt-1 ps-3">' + msgs.map(m => '<li>' + m + '</li>').join('') + '</ul>';
    errBox.classList.remove('d-none');
    return;
  }

  errBox.classList.add('d-none');
  const btn = document.getElementById('btnDaftar');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
});
</script>
@endpush