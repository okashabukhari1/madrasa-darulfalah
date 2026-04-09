@extends('teacher.layouts.app')
@section('title', 'Manage Daily Progress')
@section('page_title', 'Daily Progress & Attendance')

@section('content')
<div class="db-card" style="margin-bottom: 2rem;">
    <div class="db-card-header" style="justify-content: space-between;">
        <h2><i class="bi bi-calendar-day"></i> Record for {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</h2>
        <form method="GET" action="{{ route('teacher.progress.index') }}" style="display: flex; gap: 10px;">
            <input type="date" name="date" value="{{ $date }}" class="form-control" style="padding: 0.5rem; border-radius: 6px; border: 1px solid var(--beige-dark);" max="{{ date('Y-m-d') }}">
            <button type="submit" class="btn btn-gold btn-sm">Change Date</button>
        </form>
    </div>

    <div class="db-card-body" style="padding: 1.5rem;">
        <form action="{{ route('teacher.progress.store') }}" method="POST">
            @csrf
            <input type="hidden" name="date" value="{{ $date }}">
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
                    <thead>
                        <tr style="background: var(--beige-light); border-bottom: 2px solid var(--gold);">
                            <th style="padding: 10px; text-align: left;">Student</th>
                            <th style="padding: 10px; text-align: left; width: 120px;">Attendance</th>
                            <th style="padding: 10px; text-align: left;">Lesson Type</th>
                            <th style="padding: 10px; text-align: left; width: 80px;">Para</th>
                            <th style="padding: 10px; text-align: left;">Surah</th>
                            <th style="padding: 10px; text-align: left; width: 140px;">Ayah (From - To)</th>
                            <th style="padding: 10px; text-align: left;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        @php
                            $att = $attendances[$student->id] ?? null;
                            $prog = $progressLogs[$student->id] ?? null;
                        @endphp
                        <tr style="border-bottom: 1px solid var(--beige-dark);">
                            <td style="padding: 10px;">
                                <div style="font-weight: 600;">{{ $student->user->name ?? 'Unknown' }}</div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);">{{ ucfirst($student->program) }} · {{ $student->student_id }}</div>
                            </td>
                            <td style="padding: 10px;">
                                <select name="students[{{ $student->id }}][status]" style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                                    <option value="present" {{ ($att->status ?? '') == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="late" {{ ($att->status ?? '') == 'late' ? 'selected' : '' }}>Late</option>
                                    <option value="absent" {{ ($att->status ?? '') == 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                            </td>
                            <td style="padding: 10px;">
                                <select name="students[{{ $student->id }}][lesson_type]" style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                                    <option value="">-- Type --</option>
                                    <option value="sabaq" {{ ($prog->lesson_type ?? '') == 'sabaq' ? 'selected' : '' }}>Sabaq (New)</option>
                                    <option value="sabqi" {{ ($prog->lesson_type ?? '') == 'sabqi' ? 'selected' : '' }}>Sabqi (Rev)</option>
                                    <option value="manzil" {{ ($prog->lesson_type ?? '') == 'manzil' ? 'selected' : '' }}>Manzil (Old Rev)</option>
                                </select>
                            </td>
                            <td style="padding: 10px;">
                                <input type="number" name="students[{{ $student->id }}][para]" value="{{ $prog->para ?? '' }}" min="1" max="30" placeholder="e.g. 5" style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                            </td>
                            <td style="padding: 10px;">
                                <input type="text" name="students[{{ $student->id }}][surah]" value="{{ $prog->surah ?? '' }}" placeholder="Surah Name" style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                            </td>
                            <td style="padding: 10px;">
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <input type="text" name="students[{{ $student->id }}][ayah_from]" value="{{ $prog->ayah_from ?? '' }}" placeholder="From" style="width: 50%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                                    -
                                    <input type="text" name="students[{{ $student->id }}][ayah_to]" value="{{ $prog->ayah_to ?? '' }}" placeholder="To" style="width: 50%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                                </div>
                            </td>
                            <td style="padding: 10px;">
                                <input type="text" name="students[{{ $student->id }}][remarks]" value="{{ $prog->remarks ?? '' }}" placeholder="Optional notes" style="width: 100%; padding: 0.4rem; border-radius: 4px; border: 1px solid var(--beige-dark);">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 20px; text-align: center; color: var(--gray-500);">
                                No students assigned to you yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->count() > 0)
            <div style="margin-top: 1.5rem; text-align: right;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 2.5rem; font-size: 1rem;">
                    <i class="bi bi-save"></i> Save All Records
                </button>
            </div>
            @endif
        </form>
    </div>
</div>
@endsection
