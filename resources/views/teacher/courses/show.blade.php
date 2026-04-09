@extends('teacher.layouts.app')
@section('title', $course->title)
@section('page_title', 'Course Details')

@section('content')
<div class="db-card" style="margin-bottom:24px; background: linear-gradient(to right, #ffffff, #f8f9fa);">
    <div class="db-card-body" style="display:flex; justify-content:space-between; align-items:flex-start; gap:24px;">
        <div style="flex:1;">
            <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                <span class="badge badge-gold">{{ $course->category->name ?? 'General' }}</span>
                <span class="badge badge-blue">Level: {{ $course->level }}</span>
            </div>
            <h1 style="margin:0 0 12px 0; font-family:'Playfair Display',serif; color:var(--teacher-primary); font-size:32px;">{{ $course->title }}</h1>
            <p style="color:var(--gray-600); margin:0; line-height:1.6;">{{ $course->description }}</p>
        </div>
        <div style="width:250px; background:white; padding:15px; border-radius:12px; border:1px solid var(--gray-200); box-shadow:0 4px 6px rgba(0,0,0,0.02);">
            <div style="text-align:center; margin-bottom:15px;">
                <div style="font-size:12px; color:var(--gray-500); margin-bottom:4px;">Students Enrolled</div>
                <div style="font-size:28px; font-weight:800; color:var(--teacher-secondary);">{{ $course->students_count }}</div>
            </div>
            <a href="{{ route('teacher.attendance.mark', $course->id) }}" class="btn btn-gold w-100"><i class="bi bi-calendar-check"></i> Mark Attendance</a>
        </div>
    </div>
</div>

<div class="grid-2">
    <!-- Student List -->
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-people"></i> Enrolled Students</h2>
        </div>
        <div class="db-card-body" style="padding:0;">
            <div class="item-list">
                @forelse($students as $student)
                    <div class="list-item" style="padding: 12px 20px;">
                        <div class="list-item-icon" style="background:var(--gray-100); color:var(--teacher-secondary);"><i class="bi bi-person"></i></div>
                        <div class="list-item-content">
                            <div class="list-item-title">{{ $student->user->name ?? 'N/A' }}</div>
                            <div class="list-item-meta">ID: {{ $student->student_id }} · Status: <span style="color:var(--green);">Active</span></div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 20px; text-align: center; color: var(--gray-500);">No students enrolled.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Attendance Logs -->
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-journal-text"></i> Recent Attendance Logs</h2>
            <a href="{{ route('teacher.attendance.history', ['course_id' => $course->id]) }}" class="btn btn-outline btn-xs">Full History</a>
        </div>
        <div class="db-card-body" style="padding:0;">
            <div class="item-list">
                @forelse($recentAttendance as $date => $logs)
                <div class="list-item" style="padding: 12px 20px;">
                    <div class="list-item-icon" style="background:var(--gold-light); color:var(--brown);"><i class="bi bi-calendar3"></i></div>
                    <div class="list-item-content">
                        <div class="list-item-title">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</div>
                        <div class="list-item-meta">{{ $logs->count() }} records found</div>
                    </div>
                    <div>
                        <a href="{{ route('teacher.attendance.mark', ['course_id' => $course->id, 'date' => $date]) }}" class="btn btn-outline btn-xs">Edit</a>
                    </div>
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: var(--gray-500);">No logs found for this course.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
