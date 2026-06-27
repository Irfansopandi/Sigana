@extends('layouts.app')

@section('title', 'Gabung Relawan - SIGANA')
@section('body_class', 'auth-page')

@push('styles')
<style>
body.auth-page #mainNavbar,
body.auth-page footer.footer {
  display: none !important;
}
html:has(body.auth-page),
body.auth-page {
  overflow: hidden !important;
  height: 100vh !important;
}
.auth-hero {
  height: 100vh;
  overflow: hidden;
  position: relative;
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
.bubbles { position: fixed; inset: 0; z-index: 1; overflow: hidden; pointer-events: none; }
.bubbles span {
  position: absolute; bottom: -60px; display: block; border-radius: 50%;
  background: rgba(255,255,255,0.10); border: 1px solid rgba(255,255,255,0.18);
  animation: bubble-rise linear infinite;
}
@keyframes bubble-rise {
  0%   { transform: translateY(0) translateX(0) scale(1); opacity: 0; }
  10%  { opacity: 0.7; }
  50%  { transform: translateY(-50vh) translateX(15px) scale(1.05); }
  90%  { opacity: 0.5; }
  100% { transform: translateY(-105vh) translateX(-10px) scale(0.95); opacity: 0; }
}

/* ── Card utama ── */
.auth-card {
  border-radius: 16px;
  background: rgba(255,255,255,0.98);
  width: 100%;
  max-width: 480px;
}

/* ── Step indicator ── */
.step-indicator {
  display: flex; align-items: center; gap: 0; margin-bottom: 10px;
}
.step-circle {
  width: 28px; height: 28px; border-radius: 50%;
  border: 2px solid #d1d5db;
  display: flex; align-items: center; justify-content: center;
  font-size: 11px; font-weight: 700; color: #9ca3af;
  flex-shrink: 0; transition: all .3s;
}
.step-circle.active  { background: #0ea5e9; border-color: #0ea5e9; color: #fff; }
.step-circle.done    { background: #38bdf8; border-color: #38bdf8; color: #fff; }
.step-line { flex: 1; height: 2px; background: #e5e7eb; transition: background .3s; }
.step-line.done { background: #38bdf8; }

/* ── Form controls ── */
.auth-card .form-label { font-weight: 600; font-size: 0.8rem; color: #374151; margin-bottom: 3px; }
.auth-card .form-control,
.auth-card .form-select {
  border-radius: 8px; border: 1.5px solid #e5e7eb;
  padding: 7px 11px; font-size: 0.82rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.auth-card .form-control:focus,
.auth-card .form-select:focus {
  border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15);
}
.auth-card .form-control.is-invalid { background-image: none !important; }
.input-icon-wrap { position: relative; }
.input-icon-wrap .input-icon {
  position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
  color: #9ca3af; font-size: 0.78rem; pointer-events: none; z-index: 4;
}
.input-icon-wrap .form-control { padding-left: 32px; }
.password-toggle {
  background: none; border: none; position: absolute !important;
  top: 0 !important; right: 0.6rem !important; height: 34px !important;
  display: flex !important; align-items: center !important;
  z-index: 5; padding: 0 !important; color: #9ca3af;
}
.password-toggle:hover { color: #38bdf8 !important; }

/* ── Section heading ── */
.form-section-label {
  font-size: 0.62rem; font-weight: 700; letter-spacing: 1.2px;
  text-transform: uppercase; color: #38bdf8; margin-bottom: 1px;
}
.form-section-heading {
  font-size: 0.88rem; font-weight: 700; color: #111827;
  margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1.5px solid #f1f5f9;
}

/* ── Keahlian checkboxes ── */
.keahlian-check .form-check {
  background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 8px;
  padding: 6px 10px 6px 32px; margin-bottom: 0; transition: all 0.2s; cursor: pointer;
}
.keahlian-check .form-check:has(input:checked) { background: #eff9ff; border-color: #38bdf8; }
.keahlian-check .form-check-input { margin-left: -18px; margin-top: 2px; accent-color: #0ea5e9; }
.keahlian-check .form-check-label { font-size: 0.76rem; color: #374151; cursor: pointer; }

/* ── Syarat box ── */
.syarat-box {
  background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px;
  padding: 10px 14px; font-size: 0.76rem; color: #0c4a6e; line-height: 1.6;
}

/* ── Buttons ── */
.btn-step-next {
  background: linear-gradient(135deg, #17a8ec, #38bdf8) !important;
  color: #fff !important; border: none; border-radius: 8px;
  font-weight: 700; font-size: 0.85rem; padding: 8px 18px;
  transition: all 0.2s; box-shadow: 0 4px 14px rgba(14,165,233,0.3);
}
.btn-step-next:hover:not(:disabled) {
  background: linear-gradient(135deg, #10689f, #1705b5) !important;
  box-shadow: 0 6px 20px rgba(21,18,209,0.35); color: #fff !important;
}
.btn-step-next:disabled { opacity: 0.45 !important; cursor: not-allowed !important; box-shadow: none !important; }
.btn-step-back {
  background: #f3f4f6 !important; color: #6b7280 !important;
  border: none; border-radius: 8px; font-weight: 600;
  font-size: 0.85rem; padding: 8px 18px; transition: all 0.2s;
}
.btn-step-back:hover { background: #e5e7eb !important; color: #374151 !important; }

/* ── Footer link ── */
.auth-footer-link { text-align: center; font-size: 0.78rem; color: #6b7280; margin-top: 8px; }
.auth-footer-link a { color: #0ea5e9; font-weight: 600; text-decoration: none; }
.auth-footer-link a:hover { text-decoration: underline; }

/* ── Step panes ── */
.step-pane { display: none; }
.step-pane.active { display: block; }

/* ── Mobile fix ── */
@media (max-width: 767.98px) {
  html:has(body.auth-page),
  body.auth-page {
    overflow: hidden !important;
    height: 100vh !important;
  }
  .auth-hero {
    height: 100vh !important;
    overflow-y: auto !important;
    align-items: center !important;
    padding: 12px 0 !important;
  }
  .auth-card {
    max-width: 280px !important;
    margin: 0 auto !important;
  }
  .auth-card .card-body {
    padding: 0.85rem !important;
  }
  .auth-card h5 {
    font-size: 0.85rem !important;
  }
  .auth-card div[style*="border-radius:50%"] {
    box-shadow: none !important;
  }
  .auth-card .form-label {
    font-size: 0.7rem !important;
  }
  .auth-card .form-control,
  .auth-card .form-select {
    font-size: 0.74rem !important;
    padding: 0.4rem 0.6rem !important;
  }
  .auth-card .input-icon-wrap .form-control {
    padding-left: 30px !important;
  }
  .auth-card .input-icon-wrap .input-icon {
    left: 10px !important;
    font-size: 0.7rem !important;
  }
  .auth-card .step-circle {
    width: 22px !important;
    height: 22px !important;
    font-size: 9px !important;
  }
  .auth-card .form-section-heading {
    font-size: 0.78rem !important;
  }
  .auth-card .keahlian-check .form-check-label {
    font-size: 0.68rem !important;
  }
  .auth-card .btn-step-next,
  .auth-card .btn-step-back {
    font-size: 0.76rem !important;
    padding: 0.45rem 0.9rem !important;
  }

  .auth-card .d-flex.align-items-center.gap-3.mb-3 {
    margin-bottom: 0.5rem !important;
  }
  .auth-card .row.g-2 {
    margin-bottom: 0 !important;
  }
  .auth-card .mb-2 {
    margin-bottom: 0.4rem !important;
  }
  .auth-card textarea.form-control {
    min-height: 44px !important;
  }
  .auth-card .form-section-heading {
    margin-bottom: 6px !important;
    padding-bottom: 4px !important;
  }
  .auth-card .step-indicator {
    margin-bottom: 4px !important;
  }
  .auth-card .form-section-label {
    margin-bottom: 0 !important;
    font-size: 0.55rem !important;
  }
  .auth-card p.text-muted {
    font-size: 0.65rem !important;
    line-height: 1.3 !important;
  }
  .auth-card .form-control,
  .auth-card .form-select {
    padding: 0.32rem 0.55rem !important;
  }
  .auth-card textarea.form-control {
    padding: 0.32rem 0.55rem !important;
  }
  .auth-card .auth-footer-link {
    margin-top: 4px !important;
    font-size: 0.72rem !important;
  }
}
</style>
@endpush

@section('content')
<section class="auth-hero">

  {{-- Bubbles --}}
  <div class="bubbles">
    <span style="left:5%;width:18px;height:18px;animation-duration:14s;animation-delay:0s;"></span>
    <span style="left:15%;width:12px;height:12px;animation-duration:10s;animation-delay:2s;"></span>
    <span style="left:25%;width:22px;height:22px;animation-duration:18s;animation-delay:1s;"></span>
    <span style="left:40%;width:14px;height:14px;animation-duration:12s;animation-delay:4s;"></span>
    <span style="left:60%;width:20px;height:20px;animation-duration:16s;animation-delay:0.5s;"></span>
    <span style="left:75%;width:10px;height:10px;animation-duration:9s;animation-delay:3s;"></span>
    <span style="left:85%;width:24px;height:24px;animation-duration:17s;animation-delay:2.5s;"></span>
    <span style="left:93%;width:16px;height:16px;animation-duration:13s;animation-delay:1.5s;"></span>
  </div>

  <div class="position-relative" style="z-index:2; width:100%; display:flex; justify-content:center; padding: 0 16px;">
    <div class="card border-0 shadow-lg auth-card">
      <div class="card-body p-3 p-md-4">

        {{-- Logo + Judul --}}
        <div class="d-flex align-items-center gap-3 mb-3">
          <div style="width:48px;height:48px;border-radius:50%;background:#fff;padding:4px;
                      box-shadow:0 0 0 4px rgba(56,189,248,0.2);flex-shrink:0;overflow:hidden;">
            <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA"
                 style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
          </div>
          <div>
            <h5 class="mb-0 fw-bold" style="font-size:1rem;">
              <i class="fa-solid fa-hand-holding-heart me-1" style="color:#38bdf8;"></i>Daftar Relawan
            </h5>
            <p class="text-muted mb-0" style="font-size:0.73rem;">
              Akun diverifikasi admin dalam 1–3 hari kerja.
            </p>
          </div>
        </div>

        {{-- Step Indicator --}}
        <div class="step-indicator mb-1" id="stepIndicator">
          <div class="step-circle active" id="sc1">1</div>
          <div class="step-line" id="sl1"></div>
          <div class="step-circle" id="sc2">2</div>
          <div class="step-line" id="sl2"></div>
          <div class="step-circle" id="sc3">3</div>
        </div>
        <div class="mb-2">
          <small id="stepLabel" class="text-muted fw-semibold" style="font-size:0.7rem;letter-spacing:.5px;"></small>
        </div>

        {{-- Alert error dari Laravel --}}
        @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-2 py-2" style="font-size:0.78rem;">
          <i class="fa-solid fa-circle-exclamation me-1"></i>
          <strong>Terdapat kesalahan:</strong>
          <ul class="mb-0 mt-1 ps-3">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ route('register.relawan.store') }}" method="POST" enctype="multipart/form-data" id="formRelawan">
          @csrf

          {{-- FASE 1 --}}
          <div class="step-pane active" id="pane1">
            <p class="form-section-label">01</p>
            <h6 class="form-section-heading">
              <i class="fa-solid fa-user me-2" style="color:#38bdf8;"></i>Data Diri
            </h6>

            <div class="row g-2 mb-2">
              <div class="col-sm-6">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-icon-wrap">
                  <i class="input-icon fa-solid fa-user"></i>
                  <input type="text" name="name" id="inp_name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Sesuai KTP" value="{{ old('name') }}">
                </div>
                @error('name')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
              </div>
              <div class="col-sm-6">
                <label class="form-label">NIK <span class="text-danger">*</span></label>
                <div class="input-icon-wrap">
                  <i class="input-icon fa-solid fa-id-card"></i>
                  <input type="text" name="nik" id="inp_nik"
                    class="form-control @error('nik') is-invalid @enderror"
                    placeholder="16 digit NIK" maxlength="16"
                    inputmode="numeric" pattern="[0-9]*"
                    value="{{ old('nik') }}">
                </div>
                @error('nik')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="row g-2 mb-2">
              <div class="col-sm-6">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" id="inp_jk"
                  class="form-select @error('jenis_kelamin') is-invalid @enderror">
                  <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih...</option>
                  <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
              </div>
              <div class="col-sm-6">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_lahir" id="inp_tgl"
                  class="form-control @error('tanggal_lahir') is-invalid @enderror"
                  value="{{ old('tanggal_lahir') }}">
                  <div id="hint_tgl" style="font-size:0.72rem;margin-top:3px;"></div>
                @error('tanggal_lahir')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
              <div class="input-icon-wrap">
                <i class="input-icon fa-solid fa-phone"></i>
                <input type="tel" name="phone" id="inp_phone"
                  class="form-control @error('phone') is-invalid @enderror"
                  placeholder="08xx-xxxx-xxxx"
                  inputmode="numeric" pattern="[0-9]*" maxlength="15"
                  value="{{ old('phone') }}">
              </div>
              @error('phone')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-2">
              <label class="form-label">Alamat Domisili <span class="text-danger">*</span></label>
              <textarea name="alamat" id="inp_alamat" rows="2"
                class="form-control @error('alamat') is-invalid @enderror"
                placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi">{{ old('alamat') }}</textarea>
              @error('alamat')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
            </div>

            <div id="err_fase1" class="alert alert-danger rounded-3 mb-2 py-2 d-none" style="font-size:0.78rem;"></div>

            <div class="d-flex justify-content-end">
              <button type="button" id="btnNext1" class="btn btn-step-next" onclick="nextStep1()" disabled>
                Selanjutnya <i class="fa-solid fa-arrow-right ms-1"></i>
              </button>
            </div>
          </div>

          {{-- FASE 2 --}}
          <div class="step-pane" id="pane2">
            <p class="form-section-label">02</p>
            <h6 class="form-section-heading">
              <i class="fa-solid fa-wrench me-2" style="color:#38bdf8;"></i>Keahlian & Kompetensi
            </h6>

            <div class="mb-2">
              <label class="form-label">Bidang Keahlian <span class="text-danger">*</span>
                <span class="text-muted fw-normal">(min. 1)</span></label>
              @php
                $keahlianList = [
                  ['val'=>'medis',       'label'=>'Medis / P3K',            'icon'=>'fa-kit-medical'],
                  ['val'=>'logistik',    'label'=>'Logistik & Distribusi',   'icon'=>'fa-truck'],
                  ['val'=>'evakuasi',    'label'=>'Evakuasi & SAR',          'icon'=>'fa-person-running'],
                  ['val'=>'psikologi',   'label'=>'Psikologi / Konseling',   'icon'=>'fa-heart'],
                  ['val'=>'dokumentasi', 'label'=>'Dokumentasi / Foto-Video','icon'=>'fa-camera'],
                  ['val'=>'it',          'label'=>'Teknologi Informasi',     'icon'=>'fa-laptop-code'],
                  ['val'=>'dapur',       'label'=>'Dapur Umum',              'icon'=>'fa-utensils'],
                  ['val'=>'lainnya',     'label'=>'Lainnya',                 'icon'=>'fa-ellipsis'],
                ];
                $selectedKeahlian = old('keahlian', []);
              @endphp
              <div class="row keahlian-check g-2">
                @foreach($keahlianList as $k)
                <div class="col-6">
                  <div class="form-check">
                    <input class="form-check-input keahlian-cb" type="checkbox"
                      name="keahlian[]" id="keahlian_{{ $k['val'] }}"
                      value="{{ $k['val'] }}"
                      {{ in_array($k['val'], $selectedKeahlian) ? 'checked' : '' }}>
                    <label class="form-check-label" for="keahlian_{{ $k['val'] }}">
                      <i class="fa-solid {{ $k['icon'] }} me-1" style="color:#0ea5e9;font-size:0.72rem;"></i>
                      {{ $k['label'] }}
                    </label>
                  </div>
                </div>
                @endforeach
              </div>
              @error('keahlian')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
            </div>

            <div class="mb-2">
              <label class="form-label">Pengalaman Kerelawanan
                <span class="text-muted fw-normal">(opsional)</span></label>
              <textarea name="pengalaman" rows="2"
                class="form-control @error('pengalaman') is-invalid @enderror"
                placeholder="Ceritakan pengalaman kerelawanan sebelumnya...">{{ old('pengalaman') }}</textarea>
            </div>

            <div class="mb-2">
              <label class="form-label">Foto KTP
                <span class="text-muted fw-normal">(opsional, mempercepat verifikasi)</span></label>
              <input type="file" name="foto_ktp" accept="image/*"
                class="form-control @error('foto_ktp') is-invalid @enderror">
              <div class="form-text" style="font-size:0.7rem;">Format JPG/PNG, maks. 2MB.</div>
              @error('foto_ktp')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
            </div>

            <div id="err_fase2" class="alert alert-danger rounded-3 mb-2 py-2 d-none" style="font-size:0.78rem;"></div>

            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-step-back" onclick="goBack(1)">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
              </button>
              <button type="button" id="btnNext2" class="btn btn-step-next" onclick="nextStep2()" disabled>
                Selanjutnya <i class="fa-solid fa-arrow-right ms-1"></i>
              </button>
            </div>
          </div>

          {{-- FASE 3 --}}
          <div class="step-pane" id="pane3">
            <p class="form-section-label">03</p>
            <h6 class="form-section-heading">
              <i class="fa-solid fa-lock me-2" style="color:#38bdf8;"></i>Data Akun
            </h6>

            <div class="mb-2">
              <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
              <div class="input-icon-wrap">
                <i class="input-icon fa-solid fa-envelope"></i>
                <input type="email" name="email" id="inp_email"
                  class="form-control @error('email') is-invalid @enderror"
                  placeholder="email@contoh.com" value="{{ old('email') }}">
              </div>
              @error('email')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
            </div>

            <div class="row g-2 mb-2">
              <div class="col-sm-6">
                <label class="form-label">Password <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <input type="password" name="password" id="inputPassword"
                    class="form-control pe-5 @error('password') is-invalid @enderror"
                    placeholder="Min. 8 karakter">
                  <button type="button" class="password-toggle"
                    onclick="togglePassword('inputPassword', this)" tabindex="-1">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
                @error('password')<div class="text-danger mt-1" style="font-size:0.73rem;">{{ $message }}</div>@enderror
              </div>
              <div class="col-sm-6">
                <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                <div class="position-relative">
                  <input type="password" name="password_confirmation" id="inputPasswordConfirm"
                    class="form-control pe-5" placeholder="Ulangi password">
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
              &bull; Data valid &bull; Aktif setelah verifikasi admin (1–3 hari kerja).
            </div>

            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="setuju" name="setuju" value="1"
                {{ old('setuju') ? 'checked' : '' }}>
              <label class="form-check-label" for="setuju" style="font-size:0.78rem;color:#374151;">
                Saya menyetujui
                <a href="#" class="text-decoration-none" style="color:#0ea5e9;font-weight:600;">Syarat &amp; Ketentuan</a>
                serta
                <a href="#" class="text-decoration-none" style="color:#0ea5e9;font-weight:600;">Kebijakan Privasi</a>
                SIGANA.
              </label>
            </div>

            <div id="err_fase3" class="alert alert-danger rounded-3 mb-2 py-2 d-none" style="font-size:0.78rem;"></div>

            <div class="d-flex justify-content-between align-items-center gap-2">
              <button type="button" class="btn btn-step-back" onclick="goBack(2)">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali
              </button>
              <button type="submit" id="btnDaftar"
                class="btn btn-step-next flex-fill" disabled>
                <i class="fa-solid fa-user-plus me-2"></i>Daftar Sebagai Relawan
              </button>
            </div>
          </div>

        </form>

        <p class="auth-footer-link mt-2">
          <a href="{{ route('login') }}">Login</a>
          <span class="text-muted mx-1"> & </span>
          <a href="{{ route('register.create') }}">Daftar sebagai Donatur</a>
        </p>

      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
/* ─────────────────────────────────────────
   STEP STATE
───────────────────────────────────────── */
let currentStep = 1;

const stepLabels = {
  1: 'LANGKAH 1 DARI 3 — Data Diri',
  2: 'LANGKAH 2 DARI 3 — Keahlian & Kompetensi',
  3: 'LANGKAH 3 DARI 3 — Data Akun & Persetujuan',
};

function updateIndicator(step) {
  for (let i = 1; i <= 3; i++) {
    const sc = document.getElementById('sc' + i);
    sc.classList.remove('active', 'done');
    if (i < step)       { sc.classList.add('done'); sc.innerHTML = '<i class="fa-solid fa-check" style="font-size:11px;"></i>'; }
    else if (i === step){ sc.classList.add('active'); sc.textContent = i; }
    else                { sc.textContent = i; }
  }
  for (let i = 1; i <= 2; i++) {
    document.getElementById('sl' + i).classList.toggle('done', i < step);
  }
  document.getElementById('stepLabel').textContent = stepLabels[step];
}

function showPane(step) {
  document.querySelectorAll('.step-pane').forEach(p => p.classList.remove('active'));
  document.getElementById('pane' + step).classList.add('active');
  updateIndicator(step);
  currentStep = step;
}

/* ─────────────────────────────────────────
   ONLY-DIGITS FILTER — NIK & PHONE
───────────────────────────────────────── */
function onlyDigits(el, maxLen) {
  el.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, maxLen);
    checkStep1();
  });
  el.addEventListener('keydown', function (e) {
    const allowed = ['Backspace','Delete','Tab','ArrowLeft','ArrowRight','Home','End'];
    if (!allowed.includes(e.key) && !/^\d$/.test(e.key)) e.preventDefault();
  });
  el.addEventListener('paste', function (e) {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, maxLen);
    this.value = pasted;
    checkStep1();
  });
}

document.addEventListener('DOMContentLoaded', function () {
  onlyDigits(document.getElementById('inp_nik'),   16);
  onlyDigits(document.getElementById('inp_phone'), 15);

  // Pasang listener untuk real-time enable/disable tombol
  ['inp_name','inp_nik','inp_jk','inp_tgl','inp_phone','inp_alamat'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', checkStep1);
    if (el) el.addEventListener('change', checkStep1);
  });

  document.querySelectorAll('.keahlian-cb').forEach(cb => cb.addEventListener('change', checkStep2));

  ['inputPassword','inputPasswordConfirm','inp_email'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', checkStep3);
  });
  document.getElementById('setuju').addEventListener('change', checkStep3);

  updateIndicator(1);
  checkStep1();
});

/* ─────────────────────────────────────────
   CHECK — ENABLE / DISABLE TOMBOL NEXT
───────────────────────────────────────── */
function checkStep1() {
  const name  = document.getElementById('inp_name').value.trim();
  const nik   = document.getElementById('inp_nik').value.trim();
  const jk    = document.getElementById('inp_jk').value;
  const tgl   = document.getElementById('inp_tgl').value;
  const phone = document.getElementById('inp_phone').value.trim();
  const alamat= document.getElementById('inp_alamat').value.trim();
  const hintTgl = document.getElementById('hint_tgl');

  let ageOk = false;
  if (tgl) {
    const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
    ageOk = age >= 17;
    if (!ageOk) {
      hintTgl.innerHTML = '<span style="color:#ef4444;"><i class="fa-solid fa-circle-xmark me-1"></i>Usia minimal 17 tahun.</span>';
    } else {
      hintTgl.innerHTML = '<span style="color:#22c55e;"><i class="fa-solid fa-circle-check me-1"></i>Usia valid.</span>';
    }
  } else {
    hintTgl.innerHTML = '';
  }

  const ok = name && /^\d{16}$/.test(nik) && jk && tgl && ageOk
             && /^\d{10,15}$/.test(phone) && alamat;

  document.getElementById('btnNext1').disabled = !ok;
}

function checkStep2() {
  const keahlianChecked = document.querySelectorAll('.keahlian-cb:checked').length > 0;
  document.getElementById('btnNext2').disabled = !keahlianChecked;
}

function checkStep3() {
  const email  = document.getElementById('inp_email').value.trim();
  const pass   = document.getElementById('inputPassword').value;
  const pass2  = document.getElementById('inputPasswordConfirm').value;
  const setuju = document.getElementById('setuju').checked;

  const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  const ok = emailOk && pass.length >= 8 && pass === pass2 && setuju;
  document.getElementById('btnDaftar').disabled = !ok;
}

/* ─────────────────────────────────────────
   VALIDATE & NEXT
───────────────────────────────────────── */
function nextStep1() {
  const name  = document.getElementById('inp_name').value.trim();
  const nik   = document.getElementById('inp_nik').value.trim();
  const jk    = document.getElementById('inp_jk').value;
  const tgl   = document.getElementById('inp_tgl').value;
  const phone = document.getElementById('inp_phone').value.trim();
  const alamat= document.getElementById('inp_alamat').value.trim();
  const err   = document.getElementById('err_fase1');
  const msgs  = [];

  if (!name)               msgs.push('Nama lengkap wajib diisi.');
  if (!/^\d{16}$/.test(nik)) msgs.push('NIK harus tepat 16 digit angka.');
  if (!jk)                 msgs.push('Jenis kelamin wajib dipilih.');
  if (!tgl) {
    msgs.push('Tanggal lahir wajib diisi.');
  } else {
    const age = (new Date() - new Date(tgl)) / (365.25 * 24 * 3600 * 1000);
    if (age < 17) msgs.push('Usia minimal pendaftaran relawan adalah 17 tahun.');
  }
  if (!/^\d{10,15}$/.test(phone)) msgs.push('Nomor HP harus 10–15 digit angka.');
  if (!alamat) msgs.push('Alamat domisili wajib diisi.');

  if (msgs.length) {
    err.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i><strong>Mohon perbaiki:</strong><ul class="mb-0 mt-1 ps-3">' + msgs.map(m => '<li>' + m + '</li>').join('') + '</ul>';
    err.classList.remove('d-none');
    return;
  }
  err.classList.add('d-none');
  showPane(2);
  checkStep2();
}

function nextStep2() {
  const keahlian = document.querySelectorAll('.keahlian-cb:checked').length;
  const err = document.getElementById('err_fase2');
  if (!keahlian) {
    err.innerHTML = '<i class="fa-solid fa-circle-exclamation me-1"></i> Pilih minimal satu bidang keahlian.';
    err.classList.remove('d-none');
    return;
  }
  err.classList.add('d-none');
  showPane(3);
  checkStep3();
}

function goBack(toStep) {
  showPane(toStep);
  if (toStep === 1) checkStep1();
  if (toStep === 2) checkStep2();
}

/* ─────────────────────────────────────────
   PASSWORD TOGGLE
───────────────────────────────────────── */
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

/* ─────────────────────────────────────────
   SUBMIT — loading state
───────────────────────────────────────── */
document.getElementById('formRelawan').addEventListener('submit', function () {
  const btn = document.getElementById('btnDaftar');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
});
</script>
@endpush