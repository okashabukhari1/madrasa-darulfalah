@extends('admin.layouts.app')
@section('title', 'Edit Category')
@section('page_title', 'Update Category: ' . $category->name)

@section('content')
<div class="db-card" style="max-width: 600px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Modify Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline btn-sm">Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Category Name*</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                @error('name') <small style="color:#e53e3e">{{ $message }}</small> @enderror
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Description (Optional)</label>
                <textarea name="description" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">{{ old('description', $category->description) }}</textarea>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
