@extends('user.layouts.app')

@section('title', 'Edit Laporan Bencana')
@section('page_title', 'Edit Laporan Bencana')

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
                <button type="button" class="btn btn-outline-primary w-100" id="btnGetLocation">
                  <i class="fa-solid fa-location-crosshairs"></i>
                </button>
              </div>
            </div>
          </div>

          {{-- ── LAMPIRAN ── --}}
          <div class="form-section">
            <div class="form-section-title"><i class="fa-solid fa-paperclip"></i> Dokumentasi Pendukung</div>
            <label class="form-label">Unggah file baru <span class="text-muted">(opsional — kosongkan jika tidak ingin mengubah, maks. 3 file)</span></label>
            <input type="file" name="documentation[]" id="documentation" class="form-control" accept=".pdf,image/*" multiple>
            <div id="docPreview" class="file-preview-empty">
              @php $existingDocs = array_filter([$campaign->documentation_1, $campaign->documentation_2, $campaign->documentation_3]); @endphp
              @if(count($existingDocs))
                {{ count($existingDocs) }} file dokumentasi sudah tersimpan sebelumnya.
              @else
                Belum ada file dokumentasi
              @endif
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
<script>
  document.getElementById('imageInput').addEventListener('change', function() {
    if (this.files.length > 0) {
      document.getElementById('imagePreview').innerHTML =
        `<span class="file-pill"><i class="fa-solid fa-image"></i> ${this.files[0].name}</span>`;
    }
  });

  document.getElementById('documentation').addEventListener('change', function() {
    if (this.files.length > 3) {
      Swal.fire({ icon: 'warning', title: 'Maksimal 3 file', text: 'Kamu hanya bisa upload maksimal 3 dokumentasi sekaligus.' });
      this.value = '';
      return;
    }
    if (this.files.length > 0) {
      let pills = '';
      Array.from(this.files).forEach(file => {
        const isPdf = file.name.toLowerCase().endsWith('.pdf');
        pills += `<span class="file-pill"><i class="fa-solid ${isPdf ? 'fa-file-pdf' : 'fa-image'}"></i> ${file.name}</span>`;
      });
      document.getElementById('docPreview').innerHTML = pills;
    }
  });

  document.getElementById('btnGetLocation').addEventListener('click', function() {
    if (!navigator.geolocation) {
      Swal.fire('Gagal', 'Browser tidak mendukung fitur geolocation.', 'error');
      return;
    }
    navigator.geolocation.getCurrentPosition(function(pos) {
      document.getElementById('latitude').value = pos.coords.latitude;
      document.getElementById('longitude').value = pos.coords.longitude;
      Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Lokasi berhasil diambil', showConfirmButton: false, timer: 2000 });
    }, function() {
      Swal.fire('Gagal', 'Tidak bisa mengambil lokasi. Izinkan akses lokasi pada browser kamu.', 'error');
    });
  });
</script>
@endpush
@endsection