@extends('admin.layouts.app')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<!-- Welcome banner -->
<div class="welcome-banner">
<div>
    <h2 id="welcomeMsg">Welcome back, {{ explode(' ', \Illuminate\Support\Facades\Auth::user()->name ?? 'Admin')[0] }}!</h2>
    <p>Here's what's happening at Madrasa Dar-ul-Falah today.</p>
</div>
<div class="wb-actions">
    <a href="#" class="btn btn-gold btn-sm"><i class="bi bi-clipboard-data"></i> New Admissions</a>
    <a href="{{ route('admin.students.index') }}" class="btn btn-outline btn-sm" style="color:#fff;border-color:rgba(255,255,255,.4);"><i class="bi bi-people"></i> Students</a>
</div>
</div>

<!-- Stats -->
<div class="stats-grid">
<div class="stat-card green">
    <div class="stat-icon"><i class="bi bi-mortarboard"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ $stats['total_students'] ?? 0 }}">0</h3>
    <p>Total Students</p>
    <div class="stat-change up"><i class="bi bi-arrow-up"></i> active learners</div>
    </div>
</div>
<div class="stat-card blue">
    <div class="stat-icon"><i class="bi bi-book"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ $stats['hifz_students'] ?? 0 }}">0</h3>
    <p>Hifz Students</p>
    <div class="stat-change up">Memorization</div>
    </div>
</div>
<div class="stat-card gold">
    <div class="stat-icon"><i class="bi bi-clipboard-data"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ $stats['pending_adm'] ?? 0 }}">0</h3>
    <p>Pending Admissions</p>
    <div class="stat-change up">Awaiting review</div>
    </div>
</div>
<div class="stat-card purple">
    <div class="stat-icon"><i class="bi bi-person-video3"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ $stats['total_teachers'] ?? 0 }}">0</h3>
    <p>Teachers</p>
    <div class="stat-change up">Active faculty</div>
    </div>
</div>
<div class="stat-card orange">
    <div class="stat-icon"><i class="bi bi-envelope"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ $stats['unread_messages'] ?? 0 }}">0</h3>
    <p>Unread Messages</p>
    <div class="stat-change down">Check inbox</div>
    </div>
</div>
<div class="stat-card red">
    <div class="stat-icon"><i class="bi bi-award"></i></div>
    <div class="stat-info">
    <h3 data-count="{{ ($stats['total_students'] ?? 0) + 1200 }}">0</h3>
    <p>Total Graduates</p>
    <div class="stat-change up">All-time</div>
    </div>
</div>
</div>

<!-- Grid row -->
<div class="grid-2" style="align-items: start; margin-bottom:24px;">

  <!-- LEFT COLUMN -->
  <div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Recent Admissions -->
    <div class="db-card">
        <div class="db-card-header">
        <h2><i class="bi bi-clipboard-pulse"></i> Recent Admissions</h2>
        <a href="{{ route('admin.admissions.index') }}" class="btn btn-outline btn-xs">View All</a>
        </div>
        <div class="table-wrap">
        <table id="recentAdmTable">
            <thead>
            <tr><th>Name</th><th>Course</th><th>Date</th><th>Status</th></tr>
            </thead>
            <tbody>
                @if(isset($recentAdmissions) && count($recentAdmissions) > 0)
                    @foreach($recentAdmissions as $admission)
                    <tr>
                        <td>{{ $admission->name }}</td>
                        <td>{{ $admission->course->title ?? 'N/A' }}</td>
                        <td>{{ $admission->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($admission->status === 'approved')
                                <span class="badge badge-green">Approved</span>
                            @elseif($admission->status === 'rejected')
                                <span class="badge badge-red">Rejected</span>
                            @else
                                <span class="badge badge-gold">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" style="text-align: center; color: var(--text-light);">No recent admissions</td></tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>

    <!-- Course Enrollment (Legacy) -->
    <div class="db-card">
        <div class="db-card-header">
        <h2><i class="bi bi-bar-chart"></i> Course Enrollment</h2>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline btn-xs">Manage</a>
        </div>
        <div class="db-card-body">
        <div class="chart-bar-group" id="enrollChart">
            @if(isset($coursesData) && count($coursesData) > 0)
                @php $maxStudents = $coursesData->max('students_count') ?: 1; @endphp
                @foreach($coursesData as $kc => $course)
                <div class="chart-bar-row">
                    <div class="chart-bar-label" title="{{ $course->title }}">{{ \Illuminate\Support\Str::words($course->title, 2, '...') }}</div>
                    <div class="chart-bar-track">
                        <div class="chart-bar-fill {{ $kc % 2 == 0 ? '' : 'gold' }}" style="width:{{ round(($course->students_count / $maxStudents) * 100) }}%"></div>
                    </div>
                    <div class="chart-bar-val">{{ $course->students_count }}</div>
                </div>
                @endforeach
            @endif
        </div>
        </div>
    </div>

    <!-- Announcements -->
    <div class="db-card">
        <div class="db-card-header">
        <h2><i class="bi bi-megaphone"></i> Announcements</h2>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline btn-xs">Manage</a>
        </div>
        <div class="item-list" id="annList">
            @if(isset($recentAnnouncements) && count($recentAnnouncements) > 0)
                @foreach($recentAnnouncements as $ann)
                <div class="list-item">
                    <div class="list-item-icon" style="background:var(--blue-light,var(--gray-100))"><i class="bi bi-bell"></i></div>
                    <div class="list-item-content">
                        <div class="list-item-title">{{ $ann->title }}</div>
                        <div class="list-item-meta">{{ $ann->created_at->format('M d, Y') }} · 
                            @if($ann->type === 'all')
                                <span class="badge badge-blue">Everyone</span>
                            @elseif($ann->type === 'student')
                                <span class="badge badge-gold">Students</span>
                            @else
                                <span class="badge badge-green">Teachers</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div style="padding: 1rem; text-align: center; color: var(--text-light);">No recent announcements</div>
            @endif
        </div>
    </div>

  </div>

  <!-- RIGHT COLUMN -->
  <div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Recent Progress Logs -->
    <div class="db-card">
        <div class="db-card-header">
        <h2><i class="bi bi-journal-check"></i> Recent Progress</h2>
        <a href="{{ route('admin.progress-logs.index') }}" class="btn btn-outline btn-xs">View All</a>
        </div>
        <div class="table-wrap">
        <table id="recentProgTable">
            <thead>
            <tr><th>Student</th><th>Program</th><th>Teacher</th><th>Lesson</th></tr>
            </thead>
            <tbody>
                @if(isset($recentProgress) && count($recentProgress) > 0)
                    @foreach($recentProgress as $log)
                    <tr>
                        <td><strong>{{ $log->student->user->name ?? 'Unknown' }}</strong></td>
                        <td><small>{{ ucfirst($log->student->program) }}</small></td>
                        <td>{{ $log->teacher->name ?? 'N/A' }}</td>
                        <td>
                            @if($log->para) P{{ $log->para }} @endif
                            @if($log->surah) {{ $log->surah }} @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="4" style="text-align: center; color: var(--text-light);">No recent progress logs</td></tr>
                @endif
            </tbody>
        </table>
        </div>
    </div>

    <!-- Recent Students -->
    <div class="db-card">
        <div class="db-card-header">
        <h2><i class="bi bi-mortarboard"></i> Recent Students</h2>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline btn-xs">View All</a>
        </div>
        <div class="item-list" id="recentStudList">
            @if(isset($recentStudents) && count($recentStudents) > 0)
                @foreach($recentStudents as $k => $student)
                <div class="list-item">
                    <div class="list-item-icon" style="background:var(--green-light)"><i class="bi bi-person-fill"></i></div>
                    <div class="list-item-content">
                        <div class="list-item-title">{{ $student->user->name ?? 'Unknown' }}</div>
                        <div class="list-item-meta">{{ $student->student_id }} · {{ ucfirst($student->program) }}</div>
                    </div>
                    <span class="badge badge-{{ $student->status === 'active' ? 'green' : 'gray' }}">{{ ucfirst($student->status) }}</span>
                </div>
                @endforeach
            @else
                <div style="padding: 1rem; text-align: center; color: var(--text-light);">No recent students</div>
            @endif
        </div>
    </div>

  </div>
</div>
@endsection
