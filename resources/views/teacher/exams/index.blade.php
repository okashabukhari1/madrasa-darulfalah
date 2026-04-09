@extends('teacher.layouts.app')
@section('title', 'Exams & Evaluations')
@section('page_title', 'Exams & Evaluations')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2 style="margin: 0; font-family: var(--font-heading); color: var(--gray-800);">Evaluations History</h2>
        <p style="margin: 0; color: var(--gray-500); font-size: 13px;">Manage and review your students' exams and performance.</p>
    </div>
    <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary" style="text-decoration: none;">
        <i class="bi bi-plus-circle"></i> Add Evaluation
    </a>
</div>

<div class="db-card" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); margin-bottom: 2rem; overflow: hidden;">
    <!-- Filters -->
    <div style="padding: 20px; border-bottom: 1px solid var(--gray-200); background: var(--gray-50);">
        <form method="GET" action="{{ route('teacher.exams.index') }}" class="form-row-3" style="margin-bottom: 0;">
            <div class="form-group">
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
            <div class="form-group">
                <label>Filter by Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
            </div>
            <div class="form-group">
                <label>Filter by Program</label>
                <select name="program" class="form-control" onchange="this.form.submit()">
                    <option value="">All Programs</option>
                    <option value="Hifz" {{ request('program') == 'Hifz' ? 'selected' : '' }}>Hifz</option>
                    <option value="Nazra" {{ request('program') == 'Nazra' ? 'selected' : '' }}>Nazra</option>
                    <option value="Qaida" {{ request('program') == 'Qaida' ? 'selected' : '' }}>Qaida</option>
                </select>
            </div>
            <div style="display:flex; align-items: flex-end;">
                @if(request()->anyFilled(['student_id', 'date', 'program']))
                <a href="{{ route('teacher.exams.index') }}" class="btn btn-outline" style="text-decoration:none;">Clear Filters</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student</th>
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
                            <img src="{{ $exam->student->user->avatar_url }}" alt="avatar" style="width:34px; height:34px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div class="td-name">{{ $exam->student->user->name }}</div>
                                <div class="td-sub">{{ $exam->student->student_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600;">{{ $exam->program }}</div>
                        <span class="badge badge-gray">{{ $exam->exam_type }}</span>
                    </td>
                    <td>
                        @if($exam->para) <div><strong>Para:</strong> {{ $exam->para }}</div> @endif
                        @if($exam->surah) <div><strong>Surah:</strong> {{ $exam->surah }}</div> @endif
                        @if($exam->ayah_from && $exam->ayah_to) <div><strong>Ayah:</strong> {{ $exam->ayah_from }} - {{ $exam->ayah_to }}</div> @endif
                    </td>
                    <td>
                        <div><i class="bi bi-x-circle text-danger" style="color:var(--red);"></i> {{ $exam->mistakes }} mistakes</div>
                        <div>Fluency: {{ $exam->fluency ?? '-' }}/5 | Tajweed: {{ $exam->tajweed ?? '-' }}/5</div>
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
                            <a href="{{ route('teacher.exams.edit', $exam) }}" class="btn btn-outline" style="padding: 4px 10px; font-size: 11px;">Edit</a>
                            <form method="POST" action="{{ route('teacher.exams.destroy', $exam) }}" onsubmit="return confirm('Delete this evaluation?');" style="margin: 0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 4px 10px; font-size: 11px; border:none; cursor:pointer;">Del</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: var(--gray-400);">
                        <i class="bi bi-journal-x" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                        No evaluations found matching the current filters.
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
