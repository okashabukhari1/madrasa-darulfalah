@extends('admin.layouts.app')
@section('title', 'Override Evaluation')
@section('page_title', 'Master Override - Evaluation')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; font-family: var(--font-heading); color: var(--gray-800);">Edit Evaluation Record</h2>
        <p style="margin: 0; color: var(--gray-500); font-size: 13px;">Admin Override Form for {{ $exam->student->user->name }}'s evaluation</p>
    </div>
    <a href="{{ route('admin.exams.index') }}" class="btn btn-outline" style="text-decoration: none;">
        <i class="bi bi-arrow-left"></i> Back to History
    </a>
</div>

<div class="db-card" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); overflow: hidden; padding: 30px;">
    <form method="POST" action="{{ route('admin.exams.update', $exam) }}">
        @csrf
        @method('PUT')
        
        <div style="background: #fff3cd; color: #856404; padding: 12px 15px; border-radius: 8px; font-size: 13px; margin-bottom: 24px; border: 1px solid #ffeeba;">
            <i class="bi bi-exclamation-triangle-fill"></i> <strong>Admin Override:</strong> You are modifying a record originally created by <strong>{{ $exam->teacher->user->name }}</strong>.
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <!-- Student -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Student *</label>
                <select name="student_id" class="form-control" required>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id', $exam->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->student_id }} - {{ $student->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            
            <!-- Date -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', $exam->date->format('Y-m-d')) }}" required>
                @error('date') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px dashed var(--gray-200);">
            <!-- Program -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Program *</label>
                <select name="program" class="form-control" required>
                    <option value="Hifz" {{ old('program', $exam->program) == 'Hifz' ? 'selected' : '' }}>Hifz-ul-Quran</option>
                    <option value="Nazra" {{ old('program', $exam->program) == 'Nazra' ? 'selected' : '' }}>Nazra Quran</option>
                    <option value="Qaida" {{ old('program', $exam->program) == 'Qaida' ? 'selected' : '' }}>Qaida / Basic</option>
                </select>
                @error('program') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>

            <!-- Exam Type -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Evaluation Type *</label>
                <select name="exam_type" class="form-control" required>
                    <option value="Daily" {{ old('exam_type', $exam->exam_type) == 'Daily' ? 'selected' : '' }}>Daily Test (Sabaq / Sabqi / Manzil)</option>
                    <option value="Weekly" {{ old('exam_type', $exam->exam_type) == 'Weekly' ? 'selected' : '' }}>Weekly Test</option>
                    <option value="Monthly" {{ old('exam_type', $exam->exam_type) == 'Monthly' ? 'selected' : '' }}>Monthly Test</option>
                    <option value="Yearly" {{ old('exam_type', $exam->exam_type) == 'Yearly' ? 'selected' : '' }}>Yearly Test</option>
                    <option value="Completion" {{ old('exam_type', $exam->exam_type) == 'Completion' ? 'selected' : '' }}>Completion Test</option>
                </select>
                @error('exam_type') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <h3 style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 15px;">Exam Coverage Details</h3>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px dashed var(--gray-200);">
            <div class="form-group" style="margin-bottom:0;">
                <label>Para / Sipara</label>
                <input type="number" name="para" class="form-control" min="1" max="30" value="{{ old('para', $exam->para) }}">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Surah</label>
                <input type="text" name="surah" class="form-control" value="{{ old('surah', $exam->surah) }}">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Ayah From</label>
                <input type="number" name="ayah_from" class="form-control" min="1" value="{{ old('ayah_from', $exam->ayah_from) }}">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Ayah To</label>
                <input type="number" name="ayah_to" class="form-control" min="1" value="{{ old('ayah_to', $exam->ayah_to) }}">
            </div>
        </div>

        <h3 style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 15px;">Performance Metrics *</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Total Mistakes *</label>
                <input type="number" name="mistakes" class="form-control" min="0" value="{{ old('mistakes', $exam->mistakes) }}" required style="font-size: 1.2rem; font-weight: 700; color: var(--red);">
                @error('mistakes') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Fluency Rating</label>
                <select name="fluency" class="form-control">
                    <option value="">-- Not Rated --</option>
                    @for($i=5; $i>=1; $i--)
                        <option value="{{ $i }}" {{ old('fluency', $exam->fluency) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Tajweed Rating</label>
                <select name="tajweed" class="form-control">
                    <option value="">-- Not Rated --</option>
                    @for($i=5; $i>=1; $i--)
                        <option value="{{ $i }}" {{ old('tajweed', $exam->tajweed) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 30px;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Final Grade *</label>
                <select name="grade" class="form-control" required style="font-weight: 700;">
                    @foreach(['Excellent', 'Good', 'Average', 'Weak'] as $g)
                        <option value="{{ $g }}" {{ old('grade', $exam->grade) == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
                @error('grade') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Remarks / Advice</label>
                <input type="text" name="remarks" class="form-control" value="{{ old('remarks', $exam->remarks) }}">
                @error('remarks') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="text-align: right; padding-top: 20px; border-top: 1px solid var(--gray-200);">
            <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-size: 14px;">
                Apply Override
            </button>
        </div>
    </form>
</div>
@endsection
