@extends('user.layouts.app')

@section('title', 'Transparansi Dana')
@section('page_title', 'Transparansi Dana')

@section('content')
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Laporan</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $i => $r)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $r->title }}</td>
            <td class="text-muted small">{{ $r->created_at->translatedFormat('d M Y') }}</td>
            <td>
              <a href="{{ route('transparansi.detail', $r->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center py-4 text-muted">Belum ada laporan transparansi.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection