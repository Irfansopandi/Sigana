<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6 animate-on-scroll">
        <a class="footer-brand d-flex align-items-center gap-2" href="{{ route('home') }}" style="text-decoration: none;">
          <img src="{{ asset('storage/assets/logo/logo-bulat.webp') }}" alt="SIGANA" 
              style="height: 48px; width: 48px; object-fit: contain;">
          <span class="fw-bold fs-5">SI<span class="brand-red">GANA</span></span>
        </a>
        <p class="mt-3">
          SIGANA (Sistem Informasi Tanggap Bencana dan Donasi) hadir sebagai jembatan informasi digital yang cepat, aman, dan transparan antara pelapor bencana, donatur, dan tim penyalur bantuan di lapangan.
        </p>
        <div class="footer-socials">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>
      
      <div class="col-lg-2 col-md-6 col-6 animate-on-scroll">
        <h5>Navigasi</h5>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('tentang') }}">Tentang</a></li>
          <li><a href="{{ route('bencana') }}">Kampanye Donasi</a></li>
          <li><a href="{{ route('transparansi') }}">Transparansi</a></li>
          <li><a href="{{ route('kontak') }}">Kontak Kami</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-6 col-6 animate-on-scroll">
        <h5>Tautan Penting</h5>
        <ul class="footer-links">
          <li><a href="#alur">Alur Kerja</a></li>
          <li><a href="{{ route('login') }}">Login Akun</a></li>
          <li><a href="#">Kebijakan Privasi</a></li>
          <li><a href="#">Syarat & Ketentuan</a></li>
          <li><a href="#">Bantuan (FAQ)</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-6 animate-on-scroll">
        <h5>Kontak Kami</h5>
        <div class="footer-contact-item">
          <i class="fa-solid fa-location-dot"></i>
          <span>Gedung BNPB, Jl. Pramuka No.38, Jakarta Timur, Indonesia</span>
        </div>
        <div class="footer-contact-item">
          <i class="fa-solid fa-phone"></i>
          <span>+62 21-1234-5678</span>
        </div>
        <div class="footer-contact-item">
          <i class="fa-solid fa-envelope"></i>
          <span>support@sigana.or.id</span>
        </div>
      </div>
    </div>
    
    <div class="footer-bottom">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <p class="mb-0">&copy; {{ date('Y') }} SIGANA Team. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
          <ul class="footer-bottom-links">
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Syarat Ketentuan</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
