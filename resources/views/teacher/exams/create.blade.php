@extends('teacher.layouts.app')
@section('title', 'Add Evaluation')
@section('page_title', 'Add Student Evaluation')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; font-family: var(--font-heading); color: var(--gray-800);">New Evaluation</h2>
        <p style="margin: 0; color: var(--gray-500); font-size: 13px;">Record performance for Hifz, Nazra, or Qaida seamlessly.</p>
    </div>
    <a href="{{ route('teacher.exams.index') }}" class="btn btn-outline" style="text-decoration: none;">
        <i class="bi bi-arrow-left"></i> Back to History
    </a>
</div>

<div class="db-card" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); overflow: hidden; padding: 30px;">
    <form method="POST" action="{{ route('teacher.exams.store') }}">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
            <!-- Student -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Select Student *</label>
                <select name="student_id" class="form-control" required>
                    <option value="">-- Choose Student --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_id }} - {{ $student->user->name }}
                        </option>
                    @endforeach
                </select>
                @error('student_id') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            
            <!-- Date -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Date *</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" required>
                @error('date') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px dashed var(--gray-200);">
            <!-- Program -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Program *</label>
                <select name="program" class="form-control" required>
                    <option value="Hifz" {{ old('program') == 'Hifz' ? 'selected' : '' }}>Hifz-ul-Quran</option>
                    <option value="Nazra" {{ old('program') == 'Nazra' ? 'selected' : '' }}>Nazra Quran</option>
                    <option value="Qaida" {{ old('program') == 'Qaida' ? 'selected' : '' }}>Qaida / Basic</option>
                </select>
                @error('program') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>

            <!-- Exam Type -->
            <div class="form-group" style="margin-bottom:0;">
                <label>Evaluation Type *</label>
                <select name="exam_type" class="form-control" required>
                    <option value="Daily" {{ old('exam_type') == 'Daily' ? 'selected' : '' }}>Daily Test (Sabaq / Sabqi / Manzil)</option>
                    <option value="Weekly" {{ old('exam_type') == 'Weekly' ? 'selected' : '' }}>Weekly Test</option>
                    <option value="Monthly" {{ old('exam_type') == 'Monthly' ? 'selected' : '' }}>Monthly Test</option>
                    <option value="Yearly" {{ old('exam_type') == 'Yearly' ? 'selected' : '' }}>Yearly Test</option>
                    <option value="Completion" {{ old('exam_type') == 'Completion' ? 'selected' : '' }}>Completion Test</option>
                </select>
                @error('exam_type') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <h3 style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 15px;">Exam Coverage Details (Optional)</h3>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px dashed var(--gray-200);">
            <div class="form-group" style="margin-bottom:0;">
                <label>Para / Sipara</label>
                <input type="number" name="para" class="form-control" min="1" max="30" value="{{ old('para') }}" placeholder="e.g. 1">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Surah</label>
                <input type="text" name="surah" class="form-control" value="{{ old('surah') }}" placeholder="e.g. Al-Baqarah">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Ayah From</label>
                <input type="number" name="ayah_from" class="form-control" min="1" value="{{ old('ayah_from') }}" placeholder="Start Ayah">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Ayah To</label>
                <input type="number" name="ayah_to" class="form-control" min="1" value="{{ old('ayah_to') }}" placeholder="End Ayah">
            </div>
        </div>

        <h3 style="font-size: 15px; font-weight: 700; color: var(--gray-800); margin-bottom: 15px;">Performance Metrics *</h3>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 24px;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Total Mistakes *</label>
                <input type="number" name="mistakes" class="form-control" min="0" value="{{ old('mistakes', 0) }}" required style="font-size: 1.2rem; font-weight: 700; color: var(--red);">
                <small style="color: var(--gray-400); font-size: 11px; margin-top:4px; display:block;">Total reading/memorization errors</small>
                @error('mistakes') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Fluency (Rawaani) Rating</label>
                <select name="fluency" class="form-control">
                    <option value="">-- Not Rated --</option>
                    <option value="5" {{ old('fluency') == '5' ? 'selected' : '' }}>5 - Excellent (No hesitation)</option>
                    <option value="4" {{ old('fluency') == '4' ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="3" {{ old('fluency') == '3' ? 'selected' : '' }}>3 - Good (Average pace)</option>
                    <option value="2" {{ old('fluency') == '2' ? 'selected' : '' }}>2 - Poor (Lots of hesitations)</option>
                    <option value="1" {{ old('fluency') == '1' ? 'selected' : '' }}>1 - Very Poor</option>
                </select>
                @error('fluency') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Tajweed Rating</label>
                <select name="tajweed" class="form-control">
                    <option value="">-- Not Rated --</option>
                    <option value="5" {{ old('tajweed') == '5' ? 'selected' : '' }}>5 - Excellent (Perfect rules)</option>
                    <option value="4" {{ old('tajweed') == '4' ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="3" {{ old('tajweed') == '3' ? 'selected' : '' }}>3 - Good (Minor errors)</option>
                    <option value="2" {{ old('tajweed') == '2' ? 'selected' : '' }}>2 - Poor (Many errors)</option>
                    <option value="1" {{ old('tajweed') == '1' ? 'selected' : '' }}>1 - Very Poor</option>
                </select>
                @error('tajweed') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 30px;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Final Grade *</label>
                <select name="grade" class="form-control" required style="font-weight: 700; background: var(--gray-50);">
                    <option value="Excellent" {{ old('grade') == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                    <option value="Good" {{ old('grade') == 'Good' ? 'selected' : '' }}>Good</option>
                    <option value="Average" {{ old('grade') == 'Average' ? 'selected' : '' }}>Average</option>
                    <option value="Weak" {{ old('grade') == 'Weak' ? 'selected' : '' }}>Weak</option>
                </select>
                @error('grade') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Remarks / Advice</label>
                <input type="text" name="remarks" class="form-control" value="{{ old('remarks') }}" placeholder="e.g. Needs more focus on Mutashabihaat">
                @error('remarks') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="text-align: right; padding-top: 20px; border-top: 1px solid var(--gray-200);">
            <button type="submit" class="btn btn-primary" style="padding: 12px 24px; font-size: 14px;">
                Save Evaluation
            </button>
        </div>
    </form>
</div>
@endsection
