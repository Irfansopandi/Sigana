<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin') — SIGANA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  {{-- icon boostrap --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Favicon -->
  <link rel="icon" type="image/jpeg" href="{{ asset('storage/assets/logo/logo-bulat.webp') }}">
 <style>
    :root {
      --navy-900: #0a2540;
      --navy-800: #0d2f52;
      --navy-700: #173f66;
      --navy-600: #1e4f7e;
      --cyan:     #38bdf8;
      --sidebar-w: 260px;
    }

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #f1f5f9;
      display: flex;
      min-height: 100vh;
    }

    /* ── SIDEBAR ── */
    .sidebar {
      width: var(--sidebar-w);
      height: 100vh;
      background: linear-gradient(180deg, var(--navy-900) 0%, var(--navy-800) 100%);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0;
      z-index: 100;
      overflow: hidden;
      transition: transform .3s ease;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 20px 16px;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      text-decoration: none;
    }

    .sidebar-brand img {
      width: 40px; height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid rgba(255,255,255,0.2);
    }

    .sidebar-brand-text {
      line-height: 1.1;
    }

    .sidebar-brand-text span.si  { color: var(--cyan); font-weight: 700; font-size: 1.1rem; }
    .sidebar-brand-text span.ga  { color: #f87171;     font-weight: 700; font-size: 1.1rem; }
    .sidebar-brand-text small    { color: rgba(255,255,255,0.45); font-size: 0.7rem; display: block; }

    .sidebar-nav { 
      flex: 1; 
      padding: 12px 0; 
      overflow-y: auto;
      min-height: 0;
      scrollbar-width: none;
      -ms-overflow-style: none;

    }

    .sidebar-nav::-webkit-scrollbar {
      display: none;
    }

    .nav-label {
      color: rgba(255,255,255,0.3);
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: .08em;
      text-transform: uppercase;
      padding: 14px 20px 4px;
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 20px;
      color: rgba(255,255,255,0.65);
      font-size: 0.875rem;
      border-radius: 0;
      transition: all .2s;
      text-decoration: none;
    }

    .sidebar-nav .nav-link i { width: 18px; text-align: center; font-size: .9rem; }

    .sidebar-nav .nav-link:hover,
    .sidebar-nav .nav-link.active {
      color: #fff;
      background: rgba(255,255,255,0.08);
      border-left: 3px solid var(--cyan);
      padding-left: 17px;
    }

    .sidebar-footer {
      padding: 14px 20px;
      border-top: 1px solid rgba(255,255,255,0.08);
      margin-bottom: 0;
      flex-shrink: 0;
    }

    .sidebar-user {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .sidebar-user-avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: var(--navy-600);
      display: flex; align-items: center; justify-content: center;
      color: var(--cyan);
      font-size: .85rem;
      font-weight: 600;
      flex-shrink: 0;
    }

    .sidebar-user-info { flex: 1; min-width: 0; }
    .sidebar-user-info .name  { color: #fff; font-size: .8rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .sidebar-user-info .role  { color: rgba(255,255,255,0.4); font-size: .68rem; }

    .sidebar.collapsed {
        width: 70px;
        overflow: hidden;
    }

    .sidebar.collapsed .sidebar-brand-text,
    .sidebar.collapsed .nav-label,
    .sidebar.collapsed .nav-link span,
    .sidebar.collapsed .nav-link-text,
    .sidebar.collapsed .sidebar-user-info,
    .sidebar.collapsed .sidebar-user .role,
    .sidebar.collapsed .sidebar-user .name {
        display: none !important;
    }

    .sidebar.collapsed .nav-link {
        justify-content: center;
        padding-left: 0;
        padding-right: 0;
        border-left: none !important;
    }

    .sidebar.collapsed .nav-link i {
        width: auto;
        font-size: 1.1rem;
    }

    .sidebar.collapsed .sidebar-brand img {
        margin: 0 auto;
    }

    .sidebar.collapsed ~ .main-wrapper {
        margin-left: 70px;
    }

    .sidebar, .main-wrapper {
        transition: all .3s ease;
    }
    .sidebar.collapsed .sidebar-nav .nav-link {
      justify-content: center;
      padding: 12px 0 !important;
      border-left: none !important;
      margin: 2px 8px;
      border-radius: 8px;
    }

    .sidebar.collapsed .sidebar-nav .nav-link:hover,
    .sidebar.collapsed .sidebar-nav .nav-link.active {
        background: rgba(255,255,255,0.08);
        border-left: 3px solid var(--cyan) !important;
        border-radius: 0;
        margin: 2px 0;
    }

    .sidebar.collapsed .sidebar-nav .nav-link i {
        width: auto;
        margin: 0;
        font-size: 1.2rem;
    }

    .sidebar.collapsed .sidebar-footer {
        padding: 14px 0;
        display: flex;
        justify-content: center;
        margin-bottom: 16px;
    }

    .sidebar.collapsed .sidebar-footer .sidebar-user {
        justify-content: center;
        flex-direction: column;
        gap: 8px;
    }

    .sidebar.collapsed .sidebar-footer form {
      display: block !important;
    }

    .sidebar.collapsed .sidebar-user-avatar {
        margin: 0 auto;
    }
    .sidebar.collapsed .sidebar-footer .btn-logout {
      display: flex;
      justify-content: center;
      width: 100%;
      color: rgba(255,255,255,0.4);
      font-size: 1rem;
      padding: 4px;
    }

    .sidebar.collapsed .sidebar-footer .btn-logout:hover {
        color: #f87171;
        background: rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 4px 8px;
    }

    .btn-logout {
        background: none; border: none; padding: 4px 6px;
        color: rgba(255,255,255,0.4);
        font-size: .85rem; cursor: pointer;
        transition: color .2s;
    }
    .btn-logout:hover { color: #f87171; }

    /* ── MAIN ── */
    .main-wrapper {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ── TOPBAR ── */
    .topbar {
      height: 60px !important;
      background: #fff;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 24px;
      position: fixed; 
      top: 0; 
      left: var(--sidebar-w);
      right: 0;
      z-index: 50;
    }

    .sidebar.collapsed ~ .main-wrapper .topbar {
      left: 70px;
    }

      /* ── CONTENT ── */
    .main-content { 
        padding: 24px; 
        flex: 1; 
        padding-top: 84px;
    }

    .topbar-title { font-weight: 600; color: var(--navy-900); font-size: .95rem; }

    .topbar-right { display: flex; align-items: center; gap: 14px; }

    .topbar-badge {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: var(--navy-900);
      color: #fff;
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem; font-weight: 600;
    }


    /* ── RESPONSIVE ── */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.show { transform: translateX(0); }
      .main-wrapper { margin-left: 0; }
    }
    #notifBtn {
      background: none;
      border: none;
    }
    #notifIcon {
      display: inline-block;
      transition: transform 0.2s;
    }
    #notifBtn:hover #notifIcon {
      transform: rotate(15deg);
    }
    #relawanNotifDropdown {
      border-radius: 14px;
      box-shadow: 0 8px 30px rgba(0,0,0,.12);
      overflow: hidden;
    }
    #notifList::-webkit-scrollbar {
      width: 6px;
    }
    #notifList::-webkit-scrollbar-track {
      background: transparent;
    }
    #notifList::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 3px;
    }
    #notifList::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
  </style>
  @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom border-white border-opacity-10">
        <a href="{{ route('user.dashboard') }}" class="sidebar-brand text-decoration-none p-0 border-0">
            <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA">
            <div class="sidebar-brand-text">
                <div><span class="si">SI</span><span class="ga">GANA</span></div>
                <small>Relawan</small>
            </div>
        </a>
    </div>
        
    <nav class="sidebar-nav">
        <div class="nav-label">Utama</div>
        <a href="{{ route('relawan.dashboard') }}" class="nav-link {{ request()->routeIs('relawan.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge"></i> <span>Dashboard</span>
        </a> 

        <div class="nav-label">Tugas</div>
        <a href="{{ route('relawan.bencana') }}" class="nav-link {{ request()->routeIs('relawan.bencana') ? 'active' : '' }}">
            <i class="fa-solid fa-map-location-dot"></i> <span> Bencana</span>
        </a>
        <a href="{{ route('relawan.bencana-diikuti') }}" class="nav-link {{ request()->routeIs('relawan.bencana-diikuti') || request()->routeIs('relawan.bencana-diikuti.selesai') ? 'active' : '' }}">
            <i class="fa-solid fa-clipboard-list"></i> <span>Bencana Diikuti</span>
        </a>
        <a href="{{ route('relawan.transparansi') }}" class="nav-link">
            <i class="fa-solid fa-chart-line"></i> <span>Laporan Transparansi</span>
        </a>

        @php
          $isCoordinator = \App\Models\CampaignVolunteer::where('user_id', auth()->id())
            ->where('is_coordinator', true)
            ->where('verifikasi', 'diterima')
            ->exists();
        @endphp
        @if($isCoordinator)
          <div class="nav-label">Koordinator</div>
          <a href="{{ route('relawan.coordinator-reports.index') }}" class="nav-link {{ request()->routeIs('relawan.coordinator-reports.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines"></i> <span> Laporan Bencana</span>
          </a>
        @endif


        <div class="nav-label">Akun</div>
        <a href="{{ route('relawan.profile') }}" class="nav-link {{ request()->routeIs('relawan.profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i> <span> Profil Saya</span>
        </a>
            
        <div class="nav-label">Lainnya</div>
        <a href="{{ route('home') }}" class="nav-link">
            <i class="fa-solid fa-globe"></i><span> Lihat Situs</span>
        </a>
    </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-user-avatar" id="sidebarUserAvatar">
          @if(auth()->user()->photo)
              <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto"
                  style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
          @else
              {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          @endif
      </div>
      <div class="sidebar-user-info">
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="role">Relawan</div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout" title="Logout">
          <i class="fa-solid fa-right-from-bracket"></i>
        </button>
      </form>
    </div>
  </div>
</aside>

{{-- MAIN --}}
<div class="main-wrapper">
    <header class="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm" id="sidebarToggle" title="Toggle Sidebar">
            <i class="fa-solid fa-bars fa-lg text-muted"></i>
            </button>
            <span class="topbar-title">@yield('page_title', 'Dashboard')</span>
        </div>
        <div class="topbar-right d-flex align-items-center gap-2" style="position:relative;">

          {{-- Bell Notifikasi --}}
          <div class="position-relative" id="notifWrapper">
            <button id="notifBtn" class="btn p-0 position-relative" style="width:36px;height:36px;background:none;border:none;" title="Notifikasi">
              <i class="fa-solid fa-bell text-muted fs-5" id="notifIcon"></i>
              <span id="notifBadge" class="position-absolute badge rounded-pill bg-danger d-none"
                    style="font-size:.6rem;top:-4px;right:-6px;"></span>
            </button>

            {{-- Dropdown --}}
            <div id="notifDropdown" class="card shadow border-0 position-absolute d-none"
                style="width:320px;z-index:999;right:0;top:100%;border-radius:14px !important;overflow:hidden;">
              <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                <span class="fw-semibold small">Notifikasi</span>
                <a href="{{ route('relawan.notifications') }}" 
                  class="btn btn-sm btn-outline-secondary rounded-pill px-3 text-decoration-none" 
                  style="font-size:.75rem;"
                  onclick="localStorage.setItem('relawan_notif_seen_at', Date.now()); document.getElementById('notifBadge').classList.add('d-none'); document.getElementById('notifList').innerHTML = ''; document.getElementById('notifEmpty').classList.remove('d-none');">
                  Lihat Semua
                </a>
              </div>
              <div id="notifEmpty" class="text-center text-muted small py-4">
                <i class="fa-solid fa-bell-slash mb-2 d-block opacity-40"></i>
                Tidak ada notifikasi baru
              </div>
              <div id="notifList" style="max-height: 320px; overflow-y: auto;"></div>
            </div>
          </div>

          <span class="text-muted small">{{ now()->translatedFormat('l, d F Y') }}</span>

          <div class="topbar-badge" id="topbarUserAvatar">
            @if(auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Foto"
                    style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif
        </div>
      </div>
    </header>

  <main class="main-content">
    @if(is_null(auth()->user()->email_verified_at))
      <div class="alert border-0 mb-4 d-flex align-items-start gap-3"
          style="background:#fffbeb;border-left:4px solid #f59e0b !important;border-radius:10px;">
        <i class="fa-solid fa-clock-rotate-left mt-1" style="color:#f59e0b;font-size:1.1rem;"></i>
        <div>
          <div class="fw-bold" style="color:#92400e;">Akun Sedang Diverifikasi</div>
          <div class="small text-muted">Akun relawan Anda sedang ditinjau admin (1–3 hari kerja). Fitur akan aktif setelah verifikasi selesai.</div>
        </div>
      </div>
      <div style="position:relative;">
        <div style="position:absolute;inset:0;background:rgba(255,255,255,0.75);
                    backdrop-filter:blur(4px);z-index:10;border-radius:12px;
                    display:flex;align-items:center;justify-content:center;">
          <div class="text-center">
            <i class="fa-solid fa-lock fa-2x mb-2" style="color:#d1d5db;"></i>
            <div class="text-muted small fw-semibold">Tersedia setelah verifikasi</div>
          </div>
        </div>
      @endif
    @yield('content')
    @if(is_null(auth()->user()->email_verified_at))
    </div>
    @endif
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- ── Relawan Notification System ── --}}
<script>
const notifBtn = document.getElementById('notifBtn');
const notifDropdown = document.getElementById('notifDropdown');
const notifBadge = document.getElementById('notifBadge');
const notifList = document.getElementById('notifList');
const notifEmpty = document.getElementById('notifEmpty');

const icons = {
    campaign_approved: '<i class="fa-solid fa-circle-check text-success"></i>',
    campaign_rejected: '<i class="fa-solid fa-circle-xmark text-danger"></i>',
    donation_success:  '<i class="fa-solid fa-heart text-pink" style="color:#ec4899"></i>',
    transparency_update: '<i class="fa-solid fa-file-lines text-primary"></i>',
    new_campaign:      '<i class="fa-solid fa-hand-holding-heart text-warning"></i>',
    volunteer_approved: '<i class="fa-solid fa-circle-check text-success"></i>',
    volunteer_rejected: '<i class="fa-solid fa-circle-xmark text-danger"></i>',
    account_verified:  '<i class="fa-solid fa-circle-check text-success"></i>',
    account_pending:   '<i class="fa-solid fa-clock text-warning"></i>',
    join_accepted:     '<i class="fa-solid fa-handshake text-info"></i>',
    join_rejected:     '<i class="fa-solid fa-circle-xmark text-danger"></i>',
    join_pending:      '<i class="fa-solid fa-hourglass-half text-secondary"></i>',
    coordinator_appointed: '<i class="fa-solid fa-crown text-warning"></i>',
};

function loadNotif() {
    fetch('{{ route("relawan.notifications.unread") }}')
        .then(r => r.json())
        .then(data => {
            const lastSeen = parseInt(localStorage.getItem('relawan_notif_seen_at') || '0');
            const unseenNotifs = data.notifications.filter(n => {
                return new Date(n.time).getTime() > lastSeen;
            });

            if (unseenNotifs.length > 0) {
                notifBadge.classList.remove('d-none');
                notifBadge.textContent = unseenNotifs.length > 9 ? '9+' : unseenNotifs.length;
                notifEmpty.classList.add('d-none');
                notifList.innerHTML = unseenNotifs.map(n => `
                    <a href="${n.url ?? '#'}" class="d-flex gap-3 px-3 py-2 text-decoration-none border-bottom notif-item bg-light"
                        data-id="${n.id}">
                        <div class="mt-1">${icons[n.type] ?? '<i class="fa-solid fa-bell text-muted"></i>'}</div>
                        <div>
                            <div class="small fw-semibold text-dark">${n.title}</div>
                            <div class="small text-muted">${n.message}</div>
                        </div>
                    </a>
                `).join('');
            } else {
                notifBadge.classList.add('d-none');
                notifEmpty.classList.remove('d-none');
                notifList.innerHTML = '';
            }
        });
}

notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    notifDropdown.classList.toggle('d-none');
    loadNotif();
});

document.addEventListener('click', () => notifDropdown.classList.add('d-none'));
notifDropdown.addEventListener('click', e => e.stopPropagation());

loadNotif();
setInterval(loadNotif, 30000);
</script>

@stack('scripts')
{{-- SweetAlert login sucess --}}
@if(session('login_success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Selamat datang kembali!',
        html: '<span style="font-size: 0.95rem; display: block; margin-top: -10px; font-weight: 600;">Relawan {{ auth()->user()->name }}</span>',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        background: '#22c55e',
        color: '#ffffff',
        iconColor: '#ffffff',
    });
</script>
@endif

{{-- SweetAlert logout konfirmasi --}}
<script>
document.querySelectorAll('form[action*="logout"]').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Apa anda yakin ingin keluar?',
            text: 'Anda akan keluar dari sistem SIGANA',
            icon: 'warning',
            showConfirmButton: true,
            confirmButtonText: 'Ya, Keluar',
            confirmButtonColor: '#ef4444',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6b7280',
            borderRadius: '12px',
            customClass: {
                popup: 'rounded-3',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>


<script>
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('sidebarToggle');

toggleBtn.addEventListener('click', () => {
  // Mobile: pakai class show
  if (window.innerWidth < 992) {
    sidebar.classList.toggle('show');
  } else {
    // Desktop: pakai class collapsed
    sidebar.classList.toggle('collapsed');
    localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
  }
});

// Ingat state desktop
if (window.innerWidth >= 992 && localStorage.getItem('sidebar_collapsed') === 'true') {
  sidebar.classList.add('collapsed');
}
</script>
</body>
</html>