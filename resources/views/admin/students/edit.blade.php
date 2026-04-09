@extends('admin.layouts.app')
@section('title', 'Edit Student')
@section('page_title', 'Edit Student: ' . ($student->user->name ?? 'Unknown'))

@section('content')
<div class="db-card" style="max-width: 900px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-gear"></i> Student Account & Details</h2>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline btn-sm">Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h3 style="font-size: 1.1rem; color: var(--gold-dark); margin-bottom: 1.5rem; border-bottom: 1px solid var(--beige-dark); padding-bottom: 0.5rem;">User Account Information</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label>Full Name (English - Optional)</label>
                    <input type="text" name="name" value="{{ old('name', $student->name ?? $student->user->name) }}" class="form-control" placeholder="Student name in English">
                </div>

                <div class="form-group">
                    <label class="urdu-font" style="text-align: right; font-size: 1.1rem;">(Urdu) مکمل نام</label>
                    <input type="text" name="urdu_name" value="{{ old('urdu_name', $student->urdu_name) }}" dir="rtl" class="form-control urdu-font" style="font-size: 1.25rem;" placeholder="طالب علم کا نام یہاں لکھیں">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label>Email Address*</label>
                    <input type="email" name="email" value="{{ old('email', $student->user->email) }}" required class="form-control" placeholder="student@example.com">
                </div>

                <div class="form-group">
                    <label>Student Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->user->phone) }}" class="form-control" placeholder="03xx-xxxxxxx">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Guardian -->
                <div class="form-group">
                    <label>Guardian Name</label>
                    <input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="form-control" placeholder="Guardian's name">
                </div>
                <div class="form-group">
                    <label>Guardian Phone</label>
                    <input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" class="form-control" placeholder="Guardian's phone">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Program -->
                <div class="form-group">
                    <label>Program *</label>
                    <select name="program" required class="form-control">
                        <option value="">Select Program</option>
                        <option value="hifz" {{ (old('program', $student->program) == 'hifz') ? 'selected' : '' }}>Hifz-ul-Quran</option>
                        <option value="nazra" {{ (old('program', $student->program) == 'nazra') ? 'selected' : '' }}>Nazra Quran</option>
                        <option value="qaida" {{ (old('program', $student->program) == 'qaida') ? 'selected' : '' }}>Qaida</option>
                    </select>
                </div>
                
                <!-- Assigned Teacher -->
                <div class="form-group">
                    <label>Assigned Teacher</label>
                    <select name="teacher_id" class="form-control">
                        <option value="">Unassigned</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ (old('teacher_id', $student->teacher_id) == $teacher->id) ? 'selected' : '' }}>
                                {{ $teacher->name ?? 'Scholar' }} {{ $teacher->urdu_name ? '(' . $teacher->urdu_name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Legacy Course -->
                <div class="form-group">
                    <label>Legacy Course</label>
                    <select name="course_id" class="form-control">
                        <option value="">No Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ (old('course_id', $student->courses->first()->id ?? '') == $course->id) ? 'selected' : '' }}>
                                {{ $course->title }} {{ $course->urdu_title ? '(' . $course->urdu_title . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Account Status *</label>
                    <select name="status" required class="form-control">
                        <option value="active" {{ (old('status', $student->status) == 'active') ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ (old('status', $student->status) == 'inactive') ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ (old('status', $student->status) == 'graduated') ? 'selected' : '' }}>Graduated</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label>New Password (leave blank to keep current)</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" name="password" class="form-control" style="padding-right: 3rem;" placeholder="Enter new password">
                        <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.1rem;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2.5rem;">Update Student Profile</button>
            </div>
        </form>
    </div>
</div>
@endsection


