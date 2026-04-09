@extends('admin.layouts.app')
@section('title', 'Edit Announcement')
@section('page_title', 'Update Notification')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Edit Details</h2>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-outline btn-sm">Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.announcements.update', $announcement->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Announcement Title*</label>
                <input type="text" name="title" value="{{ old('title', $announcement->title) }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Audience Type*</label>
                    <select name="type" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="all" {{ $announcement->type == 'all' ? 'selected' : '' }}>Everyone (Public)</option>
                        <option value="student" {{ $announcement->type == 'student' ? 'selected' : '' }}>Students Only</option>
                        <option value="teacher" {{ $announcement->type == 'teacher' ? 'selected' : '' }}>Teachers Only</option>
                        <option value="both" {{ $announcement->type == 'both' ? 'selected' : '' }}>Both Students & Teachers</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Expiry Date (Optional)</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at', $announcement->expires_at ? $announcement->expires_at->format('Y-m-d') : '') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Content / Message*</label>
                <textarea name="content" rows="6" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ old('content', $announcement->content) }}</textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" {{ $announcement->is_active ? 'checked' : '' }} value="1"> 
                    <span style="font-weight: 600;">Active / Published</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2.5rem;">Update Announcement</button>
            </div>
        </form>
    </div>
</div>
@endsection

