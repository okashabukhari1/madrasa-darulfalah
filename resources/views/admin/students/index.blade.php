@extends('admin.layouts.app')
@section('title', 'Manage Students')
@section('page_title', 'Students List')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-people"></i> All Students</h2>
        <a href="{{ route('admin.students.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-person-plus"></i> Add Student</a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name / Email</th>
                    <th>Teacher</th>
                    <th>Course (Legacy)</th>
                    <th>Program</th>
                    <th>Guardian Info</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td style="font-weight:600; color:var(--primary);">{{ $student->student_id }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <div style="width:32px; height:32px; border-radius:50%; background:var(--beige); display:flex; align-items:center; justify-content:center; color:var(--gold-dark); font-weight:bold;">
                                {{ substr($student->user->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600;">{{ $student->user->name ?? 'Unknown' }}</div>
                                @if($student->urdu_name)
                                    <div class="urdu-font" dir="rtl" style="font-size: 0.9rem; color: var(--gold-dark); margin-top: 2px;">{{ $student->urdu_name }}</div>
                                @endif
                                <span style="font-size:0.8rem; color:var(--gray-500);">{{ $student->user->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $student->teacher->name ?? 'Unassigned' }}</div>
                        @if(isset($student->teacher->urdu_name))
                            <small class="urdu-font" dir="rtl" style="font-size: 0.85rem; color: var(--gold-dark); display: block; margin-top: 2px;">{{ $student->teacher->urdu_name }}</small>
                        @endif
                    </td>
                    <td>
                        @if($student->courses->count() > 0)
                            @php $course = $student->courses->first(); @endphp
                            <div style="font-size:0.85rem;">{{ $course->title }}</div>
                            @if($course->urdu_title)
                                <small class="urdu-font" dir="rtl" style="font-size: 0.8rem; color: var(--gold-dark); display: block; margin-top: 2px;">{{ $course->urdu_title }}</small>
                            @endif
                        @else
                            <span class="text-muted" style="font-size:0.8rem;">No Course</span>
                        @endif
                    </td>
                    <td><span class="badge badge-gray" style="background:rgba(186,152,93,0.1); color:var(--gold-dark);">{{ ucfirst($student->program) }}</span></td>
                    <td>
                        {{ $student->guardian_name ?? 'N/A' }}<br>
                        <span style="font-size:0.8rem; color:var(--gray-500);">{{ $student->guardian_phone ?? 'N/A' }}</span>
                    </td>
                    <td>
                        @if($student->status === 'active')
                            <span class="badge badge-green">Active</span>
                        @elseif($student->status === 'graduated')
                            <span class="badge badge-gold">Graduated</span>
                        @else
                            <span class="badge badge-gray">{{ ucfirst($student->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $student->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-outline btn-xs" style="padding:0.25rem 0.5rem;" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form id="delete-student-{{ $student->id }}" action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" 
                                    class="btn btn-outline btn-xs" 
                                    style="padding:0.25rem 0.5rem; color:#e53e3e; border-color:rgba(229,62,62,0.3);" 
                                    title="Delete"
                                    onclick="if(confirm('Are you sure you want to delete this student and their user account?')) document.getElementById('delete-student-{{ $student->id }}').submit();">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-light);">
                        <i class="bi bi-people" style="font-size: 2rem; color: var(--beige-dark); display: block; margin-bottom: 0.5rem;"></i>
                        No students found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($students->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--beige-dark);">
        {{ $students->links() }}
    </div>
    @endif
</div>
@endsection
