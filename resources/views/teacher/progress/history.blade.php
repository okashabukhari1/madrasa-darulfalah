@extends('teacher.layouts.app')
@section('title', 'Progress History')
@section('page_title', 'Daily Progress History')

@section('content')
<div class="db-card" style="margin-bottom: 2rem;">
    <div class="db-card-header">
        <h2><i class="bi bi-journal-text"></i> Recent Logs</h2>
        <a href="{{ route('teacher.progress.index') }}" class="btn btn-outline btn-sm">Add New Progress</a>
    </div>

    <div class="db-card-body" style="padding: 1.5rem;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                <thead>
                    <tr style="background: var(--beige-light); border-bottom: 2px solid var(--gold);">
                        <th style="padding: 10px; text-align: left;">Date</th>
                        <th style="padding: 10px; text-align: left;">Student</th>
                        <th style="padding: 10px; text-align: left;">Type</th>
                        <th style="padding: 10px; text-align: left;">Surah (Para)</th>
                        <th style="padding: 10px; text-align: left;">Ayah</th>
                        <th style="padding: 10px; text-align: left;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($progressLogs as $log)
                    <tr style="border-bottom: 1px solid var(--beige-dark);">
                        <td style="padding: 10px; font-weight: 500;">{{ $log->date->format('M d, Y') }}</td>
                        <td style="padding: 10px;">
                            <div style="font-weight: 600;">{{ $log->student->user->name ?? 'Unknown' }}</div>
                            <div style="font-size: 0.8rem; color: var(--gray-500);">{{ ucfirst($log->student->program) }}</div>
                        </td>
                        <td style="padding: 10px;">
                            <span class="badge" style="background: var(--teacher-secondary); color: white;">{{ ucfirst($log->lesson_type) }}</span>
                        </td>
                        <td style="padding: 10px;">
                            {{ $log->surah ?? '--' }}
                            @if($log->para) (Para {{ $log->para }}) @endif
                        </td>
                        <td style="padding: 10px;">
                            {{ $log->ayah_from ? $log->ayah_from . ' - ' . $log->ayah_to : '--' }}
                        </td>
                        <td style="padding: 10px; color: var(--gray-500); font-size: 0.9rem;">
                            {{ $log->remarks ?? '--' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 20px; text-align: center; color: var(--gray-500);">
                            No progress logs found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 1rem;">
            {{ $progressLogs->links() }}
        </div>
    </div>
</div>
@endsection
