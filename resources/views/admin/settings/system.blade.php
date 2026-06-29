@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')
@section('page_title', 'Pengaturan Sistem')

@push('styles')
<style>
  .form-section {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e5e7eb;
  }

  .form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
  }

  .setting-item {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
  }

  .setting-item:last-child {
    border-bottom: none;
  }
</style>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-sliders text-info me-2"></i>Pengaturan Sistem</h5>
    <p class="text-muted small mb-0">Kelola konfigurasi dan preferensi sistem SIGANA.</p>
  </div>
  <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
</div>

<form action="{{ route('admin.settings.system.update') }}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-section">
    <h6><i class="fa-solid fa-bell me-2"></i>Notifikasi</h6>
    <div class="setting-item">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1 fw-medium">Notifikasi Email Donasi Baru</p>
          <small class="text-muted">Kirim email ketika ada donasi baru masuk</small>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="email_notification" name="email_notification" checked>
        </div>
      </div>
    </div>
    <div class="setting-item">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1 fw-medium">Notifikasi Laporan Bencana Baru</p>
          <small class="text-muted">Kirim email ketika ada laporan bencana baru</small>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="report_notification" name="report_notification" checked>
        </div>
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-palette me-2"></i>Tampilan</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="theme" class="form-label">Tema</label>
        <select class="form-select" id="theme" name="theme">
          <option value="light">Terang</option>
          <option value="dark">Gelap</option>
          <option value="auto">Otomatis</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="language" class="form-label">Bahasa</label>
        <select class="form-select" id="language" name="language">
          <option value="id">Bahasa Indonesia</option>
          <option value="en">English</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-chart-line me-2"></i>Dashboard</h6>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="items_per_page" class="form-label">Jumlah Item per Halaman</label>
        <select class="form-select" id="items_per_page" name="items_per_page">
          <option value="10">10</option>
          <option value="20" selected>20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="date_format" class="form-label">Format Tanggal</label>
        <select class="form-select" id="date_format" name="date_format">
          <option value="d/m/Y">dd/mm/yyyy</option>
          <option value="Y-m-d" selected>yyyy-mm-dd</option>
          <option value="d F Y">dd Bulan yyyy</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-section">
    <h6><i class="fa-solid fa-shield-halved me-2"></i>Keamanan</h6>
    <div class="setting-item">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1 fw-medium">Verifikasi Dua Langkah</p>
          <small class="text-muted">Aktifkan verifikasi dua langkah untuk keamanan tambahan</small>
        </div>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="two_factor" name="two_factor">
        </div>
      </div>
    </div>
    <div class="setting-item">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="mb-1 fw-medium">Session Timeout</p>
          <small class="text-muted">Durasi session sebelum otomatis logout (menit)</small>
        </div>
        <div>
          <input type="number" class="form-control form-control-sm" style="width: 100px;" id="session_timeout" name="session_timeout" value="60" min="5" max="480">
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex gap-2 justify-content-end">
    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">
      <i class="fa-solid fa-check me-2"></i>Simpan Pengaturan
    </button>
  </div>
</form>
@endsection
