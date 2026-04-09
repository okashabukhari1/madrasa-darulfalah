@extends('admin.layouts.app')

@section('title', 'Add New User')
@section('page_title', 'Create User Account')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-plus"></i> New User Details</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2.5rem;">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Name*</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Abdullah Khan" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('name') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Email Address*</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('email') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+92 300 1234567" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('phone') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Account Role*</label>
                    <select name="role" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>General User (Default)</option>
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Password*</label>
                    <input type="password" name="password" required placeholder="Min 8 characters" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('password') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Confirm Password*</label>
                    <input type="password" name="password_confirmation" required placeholder="Repeat password" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
            </div>

            <div style="background: var(--beige-light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--beige-dark);">
                <label style="display: flex; align-items: center; gap: 0.8rem; cursor: pointer;">
                    <input type="checkbox" name="status" value="1" checked style="width: 1.2rem; height: 1.2rem; accent-color: var(--primary);">
                    <div>
                        <span style="font-weight: 700; color: var(--primary);">Account Status: Active</span>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-light);">Uncheck to temporarily disable this user's access.</p>
                    </div>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.8rem 2.5rem; font-weight: 700;">
                    <i class="bi bi-check-circle"></i> Create User Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
