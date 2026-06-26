<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SIGANA - Sistem Informasi Tanggap Bencana dan Donasi. Laporkan bencana, berdonasi secara transparan, dan bantu korban bencana dengan cepat dan terpercaya.">
  <meta name="author" content="SIGANA Team">
  <title>@yield('title', 'SIGANA - Sistem Informasi Tanggap Bencana dan Donasi')</title>
  @yield('meta')

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  {{-- icon boostrap --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom Styles -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  {{-- Leaflet map--}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  {{-- aos css --}}
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" type="image/jpeg" href="{{ asset('storage/assets/logo/logo-bulat.webp') }}">

  @stack('styles')
</head>

<body class="@yield('body_class')">

  <x-navbar />

  <main>
    @yield('content')
  </main>

  <x-footer />

  <!-- Bootstrap 5 Bundle with Popper JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

  <!-- Custom Logic Script -->
  <script src="{{ asset('js/app.js') }}"></script>
  <!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, easing: 'ease-out-cubic' });
  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@stack('scripts')

{{-- SweetAlert logut success --}}
@if(session('logout_success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: '{{ session('logout_success') }}',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#22c55e',
        color: '#ffffff',
        iconColor: '#ffffff',
    });
</script>
@endif

<script>
  const html     = document.documentElement;
  const btn      = document.getElementById('btnTheme');
  const icon     = document.getElementById('iconTheme');

  // Ambil preferensi tersimpan, default = light
  const saved = localStorage.getItem('sigana-theme') || 'light';
  applyTheme(saved);

  btn.addEventListener('click', () => {
    const next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
    applyTheme(next);
    localStorage.setItem('sigana-theme', next);
  });

  function applyTheme(theme) {
    html.setAttribute('data-bs-theme', theme);
    if (theme === 'dark') {
      icon.classList.replace('fa-moon', 'fa-sun');
    } else {
      icon.classList.replace('fa-sun', 'fa-moon');
    }
  }
</script>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
if (document.getElementById('map')) {
  const campaignMarkers = @json($campaignMarkers ?? []);

  // Dark tile layer dari CartoDB — mirip Mapbox dark-v11
  const map = L.map('map', {
    center: [-2.5, 117.0],
    zoom: 5,
    zoomControl: true,
  });

  L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 19,
  }).addTo(map);

  // Warna per status
  function markerColor(status) {
    return { 'Darurat': '#ef4444', 'Waspada': '#f59e0b', 'Aktif': '#3b82f6' }[status] ?? '#6b7280';
  }

  // Emoji per kategori
  function markerEmoji(category) {
    return { 'banjir': '🌊', 'gempa': '🏚️', 'erupsi': '🌋', 'longsor': '⛰️', 'kebakaran': '🔥' }[category] ?? '⚠️';
  }

  campaignMarkers.forEach(c => {
    // Custom icon HTML
    const iconHtml = `
      <div class="lf-marker-wrap">
        <div class="lf-pin" style="background:${markerColor(c.status)};">
          <span class="lf-emoji">${markerEmoji(c.category)}</span>
        </div>
        <div class="lf-pulse" style="background:${markerColor(c.status)};"></div>
      </div>
    `;

    const customIcon = L.divIcon({
      html: iconHtml,
      className: '',
      iconSize: [40, 40],
      iconAnchor: [20, 40],
      popupAnchor: [0, -44],
    });

    const popupContent = `
      <div class="lf-popup-inner">
        <div class="lf-popup-header">
          <span class="lf-badge" style="background:${markerColor(c.status)};">${c.status}</span>
          <span class="lf-loc">${c.location}</span>
        </div>
        <h6 class="lf-title">${c.title}</h6>
        <div class="lf-meta">
          Terkumpul: <strong style="color:#1d4ed8;">${c.collected}</strong>
          &nbsp;•&nbsp; Progress: <strong>${c.progress}</strong>
        </div>
        <a href="/bencana/${c.slug}" class="lf-btn">Lihat & Donasi →</a>
      </div>
    `;

    L.marker([c.latitude, c.longitude], { icon: customIcon })
      .bindPopup(popupContent, { maxWidth: 280, className: 'sigana-leaflet-popup' })
      .addTo(map);
  });
}
</script>
</body>

</html>
