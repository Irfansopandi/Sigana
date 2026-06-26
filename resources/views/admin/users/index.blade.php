@extends('admin.layouts.app')

@section('title', 'Kelola Pengguna')
@section('page_title', 'Pengguna')

@section('content')
<div class="mb-4">
  <h5 class="fw-bold mb-1"><i class="fa-solid fa-users text-primary me-2"></i>Kelola Pengguna</h5>
  <p class="text-muted small mb-0">Lihat, cari, dan atur semua pengguna terdaftar.</p>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body p-3">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Terdaftar</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $user)
            <tr>
              <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td>{{ $user->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="text-center text-muted">Belum ada pengguna tersedia.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
