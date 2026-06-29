@extends('admin.layouts.app')

@section('title', 'Tambah Kampanye')
@section('page_title', 'Tambah Kampanye Bencana')

@push('styles')
<style>
  .form-section {
    background: #fff;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 1px 4px rgba(15,23,42,0.07);
    border: none;
  }
  .section-title {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .07em;
    color: #64748b;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .form-label { font-size: 0.85rem; font-weight: 500; color: #374151; }
  .form-control, .form-select {
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    font-size: 0.9rem;
  }
  .form-control:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
  }
  .image-preview {
    width: 100%; height: 140px;
    object-fit: cover;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
  }
  .image-preview-placeholder {
    height: 140px; border-radius: 8px;
    border: 1.5px dashed #e2e8f0; background: #f8fafc;
    color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
  }
  .btn-back { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; border-radius:8px; transition:all .2s; }
  .btn-back:hover { background:#f8fafc; color:#334155; border-color:#cbd5e1; transform:translateY(-1px); }
  .btn-save { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:8px; transition:all .2s; }
  .btn-save:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; transform:translateY(-1px); box-shadow:0 4px 12px rgba(37,99,235,0.15); }
  .btn-cancel-form { background:#fff7ed; color:#c2410c; border:1.5px solid #fed7aa; border-radius:8px; transition:all .2s; }
  .btn-cancel-form:hover { background:#ffedd5; color:#9a3412; border-color:#fdba74; transform:translateY(-1px); }

  #map { height: 220px; border-radius: 10px; border: 1.5px solid #e2e8f0; }
  .btn-locate {
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    transition: all .2s;
    white-space: nowrap;
  }
  .btn-locate:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; }

  .doc-item {
    border: 1.5px dashed #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: #f8fafc;
    transition: border-color .2s;
  }
  .doc-item:hover { border-color: #93c5fd; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-plus text-success me-2"></i>Tambah Kampanye Bencana</h5>
    <p class="text-muted small mb-0">Buat kampanye penggalangan dana baru untuk mengatasi bencana.</p>
  </div>
  <a href="{{ route('admin.campaigns.index') }}" class="btn btn-sm btn-back px-4">
    <i class="fa-solid fa-arrow-left me-2"></i>Kembali
  </a>
</div>

<form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
  @csrf

  {{-- Informasi Dasar --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-circle-info text-primary"></i>Informasi Dasar</div>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Judul Kampanye</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror"
          name="title" placeholder="Contoh: Banjir Jakarta 2026" value="{{ old('title') }}" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <input type="text" class="form-control @error('location') is-invalid @enderror"
          name="location" placeholder="Contoh: Jakarta, Indonesia" value="{{ old('location') }}" required>
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Kategori Bencana</label>
        <select class="form-select @error('category') is-invalid @enderror" name="category" required>
          <option value="">-- Pilih Kategori --</option>
          @foreach(['Banjir','Gempa Bumi','Longsor','Kebakaran','Tsunami','Puting Beliung','Lainnya'] as $option)
            <option value="{{ $option }}" {{ old('category') === $option ? 'selected' : '' }}>{{ $option }}</option>
          @endforeach
        </select>
        @error('category') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Status Kampanye</label>
        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
          <option value="">-- Pilih Status --</option>
          @foreach(['Aktif','Darurat','Waspada'] as $option)
            <option value="{{ $option }}" {{ old('status') === $option ? 'selected' : '' }}>{{ $option }}</option>
          @endforeach
        </select>
        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  {{-- Target & Durasi --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-bullseye text-danger"></i>Target Donasi & Durasi</div>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Target Donasi (Rp)</label>
        <input type="number" class="form-control @error('target_raw') is-invalid @enderror"
          name="target_raw" placeholder="Contoh: 50000000" value="{{ old('target_raw') }}" step="0.01" required>
        @error('target_raw') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Durasi Kampanye (Hari)</label>
        <input type="number" class="form-control @error('days_left') is-invalid @enderror"
          name="days_left" placeholder="Contoh: 30" value="{{ old('days_left') }}" min="1" required>
        @error('days_left') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Tanggal Publikasi</label>
        <input type="date" class="form-control @error('date_published') is-invalid @enderror"
          name="date_published" value="{{ old('date_published', date('Y-m-d')) }}" required>
        @error('date_published') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-6">
        <label class="form-label">Jumlah Korban <span class="text-muted">(Opsional)</span></label>
        <input type="number" class="form-control @error('victims') is-invalid @enderror"
          name="victims" placeholder="Contoh: 1500" value="{{ old('victims') }}" min="0">
        @error('victims') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  {{-- Deskripsi --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-align-left text-secondary"></i>Deskripsi Kampanye</div>
    <div class="row g-3">
      <div class="col-12">
        <label class="form-label">Deskripsi Singkat</label>
        <textarea class="form-control @error('description_short') is-invalid @enderror"
          name="description_short" rows="3" placeholder="Ringkas situasi bencana dalam 1-2 paragraf" required>{{ old('description_short') }}</textarea>
        <small class="text-muted">Maks 500 karakter</small>
        @error('description_short') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi Lengkap</label>
        <textarea class="form-control @error('description_long') is-invalid @enderror"
          name="description_long" rows="6" placeholder="Ceritakan detail lengkap tentang bencana dan kebutuhan bantuan" required>{{ old('description_long') }}</textarea>
        @error('description_long') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  {{-- Foto --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-image text-warning"></i>Foto Kampanye</div>
    <div class="row g-3 align-items-start">
      <div class="col-md-4">
        <div id="imgPreview" class="image-preview-placeholder mb-2">
          <i class="fa-solid fa-image fa-2x"></i>
        </div>
        <input type="file" class="form-control @error('image') is-invalid @enderror"
          name="image" accept="image/*" id="imageInput">
        <small class="text-muted">JPG, PNG, GIF (Maks. 2MB)</small>
        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  {{-- Koordinat --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-location-dot text-danger"></i>Koordinat Lokasi</div>
    <div class="row g-3 mb-3">
      <div class="col-md-5">
        <label class="form-label">Latitude</label>
        <input type="text" class="form-control @error('latitude') is-invalid @enderror"
          id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="-6.200000">
        @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-5">
        <label class="form-label">Longitude</label>
        <input type="text" class="form-control @error('longitude') is-invalid @enderror"
          id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="106.816666">
        @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-locate w-100" id="btnLocate">
          <i class="fa-solid fa-crosshairs me-1"></i>Deteksi
        </button>
      </div>
    </div>
    <div id="map"></div>
    <small class="text-muted mt-2 d-block"><i class="fa-solid fa-info-circle me-1"></i>Klik pada peta untuk memilih koordinat, atau klik Deteksi untuk lokasi saat ini.</small>
  </div>

  {{-- Dokumentasi --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-paperclip text-info"></i>Dokumentasi Pendukung</div>
    <p class="text-muted small mb-3">Unggah hingga 3 file dokumentasi (foto/PDF, maks. 2MB per file).</p>

    <input type="file" class="form-control @error('documentation') is-invalid @enderror"
      name="documentation[]" accept=".pdf,image/*" multiple id="docInput">
    <small class="text-muted">Format: PDF, JPG, PNG — Maks. 3 file</small>
    @error('documentation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

    <div class="row g-2 mt-3" id="docPreviewRow"></div>
  </div>

  {{-- Submit --}}
  <div class="d-flex gap-2 justify-content-end mb-4">
    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-cancel-form px-4">
      <i class="fa-solid fa-xmark me-2"></i>Batal
    </a>
    <button type="submit" class="btn btn-save px-4">
      <i class="fa-solid fa-check me-2"></i>Simpan Kampanye
    </button>
  </div>
</form>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  // Preview foto utama
  document.getElementById('imageInput').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        const preview = document.getElementById('imgPreview');
        preview.outerHTML = `<img src="${ev.target.result}" class="image-preview mb-2" id="imgPreview" alt="Preview">`;
      };
      reader.readAsDataURL(e.target.files[0]);
    }
  });

  // Preview & validasi max 3 file dokumentasi
  document.getElementById('docInput').addEventListener('change', function() {
    const row = document.getElementById('docPreviewRow');
    row.innerHTML = '';

    if (this.files.length > 3) {
      alert('Maksimal 3 file dokumentasi.');
      this.value = '';
      return;
    }

    Array.from(this.files).forEach((file, i) => {
      const col = document.createElement('div');
      col.className = 'col-md-4';

      if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          col.innerHTML = `
            <div class="doc-item">
              <div class="small text-muted mb-2 fw-semibold">Dokumentasi ${i + 1}</div>
              <img src="${ev.target.result}" style="width:100%;height:80px;object-fit:cover;border-radius:6px;" alt="Dok ${i+1}">
            </div>`;
        };
        reader.readAsDataURL(file);
      } else {
        col.innerHTML = `
          <div class="doc-item">
            <div class="small text-muted mb-2 fw-semibold">Dokumentasi ${i + 1}</div>
            <div class="d-flex align-items-center gap-2 py-2">
              <i class="fa-solid fa-file-pdf text-danger fa-lg"></i>
              <span class="small">${file.name}</span>
            </div>
          </div>`;
      }
      row.appendChild(col);
    });
  });

  // Peta Leaflet (default fokus Indonesia)
  const initLat = {{ old('latitude', -2.5) }};
  const initLng = {{ old('longitude', 118.0) }};
  const initZoom = {{ old('latitude') ? 13 : 5 }};

  const map = L.map('map').setView([initLat, initLng], initZoom);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(map);

  let marker = null;
  @if(old('latitude') && old('longitude'))
    marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
    bindMarkerDrag();
  @endif

  function updateCoords(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);

    if (!marker) {
      marker = L.marker([lat, lng], { draggable: true }).addTo(map);
      bindMarkerDrag();
    } else {
      marker.setLatLng([lat, lng]);
    }
    map.setView([lat, lng], 13);
  }

  function bindMarkerDrag() {
    marker.on('dragend', function() {
      const pos = marker.getLatLng();
      updateCoords(pos.lat, pos.lng);
    });
  }

  map.on('click', function(e) {
    updateCoords(e.latlng.lat, e.latlng.lng);
  });

  document.getElementById('btnLocate').addEventListener('click', function() {
    if (navigator.geolocation) {
      this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Mendeteksi...';
      const btn = this;
      navigator.geolocation.getCurrentPosition(function(pos) {
        updateCoords(pos.coords.latitude, pos.coords.longitude);
        btn.innerHTML = '<i class="fa-solid fa-crosshairs me-1"></i>Deteksi';
      }, function() {
        alert('Gagal mendeteksi lokasi.');
        btn.innerHTML = '<i class="fa-solid fa-crosshairs me-1"></i>Deteksi';
      });
    }
  });

  // Sync input manual ke peta
  ['latitude', 'longitude'].forEach(id => {
    document.getElementById(id).addEventListener('change', function() {
      const lat = parseFloat(document.getElementById('latitude').value);
      const lng = parseFloat(document.getElementById('longitude').value);
      if (!isNaN(lat) && !isNaN(lng)) updateCoords(lat, lng);
    });
  });
</script>
@endpush