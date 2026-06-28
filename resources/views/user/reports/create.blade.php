@extends('user.layouts.app')

@section('title', 'Lapor Bencana')
@section('page_title', 'Lapor Bencana')

@push('styles')
<style>
  .form-section {
    border-left: 3px solid var(--cyan, #38bdf8);
    background: #f8fafc;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 20px;
  }
  .form-section-title {
    font-size: .8rem;
    font-weight: 700;
    color: var(--navy-900, #0a2540);
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .form-section-title i { color: var(--cyan, #38bdf8); font-size: .9rem; }
  .form-label {
    font-size: .82rem;
    font-weight: 600;
    color: #334155;
  }
  .form-control, .form-select {
    font-size: .9rem;
  }
  .form-control:focus {
    border-color: var(--cyan, #38bdf8);
    box-shadow: 0 0 0 3px rgba(56,189,248,.15);
  }
  .file-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #e0f2fe;
    color: #0369a1;
    font-size: .75rem;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 999px;
    margin: 4px 4px 0 0;
  }
  .file-pill i { font-size: .7rem; }
  .file-preview-empty {
    font-size: .78rem;
    color: #94a3b8;
    margin-top: 6px;
  }
  #btnGetLocation {
    border-radius: 8px;
  }

  .btn-kirim {
    background: var(--cyan, #38bdf8);
    border: none;
    color: #fff;
    font-weight: 600;
    transition: all .2s;
  }
  .btn-kirim:hover {
    background: #0ea5e9;
    color: #fff;
  }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="fa-solid fa-triangle-exclamation text-danger"></i>
          <h5 class="fw-bold mb-0">Laporkan kejadian bencana</h5>
        </div>
        <p class="text-muted small mb-4">Unggah foto kejadian, maksimal 3 dokumentasi pendukung, serta deskripsi singkat dan lengkap.</p>

        <form action="{{ route('user.lapor-bencana.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          {{-- ── INFO LAPORAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-circle-info"></i> Info Laporan</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Judul Laporan</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Banjir Bandang Cikampek" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Lokasi Kejadian</label>
                <input type="text" name="location" class="form-control" placeholder="Contoh: Kec. Cikampek, Karawang" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Kategori</label>
                <input type="text" name="category" class="form-control" placeholder="Contoh: Banjir" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Korban Terdampak <span class="text-muted">(orang)</span></label>
                <input type="number" name="victims" class="form-control" placeholder="Contoh: 25" min="0" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Foto Utama</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required>
                <div id="imagePreview" class="file-preview-empty">Belum ada foto dipilih</div>
              </div>
            </div>
          </div>

          {{-- ── LOKASI & KOORDINAT ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-location-dot"></i> Koordinat Lokasi</div>
            <div class="row g-3 align-items-end">
              <div class="col-md-5">
                <label class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="-6.301399" required>
              </div>
              <div class="col-md-5">
                <label class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="107.451233" required>
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-outline-primary w-100" id="btnGetLocation">
                  <i class="fa-solid fa-location-crosshairs"></i>
                </button>
              </div>
            </div>
            <small class="text-muted d-block mt-2">
              <i class="fa-regular fa-circle-question"></i> Klik tombol di samping untuk isi otomatis dari GPS browser kamu
            </small>
          </div>

          {{-- ── LAMPIRAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-paperclip"></i> Dokumentasi Pendukung</div>
            <label class="form-label">Unggah file <span class="text-muted">(maks. 3 file — foto/PDF)</span></label>
            <input type="file" name="documentation[]" id="documentation" class="form-control" accept=".pdf,image/*" multiple>
            <div id="docPreview" class="file-preview-empty">Belum ada file dipilih</div>
          </div>

          {{-- ── DESKRIPSI ── --}}
          <div class="form-section mb-3">
            <div class="form-section-title"><i class="fa-solid fa-align-left"></i> Deskripsi</div>
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Deskripsi Singkat <span class="text-muted">(maks. 500 karakter)</span></label>
                <textarea name="description_short" class="form-control" rows="2" maxlength="500" placeholder="Ringkasan singkat kejadian..." required></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="description_long" class="form-control" rows="5" placeholder="Jelaskan kronologi, dampak, dan kondisi terkini secara lengkap..." required></textarea>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('user.lapor-bencana') }}" class="btn btn-outline-secondary">
              <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-kirim px-4">
              <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Preview nama foto utama
  document.getElementById('imageInput').addEventListener('change', function() {
    const preview = document.getElementById('imagePreview');
    if (this.files.length > 0) {
      preview.innerHTML = `<span class="file-pill"><i class="fa-solid fa-image"></i> ${this.files[0].name}</span>`;
    } else {
      preview.innerHTML = 'Belum ada foto dipilih';
    }
  });

  // Batasi maksimal 3 file untuk dokumentasi + preview nama file
  document.getElementById('documentation').addEventListener('change', function() {
    const preview = document.getElementById('docPreview');

    if (this.files.length > 3) {
      Swal.fire({
        icon: 'warning',
        title: 'Maksimal 3 file',
        text: 'Kamu hanya bisa upload maksimal 3 dokumentasi sekaligus.',
      });
      this.value = '';
      preview.innerHTML = 'Belum ada file dipilih';
      return;
    }

    if (this.files.length > 0) {
      let pills = '';
      Array.from(this.files).forEach(file => {
        const isPdf = file.name.toLowerCase().endsWith('.pdf');
        pills += `<span class="file-pill"><i class="fa-solid ${isPdf ? 'fa-file-pdf' : 'fa-image'}"></i> ${file.name}</span>`;
      });
      preview.innerHTML = pills;
    } else {
      preview.innerHTML = 'Belum ada file dipilih';
    }
  });

  // Ambil latitude & longitude otomatis dari GPS browser
  document.getElementById('btnGetLocation').addEventListener('click', function() {
  if (!navigator.geolocation) {
    Swal.fire('Gagal', 'Browser tidak mendukung fitur geolocation.', 'error');
    return;
  }
  navigator.geolocation.getCurrentPosition(function(pos) {
    document.getElementById('latitude').value = pos.coords.latitude;
    document.getElementById('longitude').value = pos.coords.longitude;
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: 'Lokasi berhasil diambil',
      showConfirmButton: false,
      timer: 2000,
      background: '#16a34a',
      color: '#fff',
      iconColor: '#fff',
    });
  }, function(error) {
    let msg = 'Tidak bisa mengambil lokasi.';
    switch (error.code) {
      case error.PERMISSION_DENIED:
        msg = 'Akses lokasi ditolak. Klik ikon gembok/info di address bar browser, lalu izinkan akses lokasi untuk situs ini.';
        break;
      case error.POSITION_UNAVAILABLE:
        msg = 'Lokasi tidak tersedia. Pastikan Location Services aktif di laptop/HP kamu.';
        break;
      case error.TIMEOUT:
        msg = 'Waktu pengambilan lokasi habis. Coba lagi.';
        break;
    }
    console.error('Geolocation error:', error.code, error.message);
    Swal.fire('Gagal', msg, 'error');
  }, {
    enableHighAccuracy: true,
    timeout: 10000,
    maximumAge: 0
  });
});
</script>
@endpush
@endsection