@extends('student.layouts.app')
@section('title', 'My Attendance')
@section('page_title', 'Attendance Report')

@section('content')
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card green">
        <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
        <div class="stat-info"><h3>{{ $percentage }}%</h3><p>Attendance Rate</p></div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="bi bi-calendar3"></i></div>
        <div class="stat-info"><h3>{{ $stats['total'] }}</h3><p>Total Classes</p></div>
    </div>
    <div class="stat-card gold">
        <div class="stat-icon"><i class="bi bi-clock-history"></i></div>
        <div class="stat-info"><h3>{{ $stats['late'] }}</h3><p>Late Entries</p></div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="bi bi-x-circle"></i></div>
        <div class="stat-info"><h3>{{ $stats['absent'] }}</h3><p>Total Absents</p></div>
    </div>
</div>

<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-calendar-range"></i> Detailed History</h2>
    </div>
    <div class="db-card-body" style="padding:0;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Course</th>
                    <th>Teacher</th>
                    <th>Status</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @if($attendances && $attendances->count() > 0)
                    @foreach($attendances as $att)
                    <tr>
                        <td><strong>{{ $att->date->format('M d, Y') }}</strong></td>
                        <td>
                            @if($att->course)
                                {{ $att->course->title }}
                            @else
                                <span class="badge badge-blue" style="font-size:0.7rem;">{{ ucfirst($att->student->program ?? 'Program') }}</span>
                            @endif
                        </td>
                        <td>{{ $att->teacher->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge badge-{{ $att->status === 'present' ? 'green' : ($att->status === 'absent' ? 'red' : 'gold') }}">
                                {{ ucfirst($att->status) }}
                            </span>
                        </td>
                        <td><small style="color:var(--gray-500);">{{ $att->notes ?: '—' }}</small></td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px; color:var(--gray-500);">No attendance records found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        @if($attendances->count() > 0)
        <div style="padding:20px;">
            {{ $attendances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
