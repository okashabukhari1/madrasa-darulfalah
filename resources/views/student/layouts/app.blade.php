<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'My Dashboard') — Student Portal | Madrasa Dar-ul-Falah</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @stack('styles')
</head>
<body>
<div class="db-wrapper">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo" style="display: flex; align-items: center; gap: 10px; padding: 1rem;">
      <img src="{{ asset('images/logo.png') }}" alt="Dar-ul-Falah Logo" style="height: 45px; width: auto; object-fit: contain;">
      <div class="logo-text"><h2>Dar-ul-Falah</h2><span>Student Portal</span></div>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">My Portal</div>
      <a class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" href="{{ route('student.dashboard') }}"><span class="nav-icon"><i class="bi bi-house"></i></span> Dashboard</a>
      <a class="nav-item {{ request()->routeIs('student.courses*') ? 'active' : '' }}" href="{{ route('student.courses') }}"><span class="nav-icon"><i class="bi bi-book"></i></span> My Courses</a>
      <a class="nav-item {{ request()->routeIs('student.attendance*') ? 'active' : '' }}" href="{{ route('student.attendance') }}"><span class="nav-icon"><i class="bi bi-calendar-check"></i></span> My Attendance</a>
      <a class="nav-item {{ request()->routeIs('student.exams*') ? 'active' : '' }}" href="{{ route('student.exams.index') }}"><span class="nav-icon"><i class="bi bi-award"></i></span> My Exams & Eval.</a>
      <a class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}" href="{{ route('student.profile') }}"><span class="nav-icon"><i class="bi bi-person"></i></span> My Profile</a>
      <a class="nav-item {{ request()->routeIs('student.materials') ? 'active' : '' }}" href="{{ route('student.materials') }}"><span class="nav-icon"><i class="bi bi-file-earmark-text"></i></span> Study Materials</a>
      <a class="nav-item {{ request()->routeIs('student.announcements') ? 'active' : '' }}" href="{{ route('student.announcements') }}"><span class="nav-icon"><i class="bi bi-megaphone"></i></span> Announcements</a>
      <div class="nav-section-label">More</div>
      <a class="nav-item" href="{{ route('home') }}" target="_blank"><span class="nav-icon"><i class="bi bi-globe"></i></span> Madrasa Website</a>
      <a class="nav-item" href="{{ route('contact') }}" target="_blank"><span class="nav-icon"><i class="bi bi-envelope"></i></span> Contact Us</a>
    </nav>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="s-avatar" id="sAvatar"><i class="bi bi-person-circle"></i></div>
        <div class="s-info"><span id="studentName">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span><small id="studentId">{{ \Illuminate\Support\Facades\Auth::user()->student->student_id ?? 'N/A' }}</small></div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
        </form>
        <button class="btn-logout" onclick="document.getElementById('logout-form').submit();" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
      </div>
    </div>
  </aside>

  <div class="main-content">
    <header class="topbar">
      <button class="topbar-toggle"><i class="bi bi-list"></i></button>
      <div class="topbar-title">@yield('page_title', 'Student Dashboard')</div>
      <div class="topbar-actions">
        <a href="{{ route('student.announcements') }}" class="topbar-btn" title="My Announcements">
            <i class="bi bi-bell"></i>
            <span class="notif-dot"></span>
        </a>
        <a href="{{ route('student.profile') }}" class="topbar-avatar" title="My Profile" id="topAvatar">
            <i class="bi bi-person-circle"></i>
        </a>
      </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div style="background: var(--green-light); color: var(--green); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: rgba(220,53,69,0.1); color: #dc3545; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
  </div>
</div>

<script src="{{ asset('js/dashboard.js') }}?v={{ time() }}"></script>
@stack('scripts')
</body>
</html>
