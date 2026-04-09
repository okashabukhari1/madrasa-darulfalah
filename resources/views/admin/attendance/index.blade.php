@extends('admin.layouts.app')
@section('title', 'Manage Attendance')
@section('page_title', 'All Attendance Records')

@section('content')
<div class="db-card" style="margin-bottom: 2rem;">
    <div class="db-card-body">
        <form action="{{ route('admin.attendance.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: flex-end;">
            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Filter by Date</label>
                <input type="date" name="date" value="{{ request('date') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
            </div>
            
            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Program</label>
                <select name="program" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    <option value="">All Programs</option>
                    <option value="hifz" {{ request('program') == 'hifz' ? 'selected' : '' }}>Hifz</option>
                    <option value="nazra" {{ request('program') == 'nazra' ? 'selected' : '' }}>Nazra</option>
                    <option value="qaida" {{ request('program') == 'qaida' ? 'selected' : '' }}>Qaida</option>
                </select>
            </div>

            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Teacher</label>
                <select name="teacher_id" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 1.5rem;">Filter</button>
                <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline" style="padding: 0.75rem 1.5rem;">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="db-card">
    <div class="db-card-body" style="padding: 0;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Program</th>
                    <th>Course (Legacy)</th>
                    <th>Student Name</th>
                    <th>ID</th>
                    <th>Teacher</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                <tr>
                    <td>{{ $att->date->format('M d, Y') }}</td>
                    <td><span class="badge badge-blue">{{ ucfirst($att->student->program ?? 'N/A') }}</span></td>
                    <td>{{ $att->course->title ?? 'No Course' }}</td>
                    <td>{{ $att->student->user->name ?? 'Unknown' }}</td>
                    <td><code style="background:var(--gray-100); padding:2px 4px; border-radius:4px;">{{ $att->student->student_id }}</code></td>
                    <td>{{ $att->teacher->name }}</td>
                    <td>
                        <span class="badge badge-{{ $att->status === 'present' ? 'green' : ($att->status === 'absent' ? 'red' : 'gold') }}">
                            {{ ucfirst($att->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.attendance.destroy', $att->id) }}" method="POST" onsubmit="return confirm('Delete this record?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:red; background:none; border:none; cursor:pointer;" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding: 40px; color: var(--gray-500);">No attendance records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="padding: 1.5rem;">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
