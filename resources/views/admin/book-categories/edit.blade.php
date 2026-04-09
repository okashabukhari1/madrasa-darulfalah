@extends('admin.layouts.app')
@section('title', 'Edit Category: ' . $bookCategory->name)
@section('page_title', 'Library Management')

@section('content')
<div class="db-card reveal" style="max-width: 800px; margin: 0 auto;">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin:0; color: var(--primary); font-family: 'Playfair Display', serif;">Edit Category</h3>
            <p style="margin:0; font-size: 0.85rem; color: var(--text-light);">Modify classification for <strong>{{ $bookCategory->name }}</strong></p>
        </div>
        <a href="{{ route('admin.book-categories.index') }}" class="btn btn-outline" style="font-size: 0.85rem;">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.book-categories.update', $bookCategory->slug) }}" method="POST" style="padding: 2rem;">
        @csrf
        @method('PUT')
        
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="form-group">
                <label>Category Name <span style="color:red;">*</span></label>
                <input type="text" name="name" value="{{ old('name', $bookCategory->name) }}" class="form-control" placeholder="e.g., Hadith Sciences" required>
                @error('name') <span style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Slug (Unique Identifier)</label>
                <input type="text" value="{{ $bookCategory->slug }}" class="form-control" disabled style="background: var(--gray-50); cursor: not-allowed;">
                <small style="color: var(--text-light);">Slugs cannot be changed after creation.</small>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Briefly describe what this category includes...">{{ old('description', $bookCategory->description) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; height: 50px;">
                    <i class="bi bi-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.book-categories.index') }}" class="btn btn-outline" style="flex: 0.5; display: flex; align-items: center; justify-content: center;">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
