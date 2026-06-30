@extends('user.layouts.app')

@section('title', 'Lapor Bencana')
@section('page_title', 'Lapor Bencana')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
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
  .form-label { font-size: .82rem; font-weight: 600; color: #334155; }
  .form-control, .form-select { font-size: .9rem; }
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
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    transition: all .2s;
  }
  #btnGetLocation:hover { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }
  .btn-kirim {
    background: var(--cyan, #38bdf8);
    border: none;
    color: #fff;
    font-weight: 600;
    transition: all .2s;
  }
  .btn-kirim:hover { background: #0ea5e9; color: #fff; }
  .doc-slot-item {
    border: 1.5px dashed #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: #f8fafc;
    transition: border-color .2s;
  }
  .doc-slot-item:hover { border-color: #93c5fd; }
  #map { height: 220px; border-radius: 10px; border: 1.5px solid #e2e8f0; margin-top: 10px; }
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
                <button type="button" class="w-100" id="btnGetLocation">
                  <i class="fa-solid fa-location-crosshairs me-1"></i>Deteksi
                </button>
              </div>
            </div>
            <small class="text-muted d-block mt-2">
              <i class="fa-regular fa-circle-question"></i> Klik tombol di samping untuk isi otomatis dari GPS browser kamu
            </small>
            <div id="map"></div>
            <small class="text-muted mt-2 d-block"><i class="fa-solid fa-info-circle me-1"></i>Klik pada peta untuk memilih koordinat secara manual.</small>
          </div>

          {{-- ── KEBUTUHAN LOGISTIK ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-truck"></i> Kebutuhan Logistik Mendesak</div>
            <p class="text-muted small mb-3">Tambahkan barang/bantuan yang dibutuhkan di lokasi beserta target jumlahnya (opsional).</p>

            <div id="needsWrapper">
              <div class="row g-2 mb-2 need-row">
                <div class="col-md-6">
                  <input type="text" class="form-control" name="needs[0][name]" placeholder="Contoh: Truk Tangki Air Bersih">
                </div>
                <div class="col-md-5">
                  <input type="text" class="form-control" name="needs[0][qty]" placeholder="Contoh: 100 Tangki">
                </div>
                <div class="col-md-1 d-flex align-items-center">
                  <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-need"><i class="fa-solid fa-trash"></i></button>
                </div>
              </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btnAddNeed">
              <i class="fa-solid fa-plus me-1"></i>Tambah Kebutuhan
            </button>
          </div>

          {{-- ── LAMPIRAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-paperclip"></i> Dokumentasi Pendukung</div>
            <p class="text-muted small mb-3">Unggah hingga 3 dokumentasi pendukung (foto/PDF, maks. 2MB per file).</p>

            <div class="row g-3">
              @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                  <div class="doc-slot-item">
                    <div class="small text-muted mb-2 fw-semibold">Dokumentasi {{ $i }}</div>

                    <div id="docPreview{{ $i }}">
                      <div class="text-muted small py-3 text-center border rounded">Belum ada file</div>
                    </div>

                    <div class="d-flex gap-2 mt-2">
                      <input type="file" class="form-control form-control-sm doc-single-input"
                        data-slot="{{ $i }}" name="documentation_slot_{{ $i }}" accept=".pdf,image/*">
                    </div>
                  </div>
                </div>
              @endfor
            </div>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
    // Preview dokumentasi per slot
  document.querySelectorAll('.doc-single-input').forEach(input => {
    input.addEventListener('change', function() {
      const slot = this.dataset.slot;
      const preview = document.getElementById('docPreview' + slot);

      if (this.files && this.files[0]) {
        const file = this.files[0];

        if (file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = ev => {
            preview.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:80px;object-fit:cover;border-radius:6px;" alt="Preview">`;
          };
          reader.readAsDataURL(file);
        } else {
          preview.innerHTML = `
            <div class="d-flex align-items-center gap-2 py-2">
              <i class="fa-solid fa-file-pdf text-danger fa-lg"></i>
              <span class="small">${file.name}</span>
            </div>`;
        }
      } else {
        preview.innerHTML = '<div class="text-muted small py-3 text-center border rounded">Belum ada file</div>';
      }
    });
  });

  // Ambil latitude & longitude otomatis dari GPS browser
  document.getElementById('btnGetLocation').addEventListener('click', function() {
    if (!navigator.geolocation) {
      Swal.fire('Gagal', 'Browser tidak mendukung fitur geolocation.', 'error');
      return;
    }
    navigator.geolocation.getCurrentPosition(function(pos) {
      updateCoords(pos.coords.latitude, pos.coords.longitude);
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

  // Peta Leaflet
  const map = L.map('map').setView([-2.5, 118.0], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(map);

  let marker = L.marker([-2.5, 118.0], { draggable: true }).addTo(map);
  marker.on('dragend', function() {
    const pos = marker.getLatLng();
    updateCoords(pos.lat, pos.lng);
  });

  function updateCoords(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
    if (!marker) {
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);
      marker.on('dragend', function() {
        const pos = marker.getLatLng();
        updateCoords(pos.lat, pos.lng);
      });
    } else {
      marker.setLatLng([lat, lng]);
    }
    map.setView([lat, lng], 13);
  }

  map.on('click', function(e) {
    updateCoords(e.latlng.lat, e.latlng.lng);
  });

  ['latitude', 'longitude'].forEach(id => {
    document.getElementById(id).addEventListener('change', function() {
      const lat = parseFloat(document.getElementById('latitude').value);
      const lng = parseFloat(document.getElementById('longitude').value);
      if (!isNaN(lat) && !isNaN(lng)) updateCoords(lat, lng);
    });
  });

  // Kebutuhan Logistik
  let needIndex = document.querySelectorAll('.need-row').length;

  document.getElementById('btnAddNeed').addEventListener('click', function() {
    const wrapper = document.getElementById('needsWrapper');
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 need-row';
    row.innerHTML = `
      <div class="col-md-6">
        <input type="text" class="form-control" name="needs[${needIndex}][name]" placeholder="Contoh: Truk Tangki Air Bersih">
      </div>
      <div class="col-md-5">
        <input type="text" class="form-control" name="needs[${needIndex}][qty]" placeholder="Contoh: 100 Tangki">
      </div>
      <div class="col-md-1 d-flex align-items-center">
        <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-need"><i class="fa-solid fa-trash"></i></button>
      </div>`;
    wrapper.appendChild(row);
    needIndex++;
  });

  document.getElementById('needsWrapper').addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-remove-need');
    if (btn) {
      const rows = document.querySelectorAll('.need-row');
      if (rows.length > 1) {
        btn.closest('.need-row').remove();
      } else {
        btn.closest('.need-row').querySelectorAll('input').forEach(inp => inp.value = '');
      }
    }
  });
</script>
@endpush
@endsection