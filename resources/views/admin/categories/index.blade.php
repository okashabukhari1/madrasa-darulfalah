@extends('admin.layouts.app')
@section('title', 'Category Management')
@section('page_title', 'Course & Student Categories')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-tags"></i> All Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> Add Category</a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="padding: 1rem; background: rgba(229,62,62,0.1); color: #e53e3e; border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Courses</th>
                    <th>Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">{{ $category->name }}</div>
                        <small style="color:var(--text-light);">{{ Str::limit($category->description, 50) }}</small>
                    </td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td><span class="badge badge-blue">{{ $category->courses_count }}</span></td>
                    <td><span class="badge badge-gold">{{ $category->students_count }}</span></td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                            
                            <button type="button" 
                                    class="btn btn-outline btn-xs delete-category-btn" 
                                    style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" 
                                    title="Delete"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No categories found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-category-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        if (confirm(`Are you sure you want to delete the category "${name}"? This will affect courses linked to it.`)) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
});
</script>
@endpush
