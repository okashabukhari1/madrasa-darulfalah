@extends('admin.layouts.app')
@section('title', 'Upload Gallery Image')
@section('page_title', 'Add to Gallery')

@section('content')
<div class="db-card" style="max-width: 600px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-cloud-upload"></i> Upload Details</h2>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Image Title*</label>
                <input type="text" name="title" value="{{ old('title') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Category*</label>
                <select name="category" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    <option value="Events">Events</option>
                    <option value="Campus">Campus</option>
                    <option value="Classes">Classes</option>
                    <option value="Graduation">Graduation</option>
                    <option value="Activities">Activities</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Select Image*</label>
                <input type="file" name="image" required style="width:100%; padding:0.5rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                <small style="color:var(--text-light)">Max size: 3MB. Formats: JPG, PNG, WEBP.</small>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Description (Optional)</label>
                <textarea name="description" rows="3" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="status" checked value="1"> 
                    <span style="font-weight: 600;">Visible in Public Gallery</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Upload Image</button>
            </div>
        </form>
    </div>
</div>
@endsection
