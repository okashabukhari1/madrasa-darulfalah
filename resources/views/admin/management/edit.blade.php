@extends('admin.layouts.app')
@section('title', 'Edit Staff Member')
@section('page_title', 'Update Admin: ' . $member->name)

@section('content')
<div class="db-card" style="max-width: 600px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Update Details</h2>
        <a href="{{ route('admin.management.index') }}" class="btn btn-outline btn-sm">Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.management.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Name*</label>
                <input type="text" name="name" value="{{ old('name', $member->name) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Email Address*</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Password (Leave blank to keep current)</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <input type="password" name="password" style="width:100%; padding:0.75rem 2.5rem 0.75rem 0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    <button type="button" class="password-toggle" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small style="color:var(--text-light)">Minimum 8 characters if provided.</small>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Update Staff Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
