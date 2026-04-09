@extends('admin.layouts.app')
@section('title', 'Add New Course')
@section('page_title', 'Create Course')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-journal-plus"></i> Course Details</h2>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline btn-sm">Cancel</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Course Title (English)*</label>
                    <input type="text" name="title" value="{{ old('title') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                    @error('title') <small style="color:red">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="urdu-font" style="display:block; margin-bottom:0.5rem; font-weight:600; text-align: right; font-size: 1.1rem;">(Urdu) کورس کا عنوان</label>
                    <input type="text" name="urdu_title" value="{{ old('urdu_title') }}" dir="rtl" class="urdu-font" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-size: 1.2rem;">
                    @error('urdu_title') <small style="color:red">{{ $message }}</small> @enderror
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Category*</label>
                    <select name="category_id" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Fee (PKR)*</label>
                    <input type="number" name="fee" value="{{ old('fee', 0) }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
                
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Duration*</label>
                    <input type="text" name="duration" placeholder="e.g. 6 Months" value="{{ old('duration') }}" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Course Level*</label>
                    <select name="level" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Assigned Teacher*</label>
                    <select name="teacher_id" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name ?? 'Scholar' }} {{ $teacher->urdu_name ? '(' . $teacher->urdu_name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Description (English)*</label>
                <textarea name="description" rows="4" required style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">{{ old('description') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="urdu-font" style="display:block; margin-bottom:0.5rem; font-weight:600; text-align: right; font-size: 1.1rem;">(Urdu) کورس کی تفصیل</label>
                <textarea name="urdu_description" rows="4" dir="rtl" class="urdu-font" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-size: 1.2rem;">{{ old('urdu_description') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Full Course Content (Curriculum/Syllabus)*</label>
                <textarea name="content" rows="8" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white); font-family: sans-serif;" placeholder="Detailed info for the course detail page...">{{ old('content') }}</textarea>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Course Image</label>
                <input type="file" name="image" style="width:100%; padding:0.5rem; border:1px solid var(--beige-dark); border-radius:8px; background:var(--white);">
                <small style="color:var(--text-light)">Max size: 2MB. Recommended: 800x600px</small>
            </div>

            <div style="background: var(--beige-light); padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--beige-dark);">
                <h3 style="margin-bottom: 1rem; font-size: 1.1rem; color: var(--primary); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-search"></i> SEO Metadata (Optional)
                </h3>
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label style="display:block; margin-bottom:0.4rem; font-size: 0.9rem;">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title') }}" style="width:100%; padding:0.6rem; border:1px solid var(--beige-dark); border-radius:6px;">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:0.4rem; font-size: 0.9rem;">Meta Description</label>
                    <textarea name="meta_description" rows="2" style="width:100%; padding:0.6rem; border:1px solid var(--beige-dark); border-radius:6px;">{{ old('meta_description') }}</textarea>
                </div>
            </div>

            <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="status" checked value="1"> 
                    <span style="font-weight: 600;">Active / Published</span>
                </label>
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_featured" value="1"> 
                    <span style="font-weight: 600;">Featured on Homepage</span>
                </label>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2rem;">Save Course</button>
            </div>
        </form>
    </div>
</div>
@endsection


