@extends('teacher.layouts.app')
@section('title', 'My Courses')
@section('page_title', 'Assigned Courses')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-journal-text"></i> All Assigned Courses</h2>
    </div>
    <div class="db-card-body" style="padding:0;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Course Title</th>
                    <th>Category</th>
                    <th>Students</th>
                    <th>Level</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--teacher-primary);">{{ $course->title }}</div>
                        <div style="font-size:12px; color:var(--gray-500);">Duration: {{ $course->duration }}</div>
                    </td>
                    <td><span class="badge badge-blue">{{ $course->category->name ?? 'N/A' }}</span></td>
                    <td><span style="font-weight:700;">{{ $course->students_count }}</span> Students</td>
                    <td>{{ $course->level }}</td>
                    <td class="text-right">
                        <div style="display:flex; gap:8px; justify-content:flex-end;">
                            <a href="{{ route('teacher.courses.show', $course->slug) }}" class="btn btn-outline btn-xs">View Details</a>
                            <a href="{{ route('teacher.attendance.mark', $course->id) }}" class="btn btn-gold btn-xs"><i class="bi bi-calendar-check"></i> Mark Attendance</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:30px; color:var(--gray-500);">No courses assigned to you yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($courses->count() > 0)
        <div style="padding:20px;">
            {{ $courses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
