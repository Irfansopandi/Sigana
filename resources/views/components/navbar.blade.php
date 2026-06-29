  <style>
    html {
      overflow-y: scroll !important;
    }
  /* User dropdown button */
  .dropdown > .btn-outline-primary {
    border-radius: 50px;
    padding: 6px 16px;
    font-size: 0.85rem;
    border-width: 1.5px;
  }

  /* Dropdown menu */
  .dropdown-menu {
    border-radius: 12px;
    min-width: 190px;
    padding: 6px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
    border: 1px solid #e2e8f0 !important;
  }

  .dropdown-item {
    padding: 9px 14px;
    font-size: 0.875rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: all .2s;
    color: #374151;
  }

  .dropdown-item i {
    color: #9ca3af !important;
    transition: color .2s;
  }

  .dropdown-item:hover {
    ackground: #eff6ff;
    color: #1d4ed8 !important;
    border-left: 3px solid #1d4ed8;
    padding-left: 11px;
  }

  .dropdown-item:hover i {
    color: #1d4ed8 !important;
  }

  .dropdown-item.text-danger {
    color: #374151 !important;
  }

  .dropdown-item.text-danger:hover {
    background: #eff6ff;
    color: #1d4ed8 !important;
    border-left: 3px solid #1d4ed8;
    padding-left: 11px;
  }

  .dropdown-item.text-danger:hover i {
    color: #1d4ed8 !important;
  }

  .dropdown-item:not(:hover) {
    border-left: 3px solid transparent;
  }

  .dropdown-divider {
    margin: 4px 0;
    border-color: #f1f5f9;
  }

  /* ============================================
    USER DROPDOWN BUTTON — FIX CARET + BORDER TIPIS
  ============================================ */

  /* Matikan caret bawaan Bootstrap (konflik sama border gradient ::after) */
  .user-dropdown-btn.dropdown-toggle::after {
    display: none !important;
    content: none !important;
  }

  /* Caret manual */
  .user-dropdown-caret {
    font-size: 0.65rem;
    margin-left: 2px;
    transition: transform 0.3s ease;
  }

  .user-dropdown-btn[aria-expanded="true"] .user-dropdown-caret {
    transform: rotate(180deg);
  }

  /* Ukuran lebih panjang & border lebih tipis */
  .user-dropdown-btn {
    padding: 8px 20px !important;
    font-size: 0.9rem !important;
    border-radius: 50px !important;
  }

  /* Theme toggle — icon only,  border */
  #btnTheme {
    width: 36px !important;
    height: 36px !important;
    padding: 0 !important;
    border-radius: 50% !important;
    background: none !important;
    border: 1.5px solid #6b7280 !important;
    color: #6b7280 !important;
    box-shadow: none !important;
    font-size: 0.9rem;
    transition: all 0.2s;
  }

  #btnTheme:hover, #btnTheme:focus {
    background: #6b728020 !important;
    border-color: #9ca3af !important;
    color: #9ca3af !important;
    box-shadow: none !important;
  }

  </style>

  <nav class="navbar navbar-expand-lg fixed-top" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
        <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA" 
            style="height: 42px; width: 42px; object-fit: contain;">
        <span class="fw-bold fs-5">SI<span class="brand-red">GANA</span></span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa-solid fa-bars-staggered fs-4"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" id="nav-beranda">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}" id="nav-tentang">Tentang</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('bencana') ? 'active' : '' }}" href="{{ route('bencana') }}" id="nav-bencana">Bencana</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('transparansi') ? 'active' : '' }}" href="{{ route('transparansi') }}" id="nav-transparansi">Transparansi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}" id="nav-kontak">Kontak</a>
          </li>
          @guest
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('register.relawan') ? 'active' : '' }}" href="{{ route('register.relawan') }}" id="nav-relawan">
              Daftar Relawan
            </a>
          </li>
          @endguest
        </ul>
        <div class="d-flex gap-2 align-items-center mt-3 mt-lg-0">
          {{-- Tombol toggle dark/light mode --}}
          <button id="btnTheme" class="btn btn-sm rounded-circle" 
            title="Ganti tema" style="width:36px; height:36px; padding:0;">
            <i class="fa-solid fa-moon" id="iconTheme"></i>
          </button>
          @guest
            <a href="{{ route('login') }}" class="btn btn-outline-primary" id="btn-login-nav">Login</a>
            <a href="{{ route('register.create') }}" class="btn btn-primary" id="btn-register-nav">Daftar</a>
          @else
            <div class="dropdown">
              <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center gap-2 user-dropdown-btn"
                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-circle-user"></i>
                <span class="small">{{ auth()->user()->name }}</span>
                <i class="fa-solid fa-chevron-down user-dropdown-caret"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end mt-2">
                <li>
                  <a class="dropdown-item"
                    href="{{
                      auth()->user()->isAdmin() ? route('admin.dashboard') :
                      (auth()->user()->isRelawan() ? route('relawan.dashboard') : route('user.dashboard'))
                    }}">
                    <i class="fa-solid fa-gauge fa-sm text-primary"></i> Dashboard
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                      <i class="fa-solid fa-right-from-bracket fa-sm"></i> Keluar
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          @endguest
        </div>
      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="{{ asset('js/i18n.js') }}"></script>
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
              scrollbarPadding: false,
              heightAuto: false, 
          }).then((result) => {
              if (result.isConfirmed) {
                  form.submit();
              }
          });
      });
  });
  </script>
