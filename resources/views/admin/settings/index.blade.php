@extends('admin.layouts.app')
@section('title', 'System Settings')
@section('page_title', 'Configure Madrasa CMS')

@section('content')
<div style="max-width: 900px; margin: 0 auto;">
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin-bottom: 2rem; border: 1px solid rgba(26,107,60,0.2);">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <!-- General Identity -->
        <div class="db-card" style="margin-bottom: 2rem;">
            <div class="db-card-header">
                <h3><i class="bi bi-gear"></i> General Identity</h3>
            </div>
            <div class="db-card-body" style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Institution Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Madrasa Dar-ul-Falah' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Site Baseline / Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Excellence in Islamic Education' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Footer Copyright Text</label>
                    <input type="text" name="footer_text" value="{{ $settings['footer_text'] ?? '© 2025 Madrasa Dar-ul-Falah. All rights reserved.' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="db-card" style="margin-bottom: 2rem;">
            <div class="db-card-header">
                <h3><i class="bi bi-headset"></i> Contact & Communication</h3>
            </div>
            <div class="db-card-body" style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Official Phone</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '+92 300 1234567' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Official Email</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'info@darulfalah.com' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Office Address</label>
                    <textarea name="contact_address" rows="2" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">{{ $settings['contact_address'] ?? 'Street 10, Sector F-8, Islamabad, Pakistan' }}</textarea>
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Working Hours</label>
                    <input type="text" name="office_hours" value="{{ $settings['office_hours'] ?? 'Mon - Sat: 8:00 AM - 4:00 PM' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                </div>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="db-card" style="margin-bottom: 2rem;">
            <div class="db-card-header">
                <h3><i class="bi bi-share"></i> Social Connect</h3>
            </div>
            <div class="db-card-body" style="padding: 2rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Facebook URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/..." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/..." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">YouTube URL</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/..." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Twitter (X) URL</label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="https://twitter.com/..." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align: right; margin-top: 2rem;">
            <button type="submit" class="btn btn-gold" style="padding: 1rem 3rem; font-size: 1.1rem;">
                <i class="bi bi-save"></i> Save All Settings
            </button>
        </div>
    </form>
</div>
@endsection
