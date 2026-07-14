<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard') — Madrasa Dar-ul-Falah</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    @font-face {
        font-family: 'Jameel Noori Nastaleeq';
        src: url('https://cdn.jsdelivr.net/gh/m-m-m-a/UrduFont@main/JameelNooriNastaleeq.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
        font-display: swap;
    }
    .urdu-font {
        font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif !important;
    }
  </style>
  @stack('styles')
</head>
<body>
<div class="db-wrapper">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-logo" style="display: flex; align-items: center; gap: 10px; padding: 1rem;">
      <img src="{{ asset('images/logo.png') }}" alt="Dar-ul-Falah Logo" style="height: 45px; width: auto; object-fit: contain;">
      <div class="logo-text">
        <h2>Dar-ul-Falah</h2>
        <span>Admin Panel</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Main</div>
      <a class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span class="nav-icon"><i class="bi bi-speedometer2"></i></span> Dashboard</a>
      <a class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" href="{{ route('admin.students.index') }}"><span class="nav-icon"><i class="bi bi-mortarboard"></i></span> Students</a>
      <a class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}"><span class="nav-icon"><i class="bi bi-book"></i></span> Courses</a>
      <a class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><span class="nav-icon"><i class="bi bi-tags"></i></span> Categories</a>
      <a class="nav-item {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}" href="{{ route('admin.teachers.index') }}"><span class="nav-icon"><i class="bi bi-person-video3"></i></span> Teachers</a>
      <a class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><span class="nav-icon"><i class="bi bi-people-fill"></i></span> User Management</a>

      <div class="nav-section-label">Management</div>
      <a class="nav-item {{ request()->routeIs('admin.progress-logs.*') ? 'active' : '' }}" href="{{ route('admin.progress-logs.index') }}"><span class="nav-icon"><i class="bi bi-journal-text"></i></span> Progress Logs</a>
      <a class="nav-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}" href="{{ route('admin.exams.index') }}"><span class="nav-icon"><i class="bi bi-award"></i></span> Exams & Eval.</a>
      <a class="nav-item {{ request()->routeIs('admin.admissions.*') ? 'active' : '' }}" href="{{ route('admin.admissions.index') }}"><span class="nav-icon"><i class="bi bi-clipboard-data"></i></span> Admissions</a>
      <a class="nav-item {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}"><span class="nav-icon"><i class="bi bi-images"></i></span> Gallery</a>
      <a class="nav-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}" href="{{ route('admin.messages.index') }}"><span class="nav-icon"><i class="bi bi-envelope"></i></span> Messages</a>
      <a class="nav-item {{ request()->routeIs('admin.books.*') ? 'active' : '' }}" href="{{ route('admin.books.index') }}"><span class="nav-icon"><i class="bi bi-journal-bookmark-fill"></i></span> Library (Books)</a>
      <a class="nav-item {{ request()->routeIs('admin.book-categories.*') ? 'active' : '' }}" href="{{ route('admin.book-categories.index') }}"><span class="nav-icon"><i class="bi bi-tags"></i></span> Book Categories</a>
      <a class="nav-item {{ request()->routeIs('admin.fees.*') ? 'active' : '' }}" href="{{ route('admin.fees.dashboard') }}"><span class="nav-icon"><i class="bi bi-cash-coin"></i></span> Fees & Finance</a>
      <a class="nav-item {{ request()->routeIs('admin.salaries.*') ? 'active' : '' }}" href="{{ route('admin.salaries.dashboard') }}"><span class="nav-icon"><i class="bi bi-wallet2"></i></span> Teacher Salaries</a>
      <a class="nav-item {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}"><span class="nav-icon"><i class="bi bi-megaphone"></i></span> Announcements</a>
      <a class="nav-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}"><span class="nav-icon"><i class="bi bi-calendar-event"></i></span> Upcoming Events</a>
      <a class="nav-item {{ request()->routeIs('admin.management.*') ? 'active' : '' }}" href="{{ route('admin.management.index') }}"><span class="nav-icon"><i class="bi bi-people"></i></span> Staff Management</a>
      <a class="nav-item {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}"><span class="nav-icon"><i class="bi bi-calendar-check"></i></span> Attendance Management</a>

      <div class="nav-section-label">Settings</div>
      <a class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><span class="nav-icon"><i class="bi bi-gear"></i></span> Settings</a>
      <a class="nav-item" href="{{ route('home') }}" target="_blank"><span class="nav-icon"><i class="bi bi-globe"></i></span> View Website</a>
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="s-avatar"><i class="bi bi-person-circle"></i></div>
        <div class="s-info">
          <span>{{ \Illuminate\Support\Facades\Auth::user()->name ?? 'Admin' }}</span>
          <small>Administrator</small>
        </div>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
        </form>
        <button class="btn-logout" onclick="document.getElementById('logout-form').submit();" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main-content">
    <header class="topbar">
      <button class="topbar-toggle"><i class="bi bi-list"></i></button>
      <div class="topbar-title">@yield('page_title', 'Dashboard Overview')</div>
      <div class="topbar-search-placeholder" style="flex: 1;"></div>
      <div class="topbar-actions">
        <a href="{{ route('admin.announcements.index') }}" class="topbar-btn" title="Notifications">
            <span><i class="bi bi-bell"></i></span>
            <span class="notif-dot"></span>
        </a>
        <a href="{{ route('admin.settings.index') }}" class="topbar-avatar" title="Settings & Profile">
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

        @if($errors->any())
            <div style="background: rgba(220,53,69,0.1); color: #dc3545; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500;">
                <ul style="margin: 0; padding-left: 1.25rem;">
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
