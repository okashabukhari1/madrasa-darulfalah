@extends('admin.layouts.app')
@section('title', 'Add New Teacher')
@section('page_title', 'Add Faculty Member')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-plus"></i> Teacher Profile</h2>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Name (English)</label>
                    <input type="text" name="name" value="{{ old('name') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>

                <div class="form-group">
                    <label class="urdu-font" style="display:block; margin-bottom:0.5rem; font-weight:600; text-align: right; font-size: 1.1rem;">(Urdu) مکمل نام</label>
                    <input type="text" name="urdu_name" value="{{ old('urdu_name') }}" dir="rtl" class="urdu-font" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-size: 1.2rem;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Designation*</label>
                    <input type="text" name="designation" placeholder="e.g. Head of Hifz" value="{{ old('designation') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Specialization*</label>
                    <input type="text" name="specialization" placeholder="e.g. Tajweed, Fiqh (comma separated)" value="{{ old('specialization') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Email Address*</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Professional Qualification</label>
                    <input type="text" name="qualification" placeholder="e.g. MA Islamic Studies" value="{{ old('qualification') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Years of Experience (Numeric)</label>
                    <input type="text" name="experience" placeholder="e.g. 10" value="{{ old('experience') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Password*</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" name="password" required style="width:100%; padding:0.75rem 2.5rem 0.75rem 0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <button type="button" class="password-toggle" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Confirm Password*</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" name="password_confirmation" required style="width:100%; padding:0.75rem 2.5rem 0.75rem 0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <button type="button" class="password-toggle" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Short Bio</label>
                <textarea name="bio" rows="4" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">{{ old('bio') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Profile Photo</label>
                <input type="file" name="photo" style="width:100%; padding:0.5rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                <small style="color:var(--text-light)">Max size: 2MB. Square aspect ratio recommended.</small>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="status" checked value="1"> 
                    <span style="font-weight: 600;">Profile Active / Visible on Website</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Save Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection


