@extends('admin.layouts.app')
@section('title', 'Add Staff Member')
@section('page_title', 'New Admin User')

@section('content')
<div class="db-card" style="max-width: 600px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-plus"></i> Staff Details</h2>
        <a href="{{ route('admin.management.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.management.store') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Name*</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Email Address*</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Password*</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <input type="password" name="password" required style="width:100%; padding:0.75rem 2.5rem 0.75rem 0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    <button type="button" class="password-toggle" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <small style="color:var(--text-light)">Minimum 8 characters.</small>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Create Staff Account</button>
            </div>
        </form>
    </div>
</div>
@endsection
