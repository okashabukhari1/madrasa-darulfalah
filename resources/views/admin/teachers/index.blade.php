@extends('admin.layouts.app')
@section('title', 'Manage Teachers')
@section('page_title', 'Teachers List')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-person-video3"></i> Faculty Directory</h2>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-person-plus"></i> Add Teacher</a>
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
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Specialization</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr>
                    <td>
                        <div style="width:45px; height:45px; border-radius:50%; overflow:hidden; border:2px solid var(--beige-dark); background:var(--beige); display:flex; align-items:center; justify-content:center;">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <i class="bi bi-person-fill" style="color:var(--gold-dark);"></i>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">
                            {{ $teacher->name }}
                            @if($teacher->urdu_name)
                                <span dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 1.1rem; color: var(--gold); margin-left: 0.5rem;">{{ $teacher->urdu_name }}</span>
                            @endif
                        </div>
                        <small style="color:var(--text-light);">{{ $teacher->email }}</small>
                    </td>
                    <td>{{ $teacher->designation }}</td>
                    <td><span class="badge badge-gold">{{ $teacher->specialization }}</span></td>
                    <td>{{ $teacher->phone }}</td>
                    <td>
                        @if($teacher->status)
                            <span class="badge badge-green">Enabled</span>
                        @else
                            <span class="badge badge-gray">Disabled</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                            
                            <button type="button" 
                                    class="btn btn-outline btn-xs delete-teacher-btn" 
                                    style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" 
                                    title="Delete"
                                    data-id="{{ $teacher->id }}"
                                    data-name="{{ $teacher->name }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $teacher->id }}" action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-light);">No teachers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-teacher-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        if (confirm(`Are you sure you want to delete the teacher profile for "${name}"?`)) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
});
</script>
@endpush
