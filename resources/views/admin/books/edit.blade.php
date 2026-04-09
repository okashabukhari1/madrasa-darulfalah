@extends('admin.layouts.app')
@section('title', 'Edit Book: ' . $book->title)
@section('page_title', 'Library Management')

@section('content')
<div class="db-card reveal">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="margin:0; color: var(--primary); font-family: 'Playfair Display', serif;">Modify Resource</h3>
            <p style="margin:0; font-size: 0.85rem; color: var(--text-light);">Update details for <strong>{{ $book->title }}</strong></p>
        </div>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline" style="font-size: 0.85rem;">
            <i class="bi bi-arrow-left"></i> Back to Collection
        </a>
    </div>

    <form action="{{ route('admin.books.update', $book->slug) }}" method="POST" enctype="multipart/form-data" style="padding: 2rem;">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem;">
            <!-- Main Content -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="form-group">
                    <label>Book Title <span style="color:red;">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $book->title) }}" class="form-control" placeholder="e.g., Al-Aqeedah At-Tahawiyyah" required>
                    @error('title') <span style="color:red; font-size: 0.8rem;">{{ $message }}</span> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" value="{{ old('author', $book->author) }}" class="form-control" placeholder="e.g., Imam at-Tahawi">
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select name="book_category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Provide a brief summary of the book content...">{{ old('description', $book->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label>External Download Link (Optional)</label>
                    <input type="url" name="external_link" value="{{ old('external_link', $book->external_link) }}" class="form-control" placeholder="e.g., https://archive.org/details/book-name">
                    <small style="color: var(--text-light);">If provided, this link will be used instead of the uploaded file.</small>
                </div>
            </div>

            <!-- Sidebar / Uploads -->
            <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--gray-100); display: flex; flex-direction: column; gap: 1.5rem;">
                
                <div class="form-group">
                    <label>Cover Image</label>
                    @if($book->cover_image)
                    <div style="margin-bottom: 1rem; width: 100px; height: 140px; border-radius: 8px; overflow: hidden; border: 1px solid var(--gray-200);">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endif
                    <input type="file" name="cover_image" class="form-control" accept="image/*" style="padding: 0.5rem;">
                    <small style="color: var(--text-light);">Leave empty to keep current image</small>
                </div>

                <div class="form-group" style="padding: 1rem; background: var(--white); border-radius: 8px; border: 1px dashed var(--gold);">
                    <label style="color: var(--primary);"><i class="bi bi-file-earmark-arrow-up"></i> Replace Book File</label>
                    @if($book->file_path)
                        <div style="font-size: 0.8rem; margin-bottom: 0.5rem; color: var(--green); font-weight: 500;">
                            <i class="bi bi-check-circle-fill"></i> Current file: {{ $book->file_path }}
                        </div>
                    @endif
                    <input type="file" name="book_file" class="form-control" accept=".pdf,.doc,.docx,.epub" style="padding: 0.5rem; margin-top: 0.5rem;">
                    <small style="display: block; margin-top: 0.5rem; color: var(--text-light);">MAX size: 20MB. Leave empty to keep existing.</small>
                </div>

                <div style="margin-top: 0.5rem; display: flex; flex-direction: column; gap: 0.8rem;">
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <input type="checkbox" name="is_featured" id="is_featured" {{ old('is_featured', $book->is_featured) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--gold);">
                        <label for="is_featured" style="margin:0; cursor: pointer; font-weight: 500;">Feature on Library Home</label>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.8rem;">
                        <input type="checkbox" name="status" id="status" {{ old('status', $book->status) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                        <label for="status" style="margin:0; cursor: pointer; font-weight: 500;">Publish to Public Website</label>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.8rem; margin-top: 1rem;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; height: 50px;">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.books.index') }}" class="btn btn-outline" style="text-align: center;">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
