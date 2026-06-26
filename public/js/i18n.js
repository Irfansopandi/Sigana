const translations = {
  id: {
    // Navbar publik
    'nav.beranda':       'Beranda',
    'nav.tentang':       'Tentang',
    'nav.bencana':       'Bencana',
    'nav.transparansi':  'Transparansi',
    'nav.kontak':        'Kontak',
    'nav.login':         'Login',
    'nav.daftar':        'Daftar',
    'nav.dashboard':     'Dashboard',
    'nav.keluar':        'Keluar',

    // Sidebar label
    'sidebar.utama':     'Utama',
    'sidebar.tugas':     'Tugas',
    'sidebar.donasi':    'Donasi',
    'sidebar.informasi': 'Informasi',
    'sidebar.manajemen': 'Manajemen',
    'sidebar.sistem':    'Sistem',
    'sidebar.akun':      'Akun',
    'sidebar.lainnya':   'Lainnya',

    // Sidebar links
    'menu.dashboard':         'Dashboard',
    'menu.bencana':           'Bencana',
    'menu.laporan_tugas':     'Laporan Tugas',
    'menu.info_kampanye':     'Info Kampanye',
    'menu.profil':            'Profil Saya',
    'menu.lihat_situs':       'Lihat Situs',
    'menu.kampanye_bencana':  'Kampanye Bencana',
    'menu.riwayat_donasi':    'Riwayat Donasi',
    'menu.transparansi_dana': 'Transparansi Dana',
    'menu.pengguna':          'Pengguna',
    'menu.donasi':            'Donasi',
    'menu.laporan':           'Laporan Transparansi',
    'menu.pengaturan':        'Pengaturan',

    // Sidebar role
    'role.relawan':  'Relawan',
    'role.donatur':  'Donatur',
    'role.admin':    'Admin SiGana',

    // Topbar
    'topbar.lihat_situs': 'Lihat Situs',

    // SweetAlert
    'swal.logout_title': 'Apa anda yakin ingin keluar?',
    'swal.logout_text':  'Anda akan keluar dari sistem SIGANA',
    'swal.logout_ok':    'Ya, Keluar',
    'swal.logout_batal': 'Batal',
  },
  en: {
    'nav.beranda':       'Home',
    'nav.tentang':       'About',
    'nav.bencana':       'Disaster',
    'nav.transparansi':  'Transparency',
    'nav.kontak':        'Contact',
    'nav.login':         'Login',
    'nav.daftar':        'Register',
    'nav.dashboard':     'Dashboard',
    'nav.keluar':        'Logout',

    'sidebar.utama':     'Main',
    'sidebar.tugas':     'Tasks',
    'sidebar.donasi':    'Donation',
    'sidebar.informasi': 'Information',
    'sidebar.manajemen': 'Management',
    'sidebar.sistem':    'System',
    'sidebar.akun':      'Account',
    'sidebar.lainnya':   'Others',

    'menu.dashboard':         'Dashboard',
    'menu.bencana':           'Disaster',
    'menu.laporan_tugas':     'Task Report',
    'menu.info_kampanye':     'Campaign Info',
    'menu.profil':            'My Profile',
    'menu.lihat_situs':       'View Site',
    'menu.kampanye_bencana':  'Disaster Campaign',
    'menu.riwayat_donasi':    'Donation History',
    'menu.transparansi_dana': 'Fund Transparency',
    'menu.pengguna':          'Users',
    'menu.donasi':            'Donations',
    'menu.laporan':           'Transparency Report',
    'menu.pengaturan':        'Settings',

    'role.relawan':  'Volunteer',
    'role.donatur':  'Donor',
    'role.admin':    'Admin SiGana',

    'topbar.lihat_situs': 'View Site',

    'swal.logout_title': 'Are you sure you want to logout?',
    'swal.logout_text':  'You will be logged out of SIGANA',
    'swal.logout_ok':    'Yes, Logout',
    'swal.logout_batal': 'Cancel',
  }
};

function getCurrentLang() {
  return localStorage.getItem('sigana_lang') || 'id';
}

function applyLang(lang) {
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (translations[lang] && translations[lang][key]) {
      el.textContent = translations[lang][key];
    }
  });
  const label = document.getElementById('langLabel');
  if (label) label.textContent = lang.toUpperCase();
}

function toggleLang() {
  const next = getCurrentLang() === 'id' ? 'en' : 'id';
  localStorage.setItem('sigana_lang', next);
  applyLang(next);
}

// Auto-apply saat halaman load
document.addEventListener('DOMContentLoaded', () => {
  applyLang(getCurrentLang());
});