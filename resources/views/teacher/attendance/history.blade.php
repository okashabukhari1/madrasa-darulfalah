@extends('teacher.layouts.app')
@section('title', 'Attendance History')
@section('page_title', 'Attendance Reports')

@section('content')
<div class="db-card" style="margin-bottom:24px;">
    <div class="db-card-body">
        <form action="{{ route('teacher.attendance.history') }}" method="GET" class="grid-3" style="align-items:flex-end; gap:15px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:var(--gray-600); margin-bottom:5px;">Filter by Course</label>
                <select name="course_id" class="form-control" style="width:100%;">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:var(--gray-600); margin-bottom:5px;">Filter by Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="form-control" style="width:100%;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn btn-gold btn-sm"><i class="bi bi-filter"></i> Filter</button>
                <a href="{{ route('teacher.attendance.history') }}" class="btn btn-outline btn-sm">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="db-card">
    <div class="db-card-header">
        <h2>History Records</h2>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-outline btn-xs"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
            <button class="btn btn-outline btn-xs"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
        </div>
    </div>
    <div class="db-card-body" style="padding:0;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Course</th>
                    <th>Student Name</th>
                    <th>Status</th>
                    <th>Notes</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td><strong>{{ $att->date->format('M d, Y') }}</strong></td>
                    <td><span style="font-size:13px; color:var(--gray-600);">{{ $att->course->title }}</span></td>
                    <td>
                        <div style="font-weight:600;">{{ $att->student->user->name ?? 'N/A' }}</div>
                        <div style="font-size:11px; color:var(--gray-500);">ID: {{ $att->student->student_id }}</div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $att->status === 'present' ? 'green' : ($att->status === 'absent' ? 'red' : 'gold') }}">
                            {{ ucfirst($att->status) }}
                        </span>
                    </td>
                    <td><small style="color:var(--gray-500);">{{ $att->notes ?: '—' }}</small></td>
                    <td class="text-right">
                        <a href="{{ route('teacher.attendance.mark', ['course_id' => $att->course_id, 'date' => $att->date->format('Y-m-d')]) }}" class="btn btn-outline btn-xs">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:var(--gray-500);">No attendance records found for the selected criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="padding:20px;">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
