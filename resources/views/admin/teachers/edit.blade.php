@extends('admin.layouts.app')
@section('title', 'Edit Teacher')
@section('page_title', 'Edit Faculty: ' . $teacher->name)

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil-square"></i> Update Teacher Profile</h2>
        <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline btn-sm">Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2.5rem;">
        <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Section: Identity -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Full Name (English - Optional)</label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white); focus:outline:none; focus:border-color:var(--gold);">
                </div>

                <div class="form-group">
                    <label class="urdu-font" style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 1.1rem; text-align: right;">مکمل نام (Urdu)*</label>
                    <input type="text" name="urdu_name" value="{{ old('urdu_name', $teacher->urdu_name) }}" dir="rtl" class="urdu-font" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white); font-size: 1.2rem;">
                </div>
            </div>

            <!-- Section: Professional Info -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Designation*</label>
                    <input type="text" name="designation" placeholder="e.g. Head of Hifz" value="{{ old('designation', $teacher->designation) }}" required style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Specialization*</label>
                    <input type="text" name="specialization" placeholder="e.g. Tajweed, Fiqh" value="{{ old('specialization', $teacher->specialization) }}" required style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>
            </div>

            <!-- Section: Education & Experience -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Professional Qualification</label>
                    <input type="text" name="qualification" placeholder="e.g. MA Islamic Studies" value="{{ old('qualification', $teacher->qualification) }}" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Years of Experience (Numeric)</label>
                    <input type="text" name="experience" placeholder="e.g. 10" value="{{ old('experience', $teacher->experience) }}" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>
            </div>

            <!-- Section: Contact & Security -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Email Address*</label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" placeholder="e.g. 0300-1234567" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">New Password</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" name="password" placeholder="Leave blank to keep" style="width:100%; padding:0.85rem 2.8rem 0.85rem 0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                        <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-400); cursor: pointer; font-size: 1.1rem;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Confirm Password</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" name="password_confirmation" placeholder="Leave blank to keep" style="width:100%; padding:0.85rem 2.8rem 0.85rem 0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white);">
                        <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-400); cursor: pointer; font-size: 1.1rem;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section: Bio & Media -->
            <div style="display: grid; grid-template-columns: 3fr 2fr; gap: 2rem; margin-bottom: 2rem; align-items: start;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Short Bio / Description</label>
                    <textarea name="bio" rows="7" style="width:100%; padding:0.85rem; border:1px solid var(--beige-dark); border-radius:10px; background:var(--white); resize: vertical; line-height:1.6;">{{ old('bio', $teacher->bio) }}</textarea>
                </div>

                <div class="form-group" style="text-align: center;">
                    <label style="display:block; margin-bottom:0.6rem; font-weight:700; color:var(--primary-dark); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Profile Photo</label>
                    <div style="background: var(--gray-50); border: 1px dashed var(--beige-dark); border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                        <div style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--gold); overflow: hidden; background: white; box-shadow: var(--shadow-sm);">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="" style="width:100%; height:100%; object-fit: cover;">
                            @else
                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:var(--beige); color:var(--gold); font-size:2.5rem;"><i class="bi bi-person"></i></div>
                            @endif
                        </div>
                        <input type="file" name="photo" style="font-size: 0.8rem; width: 100%;">
                        <small style="color:var(--text-light); font-size: 0.75rem; display: block; line-height: 1.4;">Leave empty to keep current. Max: 2MB.</small>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 2.5rem; background: var(--gray-50); padding: 1rem; border-radius: 10px; border-left: 4px solid var(--primary);">
                <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; margin: 0;">
                    <input type="checkbox" name="status" {{ old('status', $teacher->status) ? 'checked' : '' }} value="1" style="width:18px; height:18px; accent-color: var(--primary);"> 
                    <span style="font-weight: 700; color: var(--primary-dark); font-size: 0.95rem;">Profile Active / Visible on Website Scholars Page</span>
                </label>
            </div>

            <div style="text-align: right; border-top: 1px solid var(--gray-200); padding-top: 1.5rem;">
                <button type="submit" class="btn btn-gold" style="padding: 0.85rem 3rem; font-weight: 700; letter-spacing: 0.5px;">Update Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection


