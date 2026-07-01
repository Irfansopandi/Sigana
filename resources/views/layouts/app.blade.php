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

  <!-- SIGANA Chatbot (custom widget, konek langsung ke webhook n8n) -->
  <style>
    #sigana-chat-toggle {
      position: fixed; bottom: 20px; right: 20px; z-index: 9999;
      width: 60px; height: 60px; border-radius: 50%; background: #1a1a3d;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); border: none;
    }
    #sigana-chat-toggle i { color: #fff; font-size: 26px; }

    #sigana-chat-box {
      position: fixed; bottom: 90px; right: 20px; z-index: 9999;
      width: 380px; height: 560px; max-width: 92vw; max-height: 75vh;
      display: none; flex-direction: column;
      border-radius: 16px; overflow: hidden;
      box-shadow: 0 8px 24px rgba(0,0,0,0.35);
      background: #fff; font-family: 'Inter', sans-serif;
    }
    #sigana-chat-header {
      background: #1a1a3d; color: #fff; padding: 16px;
      font-weight: 600; font-size: 15px;
    }
    #sigana-chat-messages {
      flex: 1; overflow-y: auto; padding: 14px; display: flex;
      flex-direction: column; gap: 10px; background: #f4f5f7;
    }
    .sigana-msg {
      max-width: 80%; padding: 10px 14px; border-radius: 14px;
      font-size: 14px; line-height: 1.4; white-space: pre-wrap;
    }
    .sigana-msg.bot {
      background: #fff; color: #1a1a3d; align-self: flex-start;
      border: 1px solid #e5e7eb;
    }
    .sigana-msg.user {
      background: #1a1a3d; color: #fff; align-self: flex-end;
    }
    #sigana-chat-input-row {
      display: flex; gap: 8px; padding: 12px; border-top: 1px solid #e5e7eb; background: #fff;
    }
    #sigana-chat-input {
      flex: 1; border: 1px solid #d1d5db; border-radius: 10px;
      padding: 10px 12px; font-size: 14px; outline: none;
    }
    #sigana-chat-send {
      background: #1a1a3d; color: #fff; border: none; border-radius: 10px;
      width: 42px; display: flex; align-items: center; justify-content: center; cursor: pointer;
    }
  </style>

  <button id="sigana-chat-toggle" type="button">
    <i class="bi bi-chat-dots-fill"></i>
  </button>

  <div id="sigana-chat-box">
    <div id="sigana-chat-header">SIGANA Assistant</div>
    <div id="sigana-chat-messages">
      <div class="sigana-msg bot">Halo! 👋 Ada yang bisa saya bantu terkait laporan bencana atau donasi?</div>
    </div>
    <div id="sigana-chat-input-row">
      <input type="text" id="sigana-chat-input" placeholder="Tulis pesan..." />
      <button id="sigana-chat-send" type="button"><i class="bi bi-send-fill"></i></button>
    </div>
  </div>

  <script>
    const SIGANA_WEBHOOK_URL = 'https://n8n.server-luna.web.id/webhook/ad5d6b7e-602f-46d2-9aa1-b7bed51a4ec6/chat';
    const siganaSessionId = 'sigana-' + Date.now() + '-' + Math.random().toString(36).slice(2);

    const toggleBtn   = document.getElementById('sigana-chat-toggle');
    const chatBox      = document.getElementById('sigana-chat-box');
    const messagesEl    = document.getElementById('sigana-chat-messages');
    const inputEl        = document.getElementById('sigana-chat-input');
    const sendBtn         = document.getElementById('sigana-chat-send');

    toggleBtn.addEventListener('click', () => {
      chatBox.style.display = chatBox.style.display === 'flex' ? 'none' : 'flex';
    });

    function addMessage(text, sender) {
      const div = document.createElement('div');
      div.className = 'sigana-msg ' + sender;
      div.textContent = text;
      messagesEl.appendChild(div);
      messagesEl.scrollTop = messagesEl.scrollHeight;
      return div;
    }

    async function sendSiganaMessage() {
      const text = inputEl.value.trim();
      if (!text) return;

      addMessage(text, 'user');
      inputEl.value = '';
      inputEl.disabled = true;
      sendBtn.disabled = true;

      const botDiv = addMessage('...', 'bot');
      let fullText = '';

      try {
        const response = await fetch(SIGANA_WEBHOOK_URL, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'sendMessage',
            sessionId: siganaSessionId,
            chatInput: text,
          }),
        });

        if (!response.ok || !response.body) {
          throw new Error('Response tidak valid');
        }

        const reader = response.body.getReader();
        const decoder = new TextDecoder();
        let buffer = '';

        while (true) {
          const { done, value } = await reader.read();
          if (done) break;

          buffer += decoder.decode(value, { stream: true });
          const lines = buffer.split('\n');
          buffer = lines.pop();

          for (const line of lines) {
            if (!line.trim()) continue;
            try {
              const parsed = JSON.parse(line);
              if (parsed.type === 'item' && typeof parsed.content === 'string') {
                fullText += parsed.content;
                botDiv.textContent = fullText;
                messagesEl.scrollTop = messagesEl.scrollHeight;
              }
            } catch (e) {
              // baris belum lengkap / bukan JSON valid, lewati
            }
          }
        }

        if (buffer.trim()) {
          try {
            const parsed = JSON.parse(buffer);
            if (parsed.type === 'item' && typeof parsed.content === 'string') {
              fullText += parsed.content;
            }
          } catch (e) {}
        }

        botDiv.textContent = fullText || 'Maaf, tidak ada respons.';
      } catch (err) {
        botDiv.textContent = 'Maaf, terjadi kesalahan koneksi ke chatbot. Coba lagi nanti.';
        console.error('SIGANA chat error:', err);
      } finally {
        inputEl.disabled = false;
        sendBtn.disabled = false;
        inputEl.focus();
      }
    }

    sendBtn.addEventListener('click', sendSiganaMessage);
    inputEl.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') sendSiganaMessage();
    });
  </script>

</body>

</html>