@extends('admin.layouts.app')

@section('title', 'Student Progress Logs')
@section('page_title', 'Student Progress Logs')

@section('content')
<div class="db-card" style="margin-bottom: 2rem;">
    <div class="db-card-body">
        <form method="GET" action="{{ route('admin.progress-logs.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; align-items: flex-end;">
            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Program</label>
                <select name="program" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                    <option value="">All Programs</option>
                    <option value="hifz" {{ request('program') === 'hifz' ? 'selected' : '' }}>Hifz</option>
                    <option value="nazra" {{ request('program') === 'nazra' ? 'selected' : '' }}>Nazra</option>
                    <option value="qaida" {{ request('program') === 'qaida' ? 'selected' : '' }}>Qaida</option>
                </select>
            </div>
            
            <div class="form-group">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-gold" style="padding: 0.75rem 1.5rem;">Filter</button>
                <a href="{{ route('admin.progress-logs.index') }}" class="btn btn-outline" style="padding: 0.75rem 1.5rem;">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-journal-text"></i> Daily Academic Logs</h2>
        <p style="font-size: 0.85rem; color: var(--gray-500); margin: 0;">Logs submitted by teachers</p>
    </div>
    <div class="db-card-body" style="padding: 0;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Student Info</th>
                    <th>Program</th>
                    <th>Teacher</th>
                    <th>Lesson</th>
                    <th>Ayah Range</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td><div style="font-size: 0.9rem; font-weight: 500;">{{ $log->date->format('M d, Y') }}</div></td>
                    <td>
                        <div style="font-weight: 600; color: var(--primary);">{{ $log->student->user->name ?? 'Unknown' }}</div>
                        <code style="font-size: 0.75rem; color: var(--gray-500);">{{ $log->student->student_id }}</code>
                    </td>
                    <td><span class="badge badge-blue" style="font-size: 0.7rem;">{{ ucfirst($log->student->program ?? 'N/A') }}</span></td>
                    <td><div style="font-size: 0.9rem;">{{ $log->teacher->name ?? 'N/A' }}</div></td>
                    <td>
                        <div style="font-weight: 600; color: var(--gray-800);">{{ ucfirst($log->lesson_type ?? 'N/A') }}</div>
                        <div style="font-size: 0.8rem; color: var(--gray-600);">
                            @if($log->para) Para {{ $log->para }} @endif
                            @if($log->surah) {{ $log->surah }} @endif
                        </div>
                    </td>
                    <td>
                        @if($log->ayah_from) <span style="background: var(--gray-100); padding: 2px 6px; border-radius: 4px;">{{ $log->ayah_from }} - {{ $log->ayah_to }}</span> @else - @endif
                    </td>
                    <td><div style="max-width: 200px; font-size: 0.8rem; color: var(--gray-500); font-style: italic;">{{ $log->remarks ?? '-' }}</div></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: var(--gray-500);">No progress logs found matching the criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="padding: 1.5rem;">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
