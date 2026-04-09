@extends('teacher.layouts.app')
@section('title', 'Mark Attendance')
@section('page_title', 'Attendance Management')

@section('content')
<div class="welcome-banner" style="background: var(--teacher-secondary); margin-bottom: 24px;">
    <div>
        <h2>Daily Attendance Tracking</h2>
        <p>Select a course below to mark or update student attendance records.</p>
    </div>
</div>

<div class="grid-2">
    @forelse($courses as $course)
    <div class="db-card">
        <div class="db-card-body">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:20px;">
                <div style="width:50px; height:50px; border-radius:12px; background:var(--gold-light); color:var(--brown); display:flex; align-items:center; justify-content:center; font-size:24px;">
                    <i class="bi bi-book"></i>
                </div>
                <div style="flex:1;">
                    <h3 style="margin:0; font-family:'Playfair Display',serif; color:var(--teacher-primary);">{{ $course->title }}</h3>
                    <p style="margin:0; font-size:13px; color:var(--gray-500);">{{ $course->students_count }} Enrolled Students</p>
                </div>
            </div>
            
            <form action="{{ route('teacher.attendance.mark', $course->id) }}" method="GET">
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:var(--gray-600); margin-bottom:5px;">Select Date</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control" style="width:100%;">
                </div>
                <button type="submit" class="btn btn-gold w-100">
                    <i class="bi bi-calendar-check"></i> Mark Attendance
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="db-card" style="grid-column: span 2;">
        <div class="db-card-body" style="text-align:center; padding:40px;">
            <i class="bi bi-journal-x" style="font-size:48px; color:var(--gray-300);"></i>
            <p style="color:var(--gray-600); margin-top:15px;">You don't have any assigned courses to mark attendance for.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
