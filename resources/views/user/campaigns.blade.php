@extends('user.layouts.app')

@section('title', 'Kampanye Bencana')
@section('page_title', 'Kampanye Bencana')

@section('content')
<div class="card border-0 shadow-sm mb-4">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 align-middle">
        <thead class="table-light">
          <tr>
            <th class="ps-3">#</th>
            <th>Kampanye</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th>Target</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($campaigns as $i => $c)
          <tr>
            <td class="ps-3 text-muted small">{{ $i + 1 }}</td>
            <td class="fw-medium">{{ $c->title }}</td>
            <td class="text-muted small">{{ $c->location }}</td>
            <td>
              @if($c->status === 'Darurat')
                <span class="badge bg-danger">Darurat</span>
              @elseif($c->status === 'Waspada')
                <span class="badge bg-warning text-dark">Waspada</span>
              @else
                <span class="badge bg-success">Aktif</span>
              @endif
            </td>
            <td class="text-muted small">Rp {{ number_format($c->target_raw, 0, ',', '.') }}</td>
            <td>
              <a href="{{ route('bencana.detail', $c->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection