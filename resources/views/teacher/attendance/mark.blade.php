@extends('teacher.layouts.app')
@section('title', 'Mark Attendance')
@section('page_title', 'Mark Student Attendance')

@section('content')
<div class="db-card" style="margin-bottom:24px;">
    <div class="db-card-body" style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2 style="margin:0; color:var(--teacher-primary);">{{ $course->title }}</h2>
            <p style="margin:0; font-size:14px; color:var(--gray-500);">Marking attendance for: <strong style="color:var(--teacher-secondary);">{{ \Carbon\Carbon::parse($date)->format('l, M d, Y') }}</strong></p>
        </div>
        <div>
            <form action="{{ route('teacher.attendance.mark', $course->id) }}" method="GET" style="display:flex; gap:10px;">
                <input type="date" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
            </form>
        </div>
    </div>
</div>

<form action="{{ route('teacher.attendance.store') }}" method="POST">
    @csrf
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="db-card">
        <div class="db-card-header" style="background:#f8f9fa;">
            <h2>Enrolled Students ({{ $course->students->count() }})</h2>
            <button type="button" class="btn btn-outline btn-xs" id="markAllPresent">Mark All Present</button>
        </div>
        <div class="db-card-body" style="padding:0;">
            <table class="db-table">
                <thead>
                    <tr>
                        <th style="width:50px;">#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th style="width:300px;">Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($course->students as $index => $student)
                    @php 
                        $attendance = $existingAttendance->get($student->id);
                        $status = $attendance ? $attendance->status : 'present';
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="font-weight:600;">{{ $student->user->name ?? 'N/A' }}</div>
                            <input type="hidden" name="attendance[{{ $index }}][student_id]" value="{{ $student->id }}">
                        </td>
                        <td><code style="background:var(--gray-100); padding:2px 6px; border-radius:4px;">{{ $student->student_id }}</code></td>
                        <td>
                            <div style="display:flex; gap:10px;">
                                <label class="status-radio-label">
                                    <input type="radio" name="attendance[{{ $index }}][status]" value="present" {{ $status === 'present' ? 'checked' : '' }} class="status-present">
                                    <span class="status-btn">Present</span>
                                </label>
                                <label class="status-radio-label">
                                    <input type="radio" name="attendance[{{ $index }}][status]" value="absent" {{ $status === 'absent' ? 'checked' : '' }} class="status-absent">
                                    <span class="status-btn">Absent</span>
                                </label>
                                <label class="status-radio-label">
                                    <input type="radio" name="attendance[{{ $index }}][status]" value="late" {{ $status === 'late' ? 'checked' : '' }} class="status-late">
                                    <span class="status-btn">Late</span>
                                </label>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="attendance[{{ $index }}][notes]" value="{{ $attendance ? $attendance->notes : '' }}" class="form-control" placeholder="Optional notes..." style="height:32px; font-size:12px;">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:30px;">No students enrolled in this course.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="db-card-footer" style="padding:20px; text-align:right; border-top:1px solid var(--gray-200);">
            <a href="{{ route('teacher.attendance') }}" class="btn btn-outline btn-sm">Cancel</a>
            <button type="submit" class="btn btn-gold btn-sm" style="min-width:150px;">Save Attendance</button>
        </div>
    </div>
</form>

<style>
    .status-radio-label {
        cursor: pointer;
        flex: 1;
    }
    .status-radio-label input {
        display: none;
    }
    .status-btn {
        display: block;
        padding: 5px 12px;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        text-align: center;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
        background: white;
    }
    .status-radio-label input:checked + .status-btn {
        color: white;
        border-color: transparent;
    }
    .status-radio-label input[value="present"]:checked + .status-btn { background: #198754; box-shadow: 0 2px 4px rgba(25,135,84,0.3); }
    .status-radio-label input[value="absent"]:checked + .status-btn { background: #dc3545; box-shadow: 0 2px 4px rgba(220,53,69,0.3); }
    .status-radio-label input[value="late"]:checked + .status-btn { background: #ffc107; color: #000; box-shadow: 0 2px 4px rgba(255,193,7,0.3); }
    
    .status-radio-label:hover .status-btn {
        border-color: var(--teacher-secondary);
    }
</style>

@push('scripts')
<script>
    document.getElementById('markAllPresent').addEventListener('click', function() {
        document.querySelectorAll('.status-present').forEach(radio => {
            radio.checked = true;
        });
    });
</script>
@endpush
@endsection
