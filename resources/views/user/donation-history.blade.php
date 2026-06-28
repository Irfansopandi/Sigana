@extends('user.layouts.app')

@section('title', 'Riwayat Donasi')
@section('page_title', 'Riwayat Donasi Saya')

@section('content')
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Kampanye</th>
            <th>Jumlah Donasi</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse($donations as $i => $d)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $d->campaign_title }}</td>
            <td class="text-muted small">Rp {{ number_format($d->amount, 0, ',', '.') }}</td>
            <td>
              @if($d->status === 'success')
                <span class="badge bg-success">Berhasil</span>
              @elseif($d->status === 'pending')
                <span class="badge bg-warning text-dark">Menunggu</span>
              @else
                <span class="badge bg-danger">Gagal</span>
              @endif
            </td>
            <td class="text-muted small">{{ $d->created_at->translatedFormat('d M Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat donasi.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection