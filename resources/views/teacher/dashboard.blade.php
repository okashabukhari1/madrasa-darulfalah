@extends('teacher.layouts.app')
@section('title', 'Teacher Dashboard')
@section('page_title', 'Faculty Dashboard')

@section('content')
<!-- Welcome banner -->
<div class="welcome-banner" style="background: linear-gradient(135deg, var(--teacher-primary), var(--teacher-secondary));">
    <div style="flex:1;">
        <h2>As-salamu Alaykum, {{ explode(' ', $teacher->name)[0] }}!</h2>
        <p>Managed by Madrasa Dar-ul-Falah Personnel Division</p>
    </div>
    <div class="wb-actions">
        <a href="{{ route('teacher.progress.index') }}" class="btn btn-gold btn-sm"><i class="bi bi-calendar-check"></i> Manage Daily Progress</a>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card blue">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div class="stat-info"><h3>{{ $stats['total_students'] }}</h3><p>Total Students</p></div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon"><i class="bi bi-book"></i></div>
        <div class="stat-info"><h3>{{ $stats['hifz_students'] }}</h3><p>Hifz Students</p></div>
    </div>
    <div class="stat-card gold">
        <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
        <div class="stat-info"><h3>{{ $stats['nazra_students'] + $stats['qaida_students'] }}</h3><p>Nazra / Qaida</p></div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
        <div class="stat-info"><h3>{{ $stats['attendance_rate'] }}%</h3><p>Today's Attendance</p></div>
    </div>
</div>

<div class="grid-2" style="align-items: start;">

  <!-- LEFT COLUMN -->
  <div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Assigned Students -->
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-person-lines-fill"></i> My Assigned Students</h2>
        </div>
        <div class="db-card-body" style="padding:0;">
            <div class="item-list">
                @forelse($assignedStudents as $student)
                <div class="list-item" style="padding: 15px 20px;">
                    <div class="list-item-icon" style="background: var(--teacher-secondary); color: white;"><i class="bi bi-person"></i></div>
                    <div class="list-item-content">
                        <div class="list-item-title">{{ $student->user->name ?? 'Unknown' }}</div>
                        <div class="list-item-meta">{{ ucfirst($student->program) }} · ID: {{ $student->student_id }}</div>
                    </div>
                    <div>
                        <a href="{{ route('teacher.progress.index') }}" class="btn btn-gold btn-xs"><i class="bi bi-pencil-square"></i> Progress</a>
                    </div>
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: var(--gray-500);">No students assigned yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Latest Announcements -->
    <div class="db-card">
        <div class="db-card-header" style="justify-content: space-between;">
            <h2><i class="bi bi-megaphone"></i> Latest Announcements</h2>
            <span class="badge badge-gold">{{ $announcements->count() }} New</span>
        </div>
        <div class="db-card-body" style="padding:0;">
            <div class="item-list">
                @forelse($announcements as $ann)
                <div class="list-item" style="padding: 20px; flex-direction: column; align-items: flex-start; gap: 10px; {{ !$loop->last ? 'border-bottom: 1px solid #eee;' : '' }}">
                    <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                        <span style="font-size: 0.75rem; color: var(--gold-dark); font-weight: 700; text-transform: uppercase;">
                            {{ $ann->created_at->format('M d, Y') }} · {{ ucfirst($ann->type) }}
                        </span>
                    </div>
                    
                    <div style="width: 100%;">
                        <h4 style="margin: 0 0 5px; color: var(--text-dark); font-size: 1.1rem; text-align: auto; font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ $ann->title }}</h4>
                        <p style="margin: 0; font-size: 0.95rem; color: var(--text-light); line-height: 1.5; text-align: auto; font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ Str::limit($ann->content, 150) }}</p>
                    </div>
                </div>
                @empty
                <div style="padding: 30px; text-align: center; color: var(--gray-500);">No recent announcements.</div>
                @endforelse
            </div>
        </div>
    </div>

  </div>

  <!-- RIGHT COLUMN -->
  <div style="display: flex; flex-direction: column; gap: 24px;">

    <!-- Recent Attendance -->
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-clock-history"></i> Recent Attendance</h2>
            <a href="{{ route('teacher.progress.history') }}" class="btn btn-outline btn-xs">History</a>
        </div>
        <div class="db-card-body" style="padding:0;">
            <div class="item-list">
                @forelse($recentAttendances as $att)
                <div class="list-item" style="padding: 15px 20px;">
                    <div class="list-item-icon" style="background: {{ $att->status === 'present' ? '#d1e7dd' : ($att->status === 'absent' ? '#f8d7da' : '#fff3cd') }}; color: {{ $att->status === 'present' ? '#0f5132' : ($att->status === 'absent' ? '#842029' : '#664d03') }};">
                        <i class="bi bi-{{ $att->status === 'present' ? 'check-circle' : ($att->status === 'absent' ? 'x-circle' : 'exclamation-circle') }}"></i>
                    </div>
                    <div class="list-item-content">
                        <div class="list-item-title">{{ $att->student->user->name ?? 'Unknown' }}</div>
                        <div class="list-item-meta">{{ ucfirst($att->student->program) }} · {{ $att->date->format('M d, Y') }}</div>
                    </div>
                    <span class="badge badge-{{ $att->status === 'present' ? 'green' : ($att->status === 'absent' ? 'red' : 'gold') }}">
                        {{ ucfirst($att->status) }}
                    </span>
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: var(--gray-500);">No attendance marked yet.</div>
                @endforelse
            </div>
        </div>
    </div>

  </div>
</div>
@endsection


