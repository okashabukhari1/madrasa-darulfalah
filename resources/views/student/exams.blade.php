@extends('student.layouts.app')
@section('title', 'My Exams & Evaluations')
@section('page_title', 'Exams & Evaluations')

@section('content')
<div class="mb-4" style="margin-bottom: 2rem;">
    <h2 style="margin: 0; font-family: var(--font-heading); color: var(--gray-800);">Performance & Evaluations</h2>
    <p style="margin: 0; color: var(--gray-500); font-size: 13px;">Review your memorization progress, fluency, and tajweed evaluations.</p>
</div>

<!-- Simple Analytics -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 2rem;">
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-x-circle text-danger" style="font-size: 2rem; color: var(--red); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ $totalMistakes ?? 0 }}</h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Total Mistakes Recorded</p>
    </div>
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-soundwave text-primary" style="font-size: 2rem; color: var(--primary); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ number_format($averageFluency, 1) ?? '-' }}<span style="font-size:14px; color:var(--gray-400);">/5</span></h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Average Fluency</p>
    </div>
    <div class="db-card" style="background: #fff; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <i class="bi bi-journal-text text-gold" style="font-size: 2rem; color: var(--gold); display: block; margin-bottom: 10px;"></i>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800); margin: 0;">{{ number_format($averageTajweed, 1) ?? '-' }}<span style="font-size:14px; color:var(--gray-400);">/5</span></h3>
        <p style="color: var(--gray-500); font-size: 12px; margin: 0; font-weight: 600;">Average Tajweed</p>
    </div>
</div>

<div class="db-card" style="background: #fff; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); margin-bottom: 2rem; overflow: hidden;">
    <!-- Filters -->
    <div style="padding: 20px; border-bottom: 1px solid var(--gray-200); background: var(--gray-50);">
        <form method="GET" action="{{ route('student.exams.index') }}" class="form-row-3" style="margin-bottom: 0;">
            <div class="form-group">
                <label>Filter by Program</label>
                <select name="program" class="form-control" onchange="this.form.submit()">
                    <option value="">All Programs</option>
                    <option value="Hifz" {{ request('program') == 'Hifz' ? 'selected' : '' }}>Hifz</option>
                    <option value="Nazra" {{ request('program') == 'Nazra' ? 'selected' : '' }}>Nazra</option>
                    <option value="Qaida" {{ request('program') == 'Qaida' ? 'selected' : '' }}>Qaida</option>
                </select>
            </div>
            <div class="form-group">
                <label>Exam Type</label>
                <select name="exam_type" class="form-control" onchange="this.form.submit()">
                    <option value="">All Types</option>
                    <option value="Daily" {{ request('exam_type') == 'Daily' ? 'selected' : '' }}>Daily</option>
                    <option value="Weekly" {{ request('exam_type') == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="Monthly" {{ request('exam_type') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Yearly" {{ request('exam_type') == 'Yearly' ? 'selected' : '' }}>Yearly</option>
                    <option value="Completion" {{ request('exam_type') == 'Completion' ? 'selected' : '' }}>Completion</option>
                </select>
            </div>
            <div style="display:flex; align-items: flex-end;">
                @if(request()->anyFilled(['exam_type', 'program']))
                <a href="{{ route('student.exams.index') }}" class="btn btn-outline" style="text-decoration:none;">Clear Filters</a>
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
                    <th>Teacher</th>
                    <th>Program & Type</th>
                    <th>Sabaq Details</th>
                    <th>Metrics</th>
                    <th>Grade</th>
                    <th>Remarks</th>
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
                            <img src="{{ $exam->teacher->user->avatar_url }}" alt="avatar" style="width:34px; height:34px; border-radius:50%; object-fit:cover;">
                            <div>
                                <div class="td-name">{{ $exam->teacher->user->name }}</div>
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
                    <td>
                        <div style="max-width: 200px; font-size: 13px; color: var(--gray-500); line-height: 1.4;">
                            {{ $exam->remarks ?? '-' }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem 1rem; color: var(--gray-400);">
                        <i class="bi bi-award" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                        No evaluations found.
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
