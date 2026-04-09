/* ============================================================
   MADRASA DAR-UL-FALAH — DASHBOARD JAVASCRIPT
   ============================================================ */

'use strict';

/* ── AUTH DATA ──────────────────────────────────────────────── */
const MdfAuth = {
  users: [
    {
      id: 'ADM001',
      role: 'admin',
      name: 'Admin User',
      email: 'admin@darulfalah.edu.pk',
      password: 'admin123',
      avatar: '<i class="bi bi-person"></i>',
      title: 'System Administrator'
    },
    {
      id: 'STU001',
      role: 'student',
      name: 'Ahmad Farooq',
      email: 'ahmad@student.com',
      password: 'student123',
      studentId: 'STU001',
      course: 'Hifz-ul-Quran',
      avatar: '<i class="bi bi-person"></i>',
      session: 'Morning',
      joining: '2024-01-15',
      phone: '0300-1234567',
      guardian: 'Muhammad Farooq',
      address: 'House 12, Street 4, F-8, Islamabad',
      progress: 65
    },
    {
      id: 'STU002',
      role: 'student',
      name: 'Fatima Malik',
      email: 'fatima@student.com',
      password: 'student456',
      studentId: 'STU002',
      course: 'Tajweed',
      avatar: '<i class="bi bi-person"></i>',
      session: 'Evening',
      joining: '2024-02-01',
      phone: '0321-9876543',
      guardian: 'Abdul Malik',
      address: 'Flat 5, Block B, G-9, Islamabad',
      progress: 45
    }
  ],

  login(identifier, password) {
    const u = this.users.find(u =>
      (u.email === identifier || u.studentId === identifier || u.id === identifier)
      && u.password === password
    );
    if (u) {
      sessionStorage.setItem('mdf_user', JSON.stringify(u));
      return u;
    }
    return null;
  },

  logout() {
    sessionStorage.removeItem('mdf_user');
  },

  getUser() {
    const raw = sessionStorage.getItem('mdf_user');
    return raw ? JSON.parse(raw) : null;
  },

  requireRole(role) {
    const u = this.getUser();
    if (!u || u.role !== role) {
      window.location.href = '/admin/login.html';
    }
    return u;
  },

  requireStudent() {
    const u = this.getUser();
    if (!u || u.role !== 'student') {
      window.location.href = '/student/login.html';
    }
    return u;
  }
};

/* ── MOCK DATA ──────────────────────────────────────────────── */
const MdfData = {
  students: [
    { id: 'STU001', name: 'Ahmad Farooq',    course: 'Hifz-ul-Quran',    session: 'Morning', status: 'active',   joined: '15 Jan 2024', phone: '0300-1234567', email: 'ahmad@student.com',   guardian: 'Muhammad Farooq' },
    { id: 'STU002', name: 'Fatima Malik',    course: 'Tajweed',           session: 'Evening', status: 'active',   joined: '01 Feb 2024', phone: '0321-9876543', email: 'fatima@student.com',  guardian: 'Abdul Malik' },
    { id: 'STU003', name: 'Usman Ali',       course: 'Alim Course',       session: 'Morning', status: 'active',   joined: '10 Jan 2024', phone: '0333-4567890', email: 'usman@student.com',   guardian: 'Ali Hassan' },
    { id: 'STU004', name: 'Maryam Siddiqui', course: 'Arabic Language',   session: 'Evening', status: 'inactive', joined: '20 Mar 2024', phone: '0345-6789012', email: 'maryam@student.com',  guardian: 'Tariq Siddiqui' },
    { id: 'STU005', name: 'Hassan Raza',     course: 'Islamic Studies',   session: 'Morning', status: 'active',   joined: '05 Feb 2024', phone: '0312-3456789', email: 'hassan@student.com',  guardian: 'Raza Hussain' },
    { id: 'STU006', name: 'Zainab Akhtar',   course: 'Tajweed',           session: 'Evening', status: 'active',   joined: '12 Feb 2024', phone: '0300-9876543', email: 'zainab@student.com',  guardian: 'Akhtar Hussain' },
    { id: 'STU007', name: 'Bilal Ahmad',     course: 'Hifz-ul-Quran',    session: 'Morning', status: 'active',   joined: '18 Jan 2024', phone: '0322-1234567', email: 'bilal@student.com',   guardian: 'Ahmad Khan' },
    { id: 'STU008', name: 'Ayesha Nawaz',    course: 'Quran Nazira',      session: 'Evening', status: 'active',   joined: '22 Mar 2024', phone: '0315-6543210', email: 'ayesha@student.com',  guardian: 'Nawaz Ahmad' },
  ],

  courses: [
    { id: 'CRS001', name: 'Hifz-ul-Quran',  teacher: 'Hafiz Usman Siddiqui', duration: '4-6 Years',  students: 145, status: 'active', category: 'Quran',   icon: '<i class="bi bi-book-half"></i>', seats: 160 },
    { id: 'CRS002', name: 'Tajweed',         teacher: 'Qari Abdul Rehman',    duration: '2 Years',    students: 98,  status: 'active', category: 'Quran',   icon: '🎙️', seats: 120 },
    { id: 'CRS003', name: 'Alim Course',     teacher: 'Mufti Abdur Rauf',     duration: '8 Years',    students: 76,  status: 'active', category: 'Alim',    icon: '<i class="bi bi-book"></i>', seats: 80 },
    { id: 'CRS004', name: 'Arabic Language', teacher: 'Ustaz Ibrahim Al-Misri',duration: '2 Years',   students: 112, status: 'active', category: 'Arabic',  icon: '<i class="bi bi-moon"></i>', seats: 140 },
    { id: 'CRS005', name: 'Islamic Studies', teacher: 'Dr. Khalid Mahmood',   duration: '1 Year',     students: 134, status: 'active', category: 'General', icon: '☪️',  seats: 160 },
    { id: 'CRS006', name: 'Tafseer',         teacher: 'Maulana Saeed Ahmad',  duration: '3 Years',    students: 54,  status: 'active', category: 'Quran',   icon: '<i class="bi bi-file-text"></i>', seats: 60 },
    { id: 'CRS007', name: 'Hadith Sciences', teacher: 'Mufti Abdur Rauf',     duration: '4 Years',    students: 43,  status: 'active', category: 'Alim',    icon: '<i class="bi bi-bank"></i>', seats: 50 },
    { id: 'CRS008', name: 'Quran Nazira',    teacher: 'Hafiz Usman Siddiqui', duration: '1 Year',     students: 89,  status: 'active', category: 'Quran',   icon: '📗', seats: 100 },
  ],

  teachers: [
    { id: 'TCH001', name: 'Hafiz Usman Siddiqui', subject: 'Hifz & Quran Nazira', qualification: 'Hafiz-e-Quran, Shahadat-ul-Alamiya', exp: '15 Years', email: 'usman@darulfalah.edu.pk', phone: '0300-1111111', status: 'active' },
    { id: 'TCH002', name: 'Mufti Abdur Rauf',      subject: 'Alim Course & Hadith', qualification: 'Dars-e-Nizami, Mufti', exp: '20 Years', email: 'rauf@darulfalah.edu.pk',  phone: '0300-2222222', status: 'active' },
    { id: 'TCH003', name: 'Ustaza Zainab Ansari',  subject: 'Islamic Studies',      qualification: 'M.A. Islamic Studies', exp: '10 Years', email: 'zainab@darulfalah.edu.pk', phone: '0300-3333333', status: 'active' },
    { id: 'TCH004', name: 'Ustaz Ibrahim Al-Misri',subject: 'Arabic Language',      qualification: 'B.A. Arabic Literature, Al-Azhar', exp: '12 Years', email: 'ibrahim@darulfalah.edu.pk', phone: '0300-4444444', status: 'active' },
    { id: 'TCH005', name: 'Dr. Khalid Mahmood',    subject: 'Islamic Studies',      qualification: 'PhD Islamic Studies', exp: '18 Years', email: 'khalid@darulfalah.edu.pk', phone: '0300-5555555', status: 'active' },
    { id: 'TCH006', name: 'Maulana Saeed Ahmad',   subject: 'Tafseer & Fiqh',       qualification: 'Dars-e-Nizami, Shahadat', exp: '22 Years', email: 'saeed@darulfalah.edu.pk', phone: '0300-6666666', status: 'active' },
    { id: 'TCH007', name: 'Qari Abdul Rehman',     subject: 'Tajweed & Qiraat',     qualification: 'Qari-ul-Quran, Shahadat', exp: '14 Years', email: 'rehman@darulfalah.edu.pk', phone: '0300-7777777', status: 'active' },
    { id: 'TCH008', name: 'Ustaza Maryam Farooqi', subject: 'Women Studies',        qualification: 'M.A. Islamic Studies', exp: '8 Years',  email: 'maryamf@darulfalah.edu.pk', phone: '0300-8888888', status: 'active' },
  ],

  admissions: [
    { id: 'ADM001', name: 'Hamza Sheikh',    course: 'Hifz-ul-Quran', date: '10 Mar 2025', status: 'pending',  email: 'hamza@email.com',   phone: '0301-1234567' },
    { id: 'ADM002', name: 'Sara Khan',       course: 'Tajweed',       date: '11 Mar 2025', status: 'approved', email: 'sara@email.com',    phone: '0302-2345678' },
    { id: 'ADM003', name: 'Imran Butt',      course: 'Alim Course',   date: '12 Mar 2025', status: 'pending',  email: 'imran@email.com',   phone: '0303-3456789' },
    { id: 'ADM004', name: 'Nadia Aslam',     course: 'Arabic',        date: '13 Mar 2025', status: 'rejected', email: 'nadia@email.com',   phone: '0304-4567890' },
    { id: 'ADM005', name: 'Tariq Hussain',   course: 'Islamic Studies',date: '14 Mar 2025', status: 'approved', email: 'tariq@email.com',  phone: '0305-5678901' },
    { id: 'ADM006', name: 'Amina Baig',      course: 'Quran Nazira',  date: '15 Mar 2025', status: 'pending',  email: 'amina@email.com',   phone: '0306-6789012' },
  ],

  messages: [
    { id: 'MSG001', name: 'Adeel Raza',      email: 'adeel@email.com',   subject: 'Admission Inquiry',     date: '10 Mar 2025', status: 'unread',  message: 'I would like to know more about the Hifz course admission requirements and fee structure.' },
    { id: 'MSG002', name: 'Sana Malik',      email: 'sana@email.com',    subject: 'Fee Structure Request', date: '11 Mar 2025', status: 'read',    message: 'Please provide details about the fee structure for the Tajweed course.' },
    { id: 'MSG003', name: 'Kamran Ali',      email: 'kamran@email.com',  subject: 'Hostel Facility',       date: '12 Mar 2025', status: 'unread',  message: 'Does the madrasa have a hostel facility for students coming from outside Islamabad?' },
    { id: 'MSG004', name: 'Rubina Akhtar',   email: 'rubina@email.com',  subject: 'Female Section Query',  date: '13 Mar 2025', status: 'read',    message: 'Is there a separate female section for the courses? What are the timings?' },
    { id: 'MSG005', name: 'Asif Mehmood',    email: 'asif@email.com',    subject: 'Transport Facility',    date: '14 Mar 2025', status: 'unread',  message: 'Do you provide transport facility for students living in G-9 sector?' },
  ],

  announcements: [
    { id: 'ANN001', title: 'Admission Open – Spring 2025', date: '01 Mar 2025', category: 'Admission', content: 'Applications are now open for Spring 2025 batch. Last date to apply is March 31, 2025.', status: 'active' },
    { id: 'ANN002', title: 'Monthly Test Schedule Released', date: '05 Mar 2025', category: 'Academic', content: 'Monthly assessment tests will be held from March 20–25, 2025. All students must prepare accordingly.', status: 'active' },
    { id: 'ANN003', title: 'Public Holiday – Eid-ul-Fitr', date: '08 Mar 2025', category: 'Holiday',  content: 'The madrasa will remain closed for Eid holidays from March 30 to April 5, 2025.', status: 'active' },
    { id: 'ANN004', title: 'Annual Quran Competition 2025', date: '10 Mar 2025', category: 'Event',    content: 'Annual inter-madrasa Quran recitation competition will be held on April 20, 2025. Registrations open.', status: 'active' },
  ],

  materials: [
    { id: 'MAT001', title: 'Tajweed Rules – Complete Notes',   course: 'Tajweed',         type: 'PDF',  size: '2.4 MB', date: '01 Mar 2025', icon: '📄' },
    { id: 'MAT002', title: 'Arabic Grammar Workbook Chapter 3',course: 'Arabic Language', type: 'PDF',  size: '1.8 MB', date: '05 Mar 2025', icon: '📘' },
    { id: 'MAT003', title: 'Hifz Revision Schedule – Week 12', course: 'Hifz-ul-Quran',  type: 'PDF',  size: '0.5 MB', date: '08 Mar 2025', icon: '<i class="bi bi-calendar"></i>' },
    { id: 'MAT004', title: 'Islamic Studies Test Paper',        course: 'Islamic Studies', type: 'PDF',  size: '0.9 MB', date: '10 Mar 2025', icon: '<i class="bi bi-pencil-square"></i>' },
    { id: 'MAT005', title: 'Introduction to Usool-ul-Fiqh',    course: 'Alim Course',     type: 'PDF',  size: '3.1 MB', date: '12 Mar 2025', icon: '<i class="bi bi-book"></i>' },
    { id: 'MAT006', title: 'Tafseer Ibn Kathir – Summary',     course: 'Tafseer',         type: 'PDF',  size: '4.7 MB', date: '14 Mar 2025', icon: '<i class="bi bi-file-text"></i>' },
  ]
};

/* ── UI UTILITIES ─────────────────────────────────────────── */

function showToast(message, type = 'success') {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.innerHTML = `<span>${type === 'success' ? '<i class="bi bi-check-circle-fill"></i>' : type === 'error' ? '❌' : 'ℹ️'}</span> ${message}`;
  container.appendChild(toast);
  setTimeout(() => toast.remove(), 3500);
}

function openModal(id) {
  const m = document.getElementById(id);
  if (m) { m.classList.add('show'); document.body.style.overflow = 'hidden'; }
}

function closeModal(id) {
  const m = document.getElementById(id);
  if (m) { m.classList.remove('show'); document.body.style.overflow = ''; }
}

// Close modal on overlay click
document.addEventListener('click', e => {
  if (e.target.classList.contains('modal-overlay')) {
    e.target.classList.remove('show');
    document.body.style.overflow = '';
  }
});

// Sidebar toggle
function initSidebar() {
  const toggle   = document.querySelector('.topbar-toggle');
  const sidebar  = document.querySelector('.sidebar');
  let overlay    = document.querySelector('.sidebar-overlay');

  if (!overlay) {
    overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);
  }

  if (toggle && sidebar) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('open');
      overlay.classList.remove('show');
    });
  }
}

// Animate counters
function animateCounters() {
  document.querySelectorAll('[data-count]').forEach(el => {
    const target = +el.dataset.count;
    let current  = 0;
    const step   = Math.ceil(target / 60);
    const timer  = setInterval(() => {
      current += step;
      if (current >= target) { current = target; clearInterval(timer); }
      el.textContent = current.toLocaleString();
    }, 20);
  });
}

// Confirm delete helper
function confirmDelete(message, cb) {
  if (confirm(message || 'Are you sure you want to delete this item?')) cb();
}

// Simple table search
function initTableSearch(inputSel, tableSel) {
  const input = document.querySelector(inputSel);
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.toLowerCase();
    document.querySelectorAll(`${tableSel} tbody tr`).forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

// Password Toggle
function initPasswordToggles() {
  document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
      const parent = this.closest('.password-input-wrapper');
      const input = parent ? parent.querySelector('input') : this.previousElementSibling;
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
}

document.addEventListener('DOMContentLoaded', () => {
  initSidebar();
  
  // Dynamic Bidirectional Text Support: Automatically set dir="auto" on all text inputs and textareas
  // so that when a user types Urdu or Arabic, the input field smoothly flips to Right-To-Left.
  document.querySelectorAll('input[type="text"], input[type="search"], input[type="email"], textarea').forEach(el => {
      if (!el.hasAttribute('dir')) {
          el.setAttribute('dir', 'auto');
      }
  });
  animateCounters();
  initPasswordToggles();
});
