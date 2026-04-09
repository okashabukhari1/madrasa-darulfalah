@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('page_title', 'Update Account: ' . $user->name)

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Update User Details</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2.5rem;">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Name*</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('name') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Email Address*</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('email') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+92 300 1234567" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('phone') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Account Role*</label>
                    <select name="role" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>General User</option>
                        <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                        <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                    </select>
                    @error('role') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div style="background: rgba(229,190,131,0.08); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px dashed var(--beige-dark);">
                <h4 style="margin-bottom: 1rem; font-size: 1rem; color: var(--primary);"><i class="bi bi-shield-lock"></i> Security Update</h4>
                <p style="margin-bottom: 1.5rem; font-size: 0.85rem; color: var(--text-light);">Leave password fields empty to keep the existing password.</p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">New Password</label>
                        <input type="password" name="password" placeholder="New password" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        @error('password') <small style="color:#dc3545;">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat new password" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    </div>
                </div>
            </div>

            <div style="background: var(--beige-light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--beige-dark);">
                <label style="display: flex; align-items: center; gap: 0.8rem; cursor: pointer;">
                    <input type="checkbox" name="status" value="1" {{ old('status', $user->status) ? 'checked' : '' }} style="width: 1.2rem; height: 1.2rem; accent-color: var(--primary);">
                    <div>
                        <span style="font-weight: 700; color: var(--primary);">Account Status: Active</span>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-light);">Uncheck to suspend this user's system access.</p>
                    </div>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.8rem 2.5rem; font-weight: 700;">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
