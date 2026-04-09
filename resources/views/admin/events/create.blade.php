@extends('admin.layouts.app')
@section('title', 'New Event')
@section('page_title', 'Schedule Event')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-calendar-plus"></i> Event Details</h2>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Event Title / Topic*</label>
                <input type="text" name="title" value="{{ old('title') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">
                @error('title')<div style="color:#e53e3e; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                <small style="color:var(--text-light);">Supports English or Urdu text.</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Event Date & Time*</label>
                    <input type="datetime-local" name="event_date" value="{{ old('event_date') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('event_date')<div style="color:#e53e3e; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Location / Venue</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="e.g., Main Hall, Zoom, etc." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('location')<div style="color:#e53e3e; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Description / Information*</label>
                <textarea name="description" rows="6" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ old('description') }}</textarea>
                @error('description')<div style="color:#e53e3e; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                <small style="color:var(--text-light);">Supports English or Urdu text.</small>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_active" checked value="1"> 
                    <span style="font-weight: 600;">Active / Visible on Website</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2.5rem;">Schedule Event</button>
            </div>
        </form>
    </div>
</div>
@endsection

