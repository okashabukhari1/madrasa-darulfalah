// script.js — Madrasa Dar-ul-Falah Main JS

document.addEventListener('DOMContentLoaded', () => {

  // Dynamic Bidirectional Text Support: Automatically set dir="auto" on all text inputs and textareas
  // so that when a user types Urdu or Arabic, the input field smoothly flips to Right-To-Left.
  document.querySelectorAll('input[type="text"], input[type="search"], input[type="email"], textarea').forEach(el => {
    if (!el.hasAttribute('dir')) {
      el.setAttribute('dir', 'auto');
    }
  });

  // ===== LOADING SCREEN =====
  const loadingScreen = document.getElementById('loading-screen');
  if (loadingScreen) {
    setTimeout(() => loadingScreen.classList.add('hidden'), 2200);
  }

  // ===== NAVBAR SCROLL =====
  const navbar = document.getElementById('navbar');
  const handleScroll = () => {
    if (navbar) {
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    }
    // Back to top
    const btt = document.getElementById('back-to-top');
    if (btt) btt.classList.toggle('visible', window.scrollY > 400);
  };
  window.addEventListener('scroll', handleScroll, { passive: true });

  // ===== MOBILE MENU =====
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');
  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      mobileMenu.classList.toggle('open');
    });
    mobileMenu.querySelectorAll('a').forEach(a => {
      a.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('open');
      });
    });
  }

  // ===== ACTIVE NAV LINK =====
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-links a, .mobile-menu a').forEach(a => {
    if (a.getAttribute('href') === currentPage) a.classList.add('active');
  });

  // ===== BACK TO TOP =====
  const btt = document.getElementById('back-to-top');
  if (btt) btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  // ===== SMOOTH SCROLL =====
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
  });

  // ===== SCROLL REVEAL =====
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
  }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

  document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => revealObserver.observe(el));

  // ===== 3D TILT EFFECT on cards =====
  const tiltElements = document.querySelectorAll('.course-card, .teacher-full-card, .full-course-card');
  tiltElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const cx = rect.left + rect.width / 2;
      const cy = rect.top + rect.height / 2;
      const dx = (e.clientX - cx) / (rect.width / 2);
      const dy = (e.clientY - cy) / (rect.height / 2);
      el.style.transform = `translateY(-10px) rotateX(${-dy*5}deg) rotateY(${dx*5}deg)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = '';
    });
  });

  // ===== PARALLAX =====
  const parallaxEls = document.querySelectorAll('[data-parallax]');
  window.addEventListener('scroll', () => {
    const sy = window.scrollY;
    parallaxEls.forEach(el => {
      const speed = parseFloat(el.dataset.parallax) || 0.3;
      el.style.transform = `translateY(${sy * speed}px)`;
    });
  }, { passive: true });

  // ===== COUNTERS =====
  const counterEls = document.querySelectorAll('[data-count]');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const el = e.target;
      const target = parseInt(el.dataset.count);
      let cur = 0;
      const step = Math.ceil(target / 60);
      const timer = setInterval(() => {
        cur = Math.min(cur + step, target);
        el.textContent = cur + (el.dataset.suffix || '');
        if (cur >= target) clearInterval(timer);
      }, 30);
      counterObserver.unobserve(el);
    });
  }, { threshold: 0.5 });
  counterEls.forEach(el => counterObserver.observe(el));

  // ===== GALLERY LIGHTBOX =====
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightbox-img');
  const galleryItems = document.querySelectorAll('.gallery-item');
  let currentGalleryIdx = 0;

  if (lightbox && galleryItems.length) {
    galleryItems.forEach((item, idx) => {
      item.addEventListener('click', () => {
        currentGalleryIdx = idx;
        openLightbox(idx);
      });
    });

    function openLightbox(idx) {
      lightbox.classList.add('open');
      document.body.style.overflow = 'hidden';
      const item = galleryItems[idx];
      if (lightboxImg) {
        lightboxImg.querySelector('.lb-emoji').textContent = item.dataset.emoji || '<i class="bi bi-bank"></i>';
        lightboxImg.querySelector('.lb-caption').textContent = item.querySelector('.gallery-item-caption')?.textContent || '';
      }
    }

    document.getElementById('lightbox-close')?.addEventListener('click', () => {
      lightbox.classList.remove('open');
      document.body.style.overflow = '';
    });
    document.getElementById('lightbox-prev')?.addEventListener('click', () => {
      currentGalleryIdx = (currentGalleryIdx - 1 + galleryItems.length) % galleryItems.length;
      openLightbox(currentGalleryIdx);
    });
    document.getElementById('lightbox-next')?.addEventListener('click', () => {
      currentGalleryIdx = (currentGalleryIdx + 1) % galleryItems.length;
      openLightbox(currentGalleryIdx);
    });
    lightbox.addEventListener('click', e => {
      if (e.target === lightbox) { lightbox.classList.remove('open'); document.body.style.overflow = ''; }
    });
    document.addEventListener('keydown', e => {
      if (!lightbox.classList.contains('open')) return;
      if (e.key === 'Escape') { lightbox.classList.remove('open'); document.body.style.overflow = ''; }
      if (e.key === 'ArrowLeft') { currentGalleryIdx = (currentGalleryIdx - 1 + galleryItems.length) % galleryItems.length; openLightbox(currentGalleryIdx); }
      if (e.key === 'ArrowRight') { currentGalleryIdx = (currentGalleryIdx + 1) % galleryItems.length; openLightbox(currentGalleryIdx); }
    });
  }

  // ===== COURSE FILTERS =====
  const filterBtns = document.querySelectorAll('.filter-btn');
  const courseCards = document.querySelectorAll('.full-course-card');
  if (filterBtns.length && courseCards.length) {
    filterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        courseCards.forEach(card => {
          if (filter === 'all' || card.dataset.category === filter) {
            card.style.display = '';
            setTimeout(() => card.style.opacity = 1, 10);
          } else {
            card.style.opacity = 0;
            setTimeout(() => card.style.display = 'none', 300);
          }
        });
      });
    });
  }

  // ===== ADMISSION FORM VALIDATION =====
  const admissionForm = document.getElementById('admission-form');
  if (admissionForm) {
    admissionForm.addEventListener('submit', function(e) {
      let valid = true;
      const fields = admissionForm.querySelectorAll('[required]');
      fields.forEach(field => {
        const group = field.closest('.form-group');
        const error = group?.querySelector('.error');
        if (!field.value.trim()) {
          group?.classList.add('has-error');
          if (error) error.textContent = 'This field is required.';
          valid = false;
        } else if (field.type === 'email' && !/\S+@\S+\.\S+/.test(field.value)) {
          group?.classList.add('has-error');
          if (error) error.textContent = 'Please enter a valid email address.';
          valid = false;
        } else if (field.type === 'tel' && !/^\+?[\d\s\-]{8,15}$/.test(field.value)) {
          group?.classList.add('has-error');
          if (error) error.textContent = 'Please enter a valid phone number.';
          valid = false;
        } else {
          group?.classList.remove('has-error');
        }
      });
      
      if (!valid) {
        e.preventDefault();
      }
    });

    admissionForm.querySelectorAll('input, select, textarea').forEach(field => {
      field.addEventListener('input', () => {
        field.closest('.form-group')?.classList.remove('has-error');
      });
    });
  }

  // ===== CONTACT FORM VALIDATION =====
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      let valid = true;
      contactForm.querySelectorAll('[required]').forEach(field => {
        const group = field.closest('.form-group');
        const error = group?.querySelector('.error');
        if (!field.value.trim()) {
          group?.classList.add('has-error');
          if (error) error.textContent = 'This field is required.';
          valid = false;
        } else if (field.type === 'email' && !/\S+@\S+\.\S+/.test(field.value)) {
          group?.classList.add('has-error');
          if (error) error.textContent = 'Please enter a valid email.';
          valid = false;
        } else {
          group?.classList.remove('has-error');
        }
      });
      
      if (!valid) {
        e.preventDefault();
      }
    });
  }

  // ===== MARQUEE DUPLICATE =====
  const marqueeTrack = document.querySelector('.marquee-track');
  if (marqueeTrack) {
    const clone = marqueeTrack.cloneNode(true);
    marqueeTrack.parentNode.appendChild(clone);
  }

  // ===== HERO CANVAS RESIZE =====
  const lanternCanvas = document.getElementById('lantern-canvas');
  if (lanternCanvas) {
    const resizeLantern = () => {
      const container = lanternCanvas.parentElement;
      if (container) {
        lanternCanvas.width = container.clientWidth;
        lanternCanvas.height = Math.min(container.clientWidth, 450);
      }
    };
    resizeLantern();
    window.addEventListener('resize', resizeLantern);
  }

  // ===== PASSWORD TOGGLE =====
  const initPasswordToggles = () => {
    document.querySelectorAll('.password-toggle').forEach(toggle => {
      toggle.addEventListener('click', function() {
        const parent = this.closest('.password-input-wrapper') || this.parentElement;
        const input = parent.querySelector('input');
        const icon = this.querySelector('i');
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
      });
    });
  };
  initPasswordToggles();

});

// ===== ADMIN / STUDENT PORTAL SHARED UTILS =====
// Simple localStorage-based auth (demo)
const Auth = {
  users: [
    { id: 'admin001', email: 'admin@darulfalah.edu', password: 'admin123', role: 'admin', name: 'Administrator' },
    { id: 'STU001', email: 'ahmad@student.com', password: 'student123', role: 'student', name: 'Ahmad Farooq', course: 'Hifz-ul-Quran' },
    { id: 'STU002', email: 'fatima@student.com', password: 'student456', role: 'student', name: 'Fatima Malik', course: 'Tajweed' }
  ],
  login(emailOrId, password, role) {
    return this.users.find(u =>
      (u.email === emailOrId || u.id === emailOrId) &&
      u.password === password &&
      u.role === role
    ) || null;
  },
  saveSession(user) { localStorage.setItem('mdf_user', JSON.stringify(user)); },
  getSession() { try { return JSON.parse(localStorage.getItem('mdf_user')); } catch(e) { return null; } },
  logout() { localStorage.removeItem('mdf_user'); }
};
window.MdfAuth = Auth;
