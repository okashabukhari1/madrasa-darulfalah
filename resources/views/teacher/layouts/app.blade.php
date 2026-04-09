<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Teacher Dashboard') — Teacher Portal | Madrasa Dar-ul-Falah</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
      --teacher-primary: #1b4332;
      --teacher-secondary: #2d6a4f;
    }
    .sidebar.teacher-theme {
      background: linear-gradient(180deg, var(--teacher-primary) 0%, var(--teacher-secondary) 100%);
    }
  </style>
  @stack('styles')
</head>
<body>
<div class="db-wrapper">

  <!-- SIDEBAR -->
  <aside class="sidebar teacher-theme" id="sidebar">
    <div class="sidebar-logo" style="display: flex; align-items: center; gap: 10px; padding: 1rem;">
      <img src="{{ asset('images/logo.png') }}" alt="Dar-ul-Falah Logo" style="height: 45px; width: auto; object-fit: contain;">
      <div class="logo-text"><h2>Dar-ul-Falah</h2><span>Teacher Portal</span></div>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-section-label">Main Menu</div>
      <a class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}" href="{{ route('teacher.dashboard') }}">
        <span class="nav-icon"><i class="bi bi-speedometer2"></i></span> Dashboard
      </a>
      <div class="nav-section-label">Academic Work</div>
      <a class="nav-item {{ request()->routeIs('teacher.progress.index') ? 'active' : '' }}" href="{{ route('teacher.progress.index') }}">
        <span class="nav-icon"><i class="bi bi-calendar-check"></i></span> Daily Progress
      </a>
      <a class="nav-item {{ request()->routeIs('teacher.progress.history') ? 'active' : '' }}" href="{{ route('teacher.progress.history') }}">
        <span class="nav-icon"><i class="bi bi-journal-text"></i></span> Progress History
      </a>
      <a class="nav-item {{ request()->routeIs('teacher.exams.*') ? 'active' : '' }}" href="{{ route('teacher.exams.index') }}">
        <span class="nav-icon"><i class="bi bi-award"></i></span> Exams & Eval.
      </a>

      <div class="nav-section-label">More</div>
      <a class="nav-item {{ request()->routeIs('teacher.announcements*') ? 'active' : '' }}" href="{{ route('teacher.announcements') }}">
        <span class="nav-icon"><i class="bi bi-megaphone-fill"></i></span> Announcements
      </a>
      <a class="nav-item" href="{{ route('home') }}" target="_blank"><span class="nav-icon"><i class="bi bi-globe"></i></span> Madrasa Website</a>
    </nav>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="s-avatar" style="background: var(--gold); color: var(--teacher-primary);"><i class="bi bi-person-badge"></i></div>
        <div class="s-info">
            <span>{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
            <small>Faculty Account</small>
        </div>
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
      <div class="topbar-title">@yield('page_title', 'Teacher Dashboard')</div>
      <div class="topbar-actions">
        <div class="topbar-badge" style="background: var(--gold-light); color: var(--brown); padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
            <i class="bi bi-shield-check"></i> Verified Faculty
        </div>
        <a href="{{ route('teacher.announcements') }}" class="topbar-btn" title="Announcements">
            <i class="bi bi-bell"></i>
        </a>
        <a href="{{ route('profile.edit') }}" class="topbar-avatar" title="My Profile" style="margin-left: 10px; color: var(--text-dark); font-size: 1.4rem;">
            <i class="bi bi-person-circle"></i>
        </a>
      </div>
    </header>

    <main class="page-content">
        @if(session('success'))
            <div style="background: #d1e7dd; color: #0f5132; padding: 1rem; border-radius: 12px; margin-bottom: 20px; border: 1px solid #badbcc; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background: rgba(220,53,69,0.1); border-left: 4px solid #dc3545; color: #dc3545; padding: 1rem; border-radius: 4px; margin-bottom: 20px;">
                <strong style="margin-bottom: 5px; display: block;">Please check the following errors:</strong>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
