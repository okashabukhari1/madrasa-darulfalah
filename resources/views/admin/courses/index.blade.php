@extends('admin.layouts.app')
@section('title', 'Manage Courses')
@section('page_title', 'Courses List')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-book"></i> All Courses</h2>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-journal-plus"></i> Add Course</a>
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
                    <th>Image</th>
                    <th>Title</th>
                    <th>Teacher</th>
                    <th>Fee</th>
                    <th>Students</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <div style="width:50px; height:50px; border-radius:8px; overflow:hidden; background:var(--beige); display:flex; align-items:center; justify-content:center;">
                            @if($course->image)
                                <img src="{{ asset('storage/' . $course->image) }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="bi bi-book" style="color:var(--gold-dark); font-size:1.5rem;"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">{{ $course->title }}</div>
                        <small style="color:var(--text-light);">{{ $course->category->name ?? 'Uncategorized' }}</small>
                    </td>
                    <td>
                        <div>{{ $course->teacher->name ?? 'N/A' }}</div>
                        @if(isset($course->teacher->urdu_name))
                            <small dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', serif; color: var(--gold-dark); display: block;">{{ $course->teacher->urdu_name }}</small>
                        @endif
                    </td>
                    <td>{{ $course->fee > 0 ? '$' . number_format($course->fee, 2) : 'Free' }}</td>
                    <td><span class="badge badge-blue">{{ $course->students_count ?? 0 }} Enrolled</span></td>
                    <td>
                        @if($course->status)
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-gray">Draft</span>
                        @endif
                        @if($course->is_featured)
                            <span class="badge badge-gold" title="Featured"><i class="bi bi-star-fill"></i></span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                            
                            <button type="button" 
                                    class="btn btn-outline btn-xs delete-course-btn" 
                                    style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" 
                                    title="Delete"
                                    data-id="{{ $course->id }}"
                                    data-title="{{ $course->title }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $course->id }}" action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-light);">No courses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-course-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const title = this.getAttribute('data-title');
        if (confirm(`Are you sure you want to delete the course "${title}"?`)) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
});
</script>
@endpush
