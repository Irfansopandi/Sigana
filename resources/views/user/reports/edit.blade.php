@extends('user.layouts.app')

@section('title', 'Edit Laporan Bencana')
@section('page_title', 'Edit Laporan Bencana')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
  #map { height: 220px; border-radius: 10px; border: 1.5px solid #e2e8f0; margin-top: 10px; }
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
    display: inline-flex; align-items: center; gap: 6px;
    background: #e0f2fe; color: #0369a1;
    font-size: .75rem; font-weight: 600;
    padding: 4px 10px; border-radius: 999px; margin: 4px 4px 0 0;
  }
  .file-preview-empty { font-size: .78rem; color: #94a3b8; margin-top: 6px; }
  .current-thumb {
    width: 56px; height: 56px; object-fit: cover;
    border-radius: 8px; margin-top: 6px;
  }
  .btn-kirim {
    background: var(--cyan, #38bdf8); border: none; color: #fff;
    font-weight: 600; transition: all .2s;
  }
  .btn-kirim:hover { background: #0ea5e9; color: #fff; }
  #btnGetLocation {
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    transition: all .2s;
  }
  #btnGetLocation:hover { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }

  .doc-slot-item {
    border: 1.5px dashed #e2e8f0;
    border-radius: 10px;
    padding: 12px;
    background: #f8fafc;
    transition: border-color .2s;
  }
  .doc-slot-item:hover { border-color: #93c5fd; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">

        <div class="d-flex align-items-center gap-2 mb-1">
          <i class="fa-solid fa-pen-to-square text-warning"></i>
          <h5 class="fw-bold mb-0">Edit laporan kejadian bencana</h5>
        </div>
        <p class="text-muted small mb-4">Perbarui data laporan kamu. Laporan akan diverifikasi ulang oleh admin setelah disimpan.</p>

        <form action="{{ route('user.lapor-bencana.update', $campaign->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- ── INFO LAPORAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-circle-info"></i> Info Laporan</div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Judul Laporan</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $campaign->title) }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Lokasi Kejadian</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $campaign->location) }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Kategori</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $campaign->category) }}" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Korban Terdampak <span class="text-muted">(orang)</span></label>
                <input type="number" name="victims" class="form-control" value="{{ old('victims', $campaign->victims) }}" min="0" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Foto Utama</label>
                <input type="file" name="image" id="imageInput" class="form-control" accept="image/*">
                <div id="imagePreview" class="file-preview-empty">
                  @if($campaign->image)
                    Foto saat ini:
                    <img src="{{ asset('storage/'.$campaign->image) }}" class="current-thumb d-block">
                  @else
                    Belum ada foto
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- ── LOKASI & KOORDINAT ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-location-dot"></i> Koordinat Lokasi</div>
            <div class="row g-3 align-items-end">
              <div class="col-md-5">
                <label class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $campaign->latitude) }}" required>
              </div>
              <div class="col-md-5">
                <label class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $campaign->longitude) }}" required>
              </div>
              <div class="col-md-2">
                <button type="button" class="w-100" id="btnGetLocation">
                  <i class="fa-solid fa-location-crosshairs me-1"></i>Deteksi
                </button>
              </div>
            </div>
            <div id="map"></div>
            <small class="text-muted mt-2 d-block"><i class="fa-solid fa-info-circle me-1"></i>Klik pada peta untuk memilih koordinat secara manual.</small>
          </div>

          {{-- ── KEBUTUHAN LOGISTIK ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-truck"></i> Kebutuhan Logistik Mendesak</div>
            <p class="text-muted small mb-3">Tambahkan barang/bantuan yang dibutuhkan di lokasi beserta target jumlahnya (opsional).</p>

            <div id="needsWrapper">
              @php $oldNeeds = old('needs', $campaign->needs->map(fn($n) => ['name' => $n->name, 'qty' => $n->qty])->toArray()); @endphp
              @forelse($oldNeeds as $i => $need)
                <div class="row g-2 mb-2 need-row">
                  <div class="col-md-6">
                    <input type="text" class="form-control" name="needs[{{ $i }}][name]" placeholder="Contoh: Truk Tangki Air Bersih" value="{{ $need['name'] ?? '' }}">
                  </div>
                  <div class="col-md-5">
                    <input type="text" class="form-control" name="needs[{{ $i }}][qty]" placeholder="Contoh: 100 Tangki" value="{{ $need['qty'] ?? '' }}">
                  </div>
                  <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 btn-remove-need"><i class="fa-solid fa-trash"></i></button>
                  </div>
                </div>
              @empty
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
              @endforelse
            </div>

            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btnAddNeed">
              <i class="fa-solid fa-plus me-1"></i>Tambah Kebutuhan
            </button>
          </div>

          {{-- ── LAMPIRAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-paperclip"></i> Dokumentasi Pendukung</div>
            <p class="text-muted small mb-3">Setiap slot bisa diganti atau dihapus secara terpisah (foto/PDF, maks. 2MB).</p>

            <div class="row g-3">
              @for ($i = 1; $i <= 3; $i++)
                @php
                  $doc = $campaign->{'documentation_' . $i};
                  $ext = $doc ? strtolower(pathinfo($doc, PATHINFO_EXTENSION)) : null;
                @endphp
                <div class="col-md-4">
                  <div class="doc-slot-item">
                    <div class="small text-muted mb-2 fw-semibold">Dokumentasi {{ $i }}</div>

                    <div id="docPreview{{ $i }}">
                      @if($doc)
                        @if(in_array($ext, ['jpg','jpeg','png','webp']))
                          <img src="{{ asset('storage/' . $doc) }}" style="width:100%;height:80px;object-fit:cover;border-radius:6px;" alt="Dok {{ $i }}">
                        @else
                          <div class="d-flex align-items-center gap-2 py-2">
                            <i class="fa-solid fa-file-pdf text-danger fa-lg"></i>
                            <span class="small">File PDF</span>
                          </div>
                        @endif
                      @else
                        <div class="text-muted small py-3 text-center border rounded">Belum ada file</div>
                      @endif
                    </div>

                    <input type="hidden" name="delete_documentation_{{ $i }}" id="deleteFlag{{ $i }}" value="0">

                    <div class="d-flex gap-2 mt-2">
                      <input type="file" class="form-control form-control-sm doc-single-input"
                        data-slot="{{ $i }}" name="documentation_slot_{{ $i }}" accept=".pdf,image/*">
                      @if($doc)
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-doc" data-slot="{{ $i }}" title="Hapus file ini">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      @endif
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
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="description_short" class="form-control" rows="2" maxlength="500" required>{{ old('description_short', $campaign->description_short) }}</textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="description_long" class="form-control" rows="5" required>{{ old('description_long', $campaign->description_long) }}</textarea>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('user.lapor-bencana') }}" class="btn btn-outline-secondary">
              <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-kirim px-4">
              <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
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
  document.getElementById('imageInput').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('imagePreview').innerHTML =
        `<span class="file-pill"><i class="fa-solid fa-image"></i> ${this.files[0].name}</span>`;
    }
  });


  document.getElementById('btnGetLocation').addEventListener('click', function() {
    if (!navigator.geolocation) {
      Swal.fire('Gagal', 'Browser tidak mendukung fitur geolocation.', 'error');
      return;
    }
    navigator.geolocation.getCurrentPosition(function(pos) {
      updateCoords(pos.coords.latitude, pos.coords.longitude);
      Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Lokasi berhasil diambil', showConfirmButton: false, timer: 2000 });
    }, function() {
      Swal.fire('Gagal', 'Tidak bisa mengambil lokasi. Izinkan akses lokasi pada browser kamu.', 'error');
    });
  });

  // Peta Leaflet
  const initLat = {{ old('latitude', $campaign->latitude ?? -2.5) }};
  const initLng = {{ old('longitude', $campaign->longitude ?? 118.0) }};
  const initZoom = {{ $campaign->latitude ? 13 : 5 }};

  const map = L.map('map').setView([initLat, initLng], initZoom);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  }).addTo(map);

  let marker = L.marker([initLat, initLng], { draggable: true }).addTo(map);
  marker.on('dragend', function() {
    const pos = marker.getLatLng();
    updateCoords(pos.lat, pos.lng);
  });

  function updateCoords(lat, lng) {
    document.getElementById('latitude').value = lat.toFixed(7);
    document.getElementById('longitude').value = lng.toFixed(7);
    marker.setLatLng([lat, lng]);
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

  // Preview & hapus dokumentasi per slot
document.querySelectorAll('.doc-single-input').forEach(input => {
  input.addEventListener('change', function() {
    const slot = this.dataset.slot;
    document.getElementById('deleteFlag' + slot).value = '0';

    if (this.files && this.files[0]) {
      const file = this.files[0];
      const preview = document.getElementById('docPreview' + slot);

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
    }
  });
});

document.querySelectorAll('.btn-delete-doc').forEach(btn => {
  btn.addEventListener('click', function() {
    const thisBtn = this;
    Swal.fire({
      title: 'Hapus file dokumentasi ini?',
      text: 'File yang dihapus tidak dapat dikembalikan.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc2626',
      cancelButtonColor: '#64748b',
      confirmButtonText: 'Ya, hapus',
      cancelButtonText: 'Batal'
    }).then(function(result) {
      if (!result.isConfirmed) return;

      const slot = thisBtn.dataset.slot;
      document.getElementById('deleteFlag' + slot).value = '1';
      document.querySelector(`input[name="documentation_slot_${slot}"]`).value = '';
      document.getElementById('docPreview' + slot).innerHTML =
        '<div class="text-muted small py-3 text-center border rounded text-danger">Akan dihapus</div>';
      thisBtn.remove();

      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'File berhasil dihapus',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true
      });
    });
  });
});
</script>
@endpush
@endsection