@extends('admin.layouts.app')
@section('title', 'Exams & Evaluations')
@section('page_title', 'Exams & Evaluations')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; font-family: var(--font-heading); color: var(--gray-800);">Master Evaluations List</h2>
        <p style="margin: 0; color: var(--gray-500); font-size: 13px;">Monitor and override all student evaluations across the madrasa.</p>
    </div>
</div>

<!-- Simple Analytics -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 2rem;">
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-award-fill text-gold" style="font-size: 2rem; color: var(--gold); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ $totalExams }}</h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Total Evaluations Recorded</p>
    </div>
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-soundwave text-primary" style="font-size: 2rem; color: var(--primary); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ number_format($avgFluency, 1) ?? '-' }}<span style="font-size:14px; color:var(--gray-400);">/5</span></h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Madrasa Avg Fluency</p>
    </div>
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-journal-text text-primary" style="font-size: 2rem; color: var(--primary); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ number_format($avgTajweed, 1) ?? '-' }}<span style="font-size:14px; color:var(--gray-400);">/5</span></h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Madrasa Avg Tajweed</p>
    </div>
</div>

<div class="db-card" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); margin-bottom: 2rem; overflow: hidden;">
    <!-- Filters -->
    <div style="padding: 20px; border-bottom: 1px solid var(--gray-200); background: var(--gray-50);">
        <form method="GET" action="{{ route('admin.exams.index') }}" class="form-row-4" style="margin-bottom: 0; display:grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
            <div class="form-group" style="margin-bottom:0;">
                <label>Filter by Teacher</label>
                <select name="teacher_id" class="form-control" onchange="this.form.submit()">
                    <option value="">All Teachers</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Filter by Student</label>
                <select name="student_id" class="form-control" onchange="this.form.submit()">
                    <option value="">All Students</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->student_id }} - {{ $student->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Filter by Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label>Filter by Program</label>
                <select name="program" class="form-control" onchange="this.form.submit()">
                    <option value="">All Programs</option>
                    <option value="Hifz" {{ request('program') == 'Hifz' ? 'selected' : '' }}>Hifz</option>
                    <option value="Nazra" {{ request('program') == 'Nazra' ? 'selected' : '' }}>Nazra</option>
                    <option value="Qaida" {{ request('program') == 'Qaida' ? 'selected' : '' }}>Qaida</option>
                </select>
            </div>
        </form>
        @if(request()->anyFilled(['teacher_id', 'student_id', 'date', 'program']))
        <div style="text-align: right; margin-top: 10px;">
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline" style="text-decoration:none; padding:4px 10px; font-size:12px;">Clear Filters</a>
        </div>
        @endif
    </div>

    <!-- Data Table -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Teacher</th>
                    <th>Program & Type</th>
                    <th>Details</th>
                    <th>Metrics</th>
                    <th>Grade</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                <tr>
                    <td style="white-space: nowrap; font-weight: 500;">
                        {{ \Carbon\Carbon::parse($exam->date)->format('d M, Y') }}
                    </td>
                    <td>
                        <div class="td-avatar">
                            <img src="{{ $exam->student->user->avatar_url }}" alt="avatar" style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div class="td-name" style="font-size:13px;">{{ $exam->student->user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="td-avatar">
                            <img src="{{ $exam->teacher->user->avatar_url }}" alt="avatar" style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div class="td-name" style="font-size:13px;">{{ $exam->teacher->user->name }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; font-size:13px;">{{ $exam->program }}</div>
                        <span class="badge badge-gray" style="font-size:10px;">{{ $exam->exam_type }}</span>
                    </td>
                    <td style="font-size: 12px; color: var(--gray-600);">
                        @if($exam->para) <div><strong>Para:</strong> {{ $exam->para }}</div> @endif
                        @if($exam->surah) <div><strong>Surah:</strong> {{ $exam->surah }}</div> @endif
                    </td>
                    <td style="font-size: 13px;">
                        <span style="color:var(--red); font-weight:600;">{{ $exam->mistakes }}M</span> | 
                        F:{{ $exam->fluency ?? '-' }} | T:{{ $exam->tajweed ?? '-' }}
                    </td>
                    <td>
                        @php
                            $badgeClass = 'badge-gray';
                            if ($exam->grade == 'Excellent' || $exam->grade == 'Good') $badgeClass = 'badge-green';
                            elseif ($exam->grade == 'Average') $badgeClass = 'badge-gold';
                            elseif ($exam->grade == 'Weak') $badgeClass = 'badge-red';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $exam->grade }}</span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="btn btn-outline" style="padding: 4px 8px; font-size: 11px;"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.exams.destroy', $exam) }}" onsubmit="return confirm('Delete this evaluation completely?');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 11px; border:none; cursor:pointer;"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: var(--gray-400);">
                        <i class="bi bi-journal-x" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                        No evaluations found matching the criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 20px;">
    {{ $exams->links() }}
</div>
@endsection
