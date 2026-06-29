@extends('admin.layouts.app')

@section('title', 'Edit Kampanye')
@section('page_title', 'Edit Kampanye')

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
  .doc-item {
    border: 1.5px dashed #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: #f8fafc;
    transition: border-color .2s;
  }
  .doc-item:hover { border-color: #93c5fd; }
  .btn-back { background:#fff; color:#64748b; border:1.5px solid #e2e8f0; border-radius:8px; transition:all .2s; }
  .btn-back:hover { background:#f8fafc; color:#334155; border-color:#cbd5e1; transform:translateY(-1px); }
  .btn-save { background:#eff6ff; color:#2563eb; border:1.5px solid #bfdbfe; border-radius:8px; transition:all .2s; }
  .btn-save:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; transform:translateY(-1px); box-shadow:0 4px 12px rgba(37,99,235,0.15); }
  .btn-cancel-form { background:#fff7ed; color:#c2410c; border:1.5px solid #fed7aa; border-radius:8px; transition:all .2s; }
  .btn-cancel-form:hover { background:#ffedd5; color:#9a3412; border-color:#fdba74; transform:translateY(-1px); }

  #map { height: 220px; border-radius: 10px; border: 1.5px solid #e2e8f0; }
  .coord-input-group { position: relative; }
  .btn-locate {
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    transition: all .2s;
    white-space: nowrap;
  }
  .btn-locate:hover { background:#dbeafe; color:#1d4ed8; border-color:#93c5fd; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
  <div>
    <h5 class="fw-bold mb-1"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Kampanye</h5>
    <p class="text-muted small mb-0">Perbarui informasi kampanye yang sudah dibuat.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-sm btn-back px-4">
      <i class="fa-solid fa-arrow-left me-2"></i>Kembali
    </a>
  </div>
</div>

<form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  {{-- Verifikasi --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-circle-check text-success"></i>Verifikasi Laporan</div>
    <div class="col-md-4">
      <label class="form-label">Status Verifikasi</label>
      <select class="form-select @error('report_status') is-invalid @enderror" name="report_status">
        @foreach(['menunggu','disetujui','ditolak'] as $option)
          <option value="{{ $option }}" {{ old('report_status', $campaign->report_status) === $option ? 'selected' : '' }}>
            {{ ucfirst($option) }}
          </option>
        @endforeach
      </select>
      @error('report_status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
  </div>

  {{-- Informasi Dasar --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-circle-info text-primary"></i>Informasi Dasar</div>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Judul Kampanye</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror"
          name="title" value="{{ old('title', $campaign->title) }}" required>
        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Lokasi</label>
        <input type="text" class="form-control @error('location') is-invalid @enderror"
          name="location" value="{{ old('location', $campaign->location) }}" required>
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Kategori Bencana</label>
        <select class="form-select @error('category') is-invalid @enderror" name="category" required>
          @foreach(['Banjir','Gempa Bumi','Longsor','Kebakaran','Tsunami','Puting Beliung','Lainnya'] as $option)
            <option value="{{ $option }}" {{ old('category', $campaign->category) === $option ? 'selected' : '' }}>{{ $option }}</option>
          @endforeach
        </select>
        @error('category') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Status Kampanye</label>
        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
          @foreach(['Aktif','Darurat','Waspada'] as $option)
            <option value="{{ $option }}" {{ old('status', $campaign->status) === $option ? 'selected' : '' }}>{{ $option }}</option>
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
          name="target_raw" value="{{ old('target_raw', $campaign->getRawOriginal('target_raw')) }}" required>
        @error('target_raw') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Durasi Kampanye (Hari)</label>
        <input type="number" class="form-control @error('days_left') is-invalid @enderror"
          name="days_left" value="{{ old('days_left', $campaign->days_left) }}" min="1" required>
        @error('days_left') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Tanggal Publikasi</label>
        <input type="date" class="form-control @error('date_published') is-invalid @enderror"
          name="date_published" value="{{ old('date_published', $campaign->getRawOriginal('date_published')) }}" required>
        @error('date_published') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>
      <div class="col-md-6">
        <label class="form-label">Jumlah Korban <span class="text-muted">(Opsional)</span></label>
        <input type="number" class="form-control @error('victims') is-invalid @enderror"
          name="victims" value="{{ old('victims', $campaign->victims) }}" min="0">
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
          name="description_short" rows="3" required>{{ old('description_short', $campaign->description_short) }}</textarea>
        @error('description_short') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
      <div class="col-12">
        <label class="form-label">Deskripsi Lengkap</label>
        <textarea class="form-control @error('description_long') is-invalid @enderror"
          name="description_long" rows="6" required>{{ old('description_long', $campaign->description_long) }}</textarea>
        @error('description_long') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
      </div>
    </div>
  </div>

  {{-- Foto --}}
  <div class="form-section">
    <div class="section-title"><i class="fa-solid fa-image text-warning"></i>Foto Kampanye</div>
    <div class="row g-3 align-items-start">
      <div class="col-md-4">
        @php
          $imgPath = $campaign->getRawOriginal('image');
          $imgUrl = $imgPath ? (str_starts_with($imgPath, 'storage/') ? asset($imgPath) : url('storage/' . $imgPath)) : null;
        @endphp
        @if($imgUrl)
          <img src="{{ $imgUrl }}" class="image-preview mb-2" id="imgPreview" alt="Foto saat ini">
        @else
          <div id="imgPreview" class="d-flex align-items-center justify-content-center mb-2"
            style="height:140px;border-radius:8px;border:1.5px dashed #e2e8f0;background:#f8fafc;color:#94a3b8;">
            <i class="fa-solid fa-image fa-2x"></i>
          </div>
        @endif
        <input type="file" class="form-control @error('image') is-invalid @enderror"
          name="image" accept="image/*" id="imageInput">
        <small class="text-muted">JPG, PNG (Maks. 2MB)</small>
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
        <input type="text" class="form-control" id="latitude" name="latitude"
          value="{{ old('latitude', $campaign->latitude) }}" placeholder="-6.200000">
      </div>
      <div class="col-md-5">
        <label class="form-label">Longitude</label>
        <input type="text" class="form-control" id="longitude" name="longitude"
          value="{{ old('longitude', $campaign->longitude) }}" placeholder="106.816666">
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
    <p class="text-muted small mb-3">Unggah hingga 3 file dokumentasi (foto/PDF, maks. 2MB per file). Kosongkan jika tidak ingin mengubah.</p>

    <input type="file" class="form-control @error('documentation') is-invalid @enderror"
      name="documentation[]" accept=".pdf,image/*" multiple id="docInput">
    <small class="text-muted">Format: PDF, JPG, PNG — Maks. 3 file</small>
    @error('documentation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

    {{-- Preview dokumentasi yang sudah ada --}}
    @php $docs = array_filter([$campaign->documentation_1, $campaign->documentation_2, $campaign->documentation_3]); @endphp
    @if(!empty($docs))
    <div class="row g-2 mt-3">
      @foreach($docs as $i => $doc)
      <div class="col-md-4">
        <div class="doc-item">
          <div class="small text-muted mb-2 fw-semibold">Dokumentasi {{ $i + 1 }}</div>
          @php $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION)); @endphp
          @if(in_array($ext, ['jpg','jpeg','png','webp']))
            <img src="{{ url('storage/' . $doc) }}" style="width:100%;height:80px;object-fit:cover;border-radius:6px;" alt="Dok {{ $i+1 }}">
          @else
            <div class="d-flex align-items-center gap-2 py-2">
              <i class="fa-solid fa-file-pdf text-danger fa-lg"></i>
              <span class="small">File PDF</span>
            </div>
          @endif
          <a href="{{ url('storage/' . $doc) }}" target="_blank"
            class="btn btn-sm mt-2 w-100" style="border-radius:6px;border:1.5px solid #e2e8f0;color:#64748b;font-size:0.75rem;">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>Lihat
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>

  {{-- Submit --}}
  <div class="d-flex gap-2 justify-content-end mb-4">
    <a href="{{ route('admin.campaigns.index', $campaign) }}" class="btn btn-cancel-form px-4">
      <i class="fa-solid fa-xmark me-2"></i>Batal
    </a>
    <button type="submit" class="btn btn-save px-4">
      <i class="fa-solid fa-floppy-disk me-2"></i>Perbarui Kampanye
    </button>
  </div>
</form>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  // Preview foto
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

  // Validasi max 3 file dokumentasi
  document.getElementById('docInput').addEventListener('change', function() {
    if (this.files.length > 3) {
      alert('Maksimal 3 file dokumentasi.');
      this.value = '';
    }
  });

  // Peta Leaflet
  const initLat = {{ $campaign->latitude ?? -6.2 }};
  const initLng = {{ $campaign->longitude ?? 106.816 }};

  const map = L.map('map').setView([initLat, initLng], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(map);

  const marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);

  function updateCoords(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
    marker.setLatLng([lat, lng]);
    map.setView([lat, lng], 13);
  }

  map.on('click', function(e) {
    updateCoords(e.latlng.lat, e.latlng.lng);
  });

  marker.on('dragend', function() {
    const pos = marker.getLatLng();
    updateCoords(pos.lat, pos.lng);
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