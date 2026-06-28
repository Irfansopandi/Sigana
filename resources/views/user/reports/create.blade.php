@extends('user.layouts.app')

@section('title', 'Lapor Bencana')
@section('page_title', 'Lapor Bencana')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <h5 class="fw-bold mb-2">Laporkan kejadian bencana</h5>
        <p class="text-muted small mb-4">Unggah foto kejadian, 3 dokumentasi pendukung, serta deskripsi singkat dan lengkap.</p>

        <form action="{{ route('laporan.bencana.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Judul Laporan</label>
              <input type="text" name="title" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Lokasi Kejadian</label>
              <input type="text" name="location" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <input type="text" name="category" class="form-control" placeholder="Contoh: Banjir" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto Utama</label>
              <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Dokumentasi 1</label>
              <input type="file" name="documentation_1" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="col-md-4">
              <label class="form-label">Dokumentasi 2</label>
              <input type="file" name="documentation_2" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="col-md-4">
              <label class="form-label">Dokumentasi 3</label>
              <input type="file" name="documentation_3" class="form-control" accept=".pdf,image/*">
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi Singkat</label>
              <textarea name="description_short" class="form-control" rows="2" maxlength="500" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Deskripsi Lengkap</label>
              <textarea name="description_long" class="form-control" rows="5" required></textarea>
            </div>
          </div>

          <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Kirim Laporan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
