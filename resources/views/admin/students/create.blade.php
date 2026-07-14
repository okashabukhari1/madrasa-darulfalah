@extends('admin.layouts.app')
@section('title', 'Add New Student')
@section('page_title', 'Enroll Student')

@section('content')
<div class="db-card" style="max-width: 800px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-person-plus"></i> Student Details</h2>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
    </div>
    
    <div class="db-card-body" style="padding: 2rem;">
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Name -->
                <div class="form-group">
                    <label for="name">Full Name (English - Optional)</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter student's English name">
                    @error('name')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Urdu Name -->
                <div class="form-group">
                    <label for="urdu_name" class="urdu-font" style="text-align: right; font-size: 1.1rem;">(Urdu) مکمل نام</label>
                    <input type="text" id="urdu_name" name="urdu_name" value="{{ old('urdu_name') }}" dir="rtl" class="form-control urdu-font" style="font-size: 1.25rem;" placeholder="طالب علم کا نام یہاں لکھیں">
                    @error('urdu_name')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-control" placeholder="student@example.com">
                    @error('email')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Student Phone -->
                <div class="form-group">
                    <label for="phone">Student Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="03xx-xxxxxxx">
                    @error('phone')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Guardian Name -->
                <div class="form-group">
                    <label for="guardian_name">Guardian Name</label>
                    <input type="text" id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" class="form-control" placeholder="Father or relative's name">
                    @error('guardian_name')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Guardian Phone -->
                <div class="form-group">
                    <label for="guardian_phone">Guardian Phone</label>
                    <input type="text" id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}" class="form-control" placeholder="Contact number for guardian">
                    @error('guardian_phone')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <!-- Program -->
                <div class="form-group">
                    <label for="program">Program *</label>
                    <select id="program" name="program" required class="form-control">
                        <option value="">Select Program</option>
                        <option value="hifz" {{ old('program') == 'hifz' ? 'selected' : '' }}>Hifz-ul-Quran</option>
                        <option value="nazra" {{ old('program') == 'nazra' ? 'selected' : '' }}>Nazra Quran</option>
                        <option value="qaida" {{ old('program') == 'qaida' ? 'selected' : '' }}>Qaida</option>
                    </select>
                    @error('program')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Teacher -->
                <div class="form-group">
                    <label for="teacher_id">Assigned Teacher</label>
                    <select id="teacher_id" name="teacher_id" class="form-control">
                        <option value="">Unassigned</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->teacher_id ?? '—' }} — {{ $teacher->name ?? 'Scholar' }} {{ $teacher->urdu_name ? '(' . $teacher->urdu_name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Legacy Course -->
                <div class="form-group">
                    <label for="course_id">Legacy Course</label>
                    <select id="course_id" name="course_id" class="form-control">
                        <option value="">No Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }} {{ $course->urdu_title ? '(' . $course->urdu_title . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Student Password *</label>
                    <div class="password-input-wrapper" style="position: relative;">
                        <input type="password" id="password" name="password" required class="form-control" style="padding-right: 3rem;" placeholder="Set a secure password">
                        <button type="button" class="password-toggle" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.1rem;">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')<span style="color:var(--red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline" style="padding: 0.75rem 1.5rem; border-radius: 8px;">Cancel</a>
                <button type="submit" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 8px; border:none; background:linear-gradient(135deg,var(--primary),var(--primary-dark)); color:#fff; font-weight:600; cursor:pointer;"><i class="bi bi-save"></i> Save Student</button>
            </div>
        </form>
    </div>
</div>
@endsection


