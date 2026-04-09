@extends('student.layouts.app')
@section('title', 'My Profile')
@section('page_title', 'Student Profile')

@section('content')
<div class="db-card" style="max-width:800px;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-badge"></i> My Profile Settings</h2>
    </div>
    <div class="db-card-body" style="padding:2rem;">
        <form action="{{ route('student.profile.update') }}" method="POST">
            @csrf
            <div style="display:flex; gap:2rem; align-items:flex-start; margin-bottom:2rem; border-bottom:1px solid var(--beige-dark); padding-bottom:2rem;">
                <div style="width:120px; height:120px; border-radius:15px; background:var(--beige); border:3px solid var(--gold); display:flex; align-items:center; justify-content:center; font-size:4rem; color:var(--gold-dark); overflow:hidden;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <i class="bi bi-person-fill"></i>
                    @endif
                </div>
                <div style="flex:1;">
                    <div style="margin-bottom:1rem;">
                        <label style="display:block; font-size:0.8rem; color:var(--text-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:0.3rem;">Student ID (Read Only)</label>
                        <input type="text" value="{{ auth()->user()->student->student_id }}" disabled style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:rgba(212,175,55,0.1); font-weight:700; color:var(--gold-dark);">
                    </div>
                    <span class="badge badge-green">Enrolled Student</span>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; margin-bottom:2rem;">
                <div>
                    <label style="display:block; font-size:0.8rem; color:var(--text-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:0.3rem;">Full Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--beige);">
                </div>
                <div>
                    <label style="display:block; font-size:0.8rem; color:var(--text-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:0.3rem;">Father Name</label>
                    <input type="text" name="father_name" value="{{ auth()->user()->student->father_name }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--beige);">
                </div>
                <div>
                    <label style="display:block; font-size:0.8rem; color:var(--text-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:0.3rem;">Phone Number</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--beige);">
                </div>
                <div>
                    <label style="display:block; font-size:0.8rem; color:var(--text-light); text-transform:uppercase; letter-spacing:1px; margin-bottom:0.3rem;">Date of Birth</label>
                    <input type="date" name="dob" value="{{ auth()->user()->student->dob ? auth()->user()->student->dob->format('Y-m-d') : '' }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--beige);">
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-gold" style="padding:0.75rem 2rem; font-weight:700;">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection
