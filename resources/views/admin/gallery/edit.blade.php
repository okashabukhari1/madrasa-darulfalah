@extends('admin.layouts.app')
@section('title', 'Edit Gallery Item')
@section('page_title', 'Edit Media: ' . $image->title)

@section('content')
<div class="db-card" style="max-width: 600px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Update Media Details</h2>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline btn-sm">Back to Gallery</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.gallery.update', $image->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Image Title*</label>
                <input type="text" name="title" value="{{ old('title', $image->title) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Category*</label>
                <select name="category" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @php $cats = ['Events', 'Campus', 'Classes', 'Graduation', 'Activities']; @endphp
                    @foreach($cats as $cat)
                        <option value="{{ $cat }}" {{ (old('category', $image->category) == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Replace Image</label>
                <div style="margin-bottom: 0.5rem;">
                    <img src="{{ asset('storage/' . $image->image) }}" alt="" style="width:200px; border-radius:8px; border:1px solid var(--beige-dark);">
                </div>
                <input type="file" name="image" style="width:100%; padding:0.5rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                <small style="color:var(--text-light)">Leave empty to keep current image. Max size: 3MB.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Description (Optional)</label>
                <textarea name="description" rows="3" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">{{ old('description', $image->description) }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="status" {{ old('status', $image->status) ? 'checked' : '' }} value="1"> 
                    <span style="font-weight: 600;">Visible in Public Gallery</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Update Item</button>
            </div>
        </form>
    </div>
</div>
@endsection
