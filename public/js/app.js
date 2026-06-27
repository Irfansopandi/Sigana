// SIGANA - Custom JavaScript Interactions
// Bagian animasi scroll, dialog peta, dan simulasi form donasi.

document.addEventListener('DOMContentLoaded', function () {

  // ==========================================
  // Sticky Navbar
  // ==========================================
  const navbar = document.getElementById('mainNavbar');

  function checkScroll() {
    if (navbar) {
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
      } else {
        navbar.classList.remove('navbar-scrolled');
      }
    }
  }

  window.addEventListener('scroll', checkScroll);
  checkScroll(); // Jalankan sekali saat load

  // ==========================================
  // Tutup menu mobile otomatis saat link diklik
  // ==========================================
  const navCollapse = document.getElementById('navbarNav');
  if (navCollapse) {
    const bsCollapse = new bootstrap.Collapse(navCollapse, { toggle: false });
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth < 992) {
          bsCollapse.hide();
        }
      });
    });
  }

// ===== HERO CAROUSEL SEAMLESS =====
(function () {
  const track = document.getElementById('heroCarouselTrack');
  if (!track) return;

  const originalSlides = Array.from(track.children);
  const total = originalSlides.length;
  const dots = document.querySelectorAll('.hero-dot');

  // Clone semua slide: taruh clone di depan dan belakang
  originalSlides.forEach(slide => {
    track.appendChild(slide.cloneNode(true));   // clone di belakang
  });
  originalSlides.forEach(slide => {
    track.insertBefore(slide.cloneNode(true), track.firstChild); // clone di depan
  });

  const allSlides = track.children;
  let current = total; // mulai dari set asli (setelah clone depan)
  let isTransitioning = false;
  let autoplayTimer = null;
  const DURATION = 500; // ms

  function updateDots(index) {
    const realIndex = ((index - total) % total + total) % total;
    dots.forEach((d, i) => d.classList.toggle('active', i === realIndex));
  }

  function goTo(index, animate = true) {
    if (isTransitioning && animate) return;
    isTransitioning = animate;

    if (animate) {
      track.style.transition = `transform ${DURATION}ms cubic-bezier(0.4, 0, 0.2, 1)`;
    } else {
      track.style.transition = 'none';
    }

    track.style.transform = `translateX(-${index * 100}%)`;
    current = index;
    updateDots(index);

    if (animate) {
      setTimeout(() => {
        isTransitioning = false;

        // Seamless jump: kalau sudah di clone belakang → loncat ke asli
        if (current >= total * 2) {
          track.style.transition = 'none';
          current = total;
          track.style.transform = `translateX(-${current * 100}%)`;
        }

        // Seamless jump: kalau sudah di clone depan → loncat ke asli
        if (current < total) {
          track.style.transition = 'none';
          current = total * 2 - 1;
          track.style.transform = `translateX(-${current * 100}%)`;
        }

        updateDots(current);
      }, DURATION);
    }
  }

  function next() { goTo(current + 1); }

  function startAutoplay() {
    autoplayTimer = setInterval(next, 3500);
  }

  function resetAutoplay() {
    clearInterval(autoplayTimer);
    startAutoplay();
  }

  // Dots click
  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      const targetReal = parseInt(dot.dataset.index);
      goTo(total + targetReal);
      resetAutoplay();
    });
  });

  // Pause on hover
  track.closest('.hero-carousel').addEventListener('mouseenter', () => clearInterval(autoplayTimer));
  track.closest('.hero-carousel').addEventListener('mouseleave', startAutoplay);

  // Touch swipe
  let touchStartX = 0;
  track.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
  track.addEventListener('touchend', e => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) {
      diff > 0 ? next() : goTo(current - 1);
      resetAutoplay();
    }
  });

  // Init
  goTo(total, false);
  startAutoplay();
})();

  // ==========================================
  // Scroll Animations (Intersection Observer)
  // ==========================================
  const animateElements = document.querySelectorAll(
    '.animate-on-scroll, .animate-fade-in-left, .animate-fade-in-right, .animate-scale-in'
  );
  
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target); // Hanya animasi sekali
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    });
    
    animateElements.forEach(el => observer.observe(el));
  } else {
    // Fallback jika browser tidak mendukung IntersectionObserver
    animateElements.forEach(el => el.classList.add('visible'));
  }

// ==========================================
// Stats Counter Animation
// ==========================================
function animateCounter(el, target, prefix, suffix, duration) {
  let start = 0;
  const step = Math.ceil(target / (duration / 16));
  const timer = setInterval(() => {
    start += step;
    if (start >= target) {
      start = target;
      clearInterval(timer);
    }
    el.textContent = prefix + start.toLocaleString('id-ID') + suffix;
  }, 16);
}

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
  const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const elLaporan = document.getElementById('stat-laporan');
        const elDonatur = document.getElementById('stat-donatur');
        const elKorban  = document.getElementById('stat-korban');
        const elDonasi  = document.getElementById('stat-donasi');

        const targetLaporan = parseInt(elLaporan.textContent.replace(/[^0-9]/g, '')) || 0;
        const targetDonatur = parseInt(elDonatur.textContent.replace(/[^0-9]/g, '')) || 0;
        const targetKorban  = parseInt(elKorban.textContent.replace(/[^0-9]/g, '')) || 0;
        const targetDonasiJuta = Math.round(parseInt(elDonasi.textContent.replace(/[^0-9]/g, '')) / 1000000);

        animateCounter(elLaporan, targetLaporan, '', '', 1800);
        animateCounter(elDonatur, targetDonatur, '', '', 2000);
        animateCounter(elKorban,  targetKorban,  '', '', 2200);

        // Donasi pakai format Juta supaya tidak kepotong
        let donasiVal = 0;
        const step = Math.ceil(targetDonasiJuta / (2400 / 16));
        const donasiTimer = setInterval(() => {
          donasiVal += step;
          if (donasiVal >= targetDonasiJuta) {
            donasiVal = targetDonasiJuta;
            clearInterval(donasiTimer);
          }
          elDonasi.textContent = 'Rp' + donasiVal.toLocaleString('id-ID') + ' Juta';
        }, 16);

        statsObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.4 });

  statsObserver.observe(statsSection);
}

  // ==========================================
  // Map Marker Interaction
  // ==========================================
  const markers = document.querySelectorAll('.map-marker');
  const markerModalEl = document.getElementById('mapMarkerModal');
  if (markerModalEl) {
    const markerModal = new bootstrap.Modal(markerModalEl);
    const modalStatus = document.getElementById('modalMarkerStatus');
    const modalLocation = document.getElementById('modalMarkerLocation');
    const modalType = document.getElementById('modalMarkerType');
    const modalDesc = document.getElementById('modalMarkerDesc');
    const btnModalAction = document.getElementById('btnModalAction');
    
    markers.forEach(marker => {
      marker.addEventListener('click', () => {
        const location = marker.getAttribute('data-location');
        const type = marker.getAttribute('data-type');
        const status = marker.getAttribute('data-status');
        const desc = marker.getAttribute('data-desc');
        
        modalLocation.textContent = location;
        modalType.textContent = type;
        modalStatus.textContent = status;
        modalDesc.textContent = desc;
        
        // Sesuaikan warna status badge di modal
        if (status === 'Darurat') {
          modalStatus.className = 'badge bg-danger p-2 mb-2';
        } else if (status === 'Waspada') {
          modalStatus.className = 'badge bg-warning text-dark p-2 mb-2';
        } else {
          modalStatus.className = 'badge bg-primary p-2 mb-2';
        }
        
        // Sesuaikan action button di modal
        if (status === 'Aktif') {
          btnModalAction.textContent = 'Lihat Detail Penyaluran';
          btnModalAction.href = '#alur';
        } else {
          btnModalAction.textContent = 'Bantu Sekarang';
          btnModalAction.href = '#donasi';
        }
        
        markerModal.show();
      });
    });
  }


  // ==========================================
  // Bencana Page: Search, Category Filter, and Sorting
  // ==========================================
  const searchInput = document.getElementById('searchInput');
  const categoryBtns = document.querySelectorAll('.filter-cat-btn');
  const mobileCatSelect = document.getElementById('mobileCategorySelect');
  const sortSelect = document.getElementById('sortSelect');
  const campaignsGrid = document.getElementById('campaignsGrid');
  const emptyState = document.getElementById('emptyState');
  
  if (campaignsGrid) {
    const cardItems = Array.from(campaignsGrid.querySelectorAll('.campaign-card-item'));
    let activeCategory = 'all';
    let searchQuery = '';

    function applyFilterAndSort() {
      let visibleCount = 0;

      // 1. Filtering
      cardItems.forEach(item => {
        const nameAttr = item.getAttribute('data-name');
        const catAttr = item.getAttribute('data-category');
        
        const matchesSearch = nameAttr.includes(searchQuery);
        const matchesCategory = (activeCategory === 'all' || catAttr === activeCategory);

        if (matchesSearch && matchesCategory) {
          item.classList.remove('d-none');
          visibleCount++;
        } else {
          item.classList.add('d-none');
        }
      });

      // Show/hide empty state
      if (visibleCount === 0) {
        emptyState.classList.remove('d-none');
      } else {
        emptyState.classList.add('d-none');
      }

      // 2. Sorting
      const sortBy = sortSelect.value;
      const sortedItems = [...cardItems];

      sortedItems.sort((a, b) => {
        if (sortBy === 'newest') {
          // data-date is integer index of added order (higher is newer)
          return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
        } else if (sortBy === 'days-left') {
          return parseInt(a.getAttribute('data-days')) - parseInt(b.getAttribute('data-days'));
        } else if (sortBy === 'target-highest') {
          return parseFloat(b.getAttribute('data-target')) - parseFloat(a.getAttribute('data-target'));
        } else if (sortBy === 'target-lowest') {
          return parseFloat(a.getAttribute('data-target')) - parseFloat(b.getAttribute('data-target'));
        } else if (sortBy === 'progress-highest') {
          return parseFloat(b.getAttribute('data-progress')) - parseFloat(a.getAttribute('data-progress'));
        }
        return 0;
      });

      // Append items back to grid in sorted order
      sortedItems.forEach(item => {
        campaignsGrid.appendChild(item);
      });
    }

    // Event listeners
    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase().trim();
        applyFilterAndSort();
      });
    }

    // Category button clicks (Desktop)
    categoryBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        categoryBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeCategory = btn.getAttribute('data-category');
        
        // Sync mobile dropdown
        if (mobileCatSelect) {
          mobileCatSelect.value = activeCategory;
        }

        applyFilterAndSort();
      });
    });

    // Category select change (Mobile)
    if (mobileCatSelect) {
      mobileCatSelect.addEventListener('change', (e) => {
        activeCategory = e.target.value;
        
        // Sync desktop buttons
        categoryBtns.forEach(btn => {
          if (btn.getAttribute('data-category') === activeCategory) {
            btn.classList.add('active');
          } else {
            btn.classList.remove('active');
          }
        });

        applyFilterAndSort();
      });
    }

    // Sorting change
    if (sortSelect) {
      sortSelect.addEventListener('change', applyFilterAndSort);
    }

    // Run once on load to ensure sort order matches dropdown default
    applyFilterAndSort();
  }

});



