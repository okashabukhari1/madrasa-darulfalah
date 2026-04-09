<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Madrasa Dar-ul-Falah - Islamic Education')</title>
<meta name="description" content="@yield('meta_description', 'Madrasa Dar-ul-Falah is a specialized institute for Islamic education offering Hifz, Nazra, and Qaida programs.')">
<meta name="keywords" content="@yield('meta_keywords', 'Madrasa, Hifz, Nazra, Qaida, Islamic Education, Quran, Dar-ul-Falah')">
@yield('meta')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Lato:wght@300;400;700&family=Scheherazade+New:wght@400;700&display=swap" rel="stylesheet">
<style>
    @font-face {
        font-family: 'Jameel Noori Nastaleeq';
        src: url('https://cdn.jsdelivr.net/gh/m-m-m-a/UrduFont@main/JameelNooriNastaleeq.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    .urdu-font {
        font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
    }
</style>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@stack('styles')
</head>
<body>

<!-- Loading Screen -->
<div id="loading-screen">
  <div class="loader-logo">مدرسہ دار الفلاح </div>
  <div class="loader-text">Madrasa Dar-ul-Falah</div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
</div>

<!-- Navigation -->
<nav class="navbar" id="navbar">
  <div class="navbar-inner">
    <a href="{{ route('home') }}" class="nav-logo" style="display: flex; align-items: center; gap: 10px;">
      <img src="{{ asset('images/logo.png') }}" alt="Dar-ul-Falah Logo" style="height: 55px; width: auto; object-fit: contain;">
      <div class="nav-logo-text">
        <span class="name">Dar-ul-Falah</span>
        <span class="tagline">Institute of Islamic Education</span>
      </div>
    </a>
    <div class="nav-links">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
      <a href="{{ route('courses') }}" class="{{ request()->routeIs('courses') ? 'active' : '' }}">Courses</a>
      <a href="{{ route('teachers') }}" class="{{ request()->routeIs('teachers') ? 'active' : '' }}">Teachers</a>
      <a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}">Gallery</a>
      <a href="{{ route('books') }}" class="{{ request()->routeIs('books') ? 'active' : '' }}">Library</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
      <div style="width:1px;height:20px;background:rgba(255,255,255,0.2);margin:0 0.5rem"></div>
      
      <a href="{{ route('admission') }}" class="nav-cta">Apply Now</a>
      
      @auth
        <div style="display: flex; align-items: center; gap: 15px;">
          @if(auth()->user()->role === 'user')
            <a href="{{ route('profile.edit') }}" class="nav-cta" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark))!important; color: white !important;">Profile</a>
          @else
            <a href="{{ route('dashboard') }}" class="nav-cta" style="background:linear-gradient(135deg, var(--gold), var(--gold-dark))!important; color: white !important;">Dashboard</a>
          @endif
          
          <form method="POST" action="{{ route('logout') }}" id="logout-form-nav" style="display: none;">
              @csrf
          </form>
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();" style="color: var(--white); font-size: 1.2rem; display: flex; align-items: center;" title="Logout">
            <i class="bi bi-box-arrow-right"></i>
          </a>
        </div>
      @else
        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
      @endauth
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
<div class="mobile-menu" id="mobile-menu">
  <a href="{{ route('home') }}">Home</a>
  <a href="{{ route('about') }}">About</a>
  <a href="{{ route('courses') }}">Courses</a>
  <a href="{{ route('teachers') }}">Teachers</a>
  <a href="{{ route('gallery') }}">Gallery</a>
  <a href="{{ route('books') }}">Library</a>
  <a href="{{ route('contact') }}">Contact</a>
  <a href="{{ route('admission') }}">Apply Now</a>
  @auth
    @if(auth()->user()->role === 'user')
      <a href="{{ route('profile.edit') }}" style="color: var(--gold-light);">Profile</a>
    @else
      <a href="{{ route('dashboard') }}" style="color: var(--gold-light);">Dashboard</a>
    @endif
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();" style="color: var(--red);">Logout</a>
  @else
    <a href="{{ route('login') }}">Login</a>
  @endauth
</div>

@yield('content')

<!-- Footer -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand">
      <div class="footer-logo-wrap" style="align-items: center;">
        <img src="{{ asset('images/logo.png') }}" alt="Dar-ul-Falah Logo" style="height: 50px; width: auto; object-fit: contain;">
        <div>
          <div class="footer-brand-name">Dar-ul-Falah</div>
          <div class="footer-brand-tag">Islamic Institute</div>
        </div>
      </div>
      <p class="footer-about">Madrasa Dar-ul-Falah has been nurturing Islamic scholars and producing Huffaz since 1995. We are committed to excellence in Islamic education.</p>
      <div class="footer-socials">
        <a href="#" class="footer-social">f</a>
        <a href="#" class="footer-social">t</a>
        <a href="#" class="footer-social">in</a>
        <a href="#" class="footer-social">yt</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Quick Links</h4>
      <div class="footer-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('courses') }}">Courses</a>
        <a href="{{ route('teachers') }}">Teachers</a>
        <a href="{{ route('gallery') }}">Gallery</a>
        <a href="{{ route('contact') }}">Contact</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Programs</h4>
      <div class="footer-links">
        <a href="{{ route('courses') }}">Hifz-ul-Quran</a>
        <a href="{{ route('courses') }}">Tajweed</a>
        <a href="{{ route('courses') }}">Alim Course</a>
        <a href="{{ route('courses') }}">Arabic Language</a>
        <a href="{{ route('courses') }}">Islamic Studies</a>
        <a href="{{ route('admission') }}">Admissions</a>
      </div>
    </div>
    <div class="footer-col">
      <h4>Contact Info</h4>
      <div class="footer-contact-item"><span class="ico"><i class="bi bi-geo-alt"></i></span><span>Street Number 11, Haji Mureed Goth Firdous Colony, Karachi, 74600, Pakistan</span></div>
      <div class="footer-contact-item"><span class="ico"><i class="bi bi-telephone"></i></span><span>+92 315 2214175</span></div>
      <div class="footer-contact-item"><span class="ico"><i class="bi bi-envelope"></i></span><span>[EMAIL_ADDRESS]</span></div>
      <div class="footer-contact-item"><span class="ico"><i class="bi bi-clock"></i></span><span>Mon–Sat: 7:00 AM – 6:00 PM</span></div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2025 Madrasa Dar-ul-Falah. All rights reserved.</span>
    <span style="color:rgba(255,255,255,0.25)">|</span>
    <div style="display:flex;gap:1rem">
      <a href="{{ route('admin.dashboard') }}" style="color:rgba(255,255,255,0.3);font-size:.8rem">Admin</a>
      <a href="{{ route('login') }}" style="color:rgba(255,255,255,0.3);font-size:.8rem">Student Portal</a>
    </div>
  </div>
</footer>

<button id="back-to-top" title="Back to top"><i class="bi bi-arrow-up"></i></button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/three-animation.js') }}"></script>
@stack('scripts')
</body>
</html>
