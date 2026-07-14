@extends('admin.layouts.app')
@section('title', 'Salary Advances')
@section('page_title', 'Salary Advances / Loans')

@section('content')
<div class="grid-2" style="align-items:start;">
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-cash-coin"></i> Record New Advance</h2>
            <a href="{{ route('admin.salaries.dashboard') }}" class="btn btn-outline btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div style="padding:1.5rem;">
            <form method="POST" action="{{ route('admin.salaries.advances.store') }}" style="display:grid; grid-template-columns: repeat(12, 1fr); gap: 12px;">
                @csrf
                <div style="grid-column: span 12;">
                    <label style="font-size:12px; color:var(--text-light);">Teacher</label>
                    <select name="teacher_id" required style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                        <option value="">Select</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->teacher_id }} — {{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="grid-column: span 6;">
                    <label style="font-size:12px; color:var(--text-light);">Amount (PKR)</label>
                    <input type="number" step="0.01" min="0.01" name="amount" required style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                </div>
                <div style="grid-column: span 6;">
                    <label style="font-size:12px; color:var(--text-light);">Date</label>
                    <input type="date" name="advance_date" value="{{ now()->format('Y-m-d') }}" required style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                </div>
                <div style="grid-column: span 12;">
                    <label style="font-size:12px; color:var(--text-light);">Reason</label>
                    <input name="reason" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);" placeholder="Optional">
                </div>
                <div style="grid-column: span 12;">
                    <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-check2-circle"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-list-check"></i> Advances List</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Teacher</th>
                        <th>Date</th>
                        <th style="text-align:right;">Amount</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advances as $a)
                        <tr>
                            <td style="font-weight:700;">{{ $a->teacher->teacher_id ?? '' }} — {{ $a->teacher->name ?? 'Teacher' }}</td>
                            <td>{{ optional($a->advance_date)->format('M d, Y') }}</td>
                            <td style="text-align:right; font-weight:900; color:var(--primary);">PKR {{ number_format((float)$a->amount, 0) }}</td>
                            <td>
                                @if($a->status === 'open')
                                    <span class="badge badge-red">Open</span>
                                @else
                                    <span class="badge badge-green">Settled</span>
                                @endif
                            </td>
                            <td>{{ $a->reason ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center; padding:2rem; color:var(--text-light);">No advances.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 1rem 1.5rem;">
            {{ $advances->links() }}
        </div>
    </div>
</div>
@endsection

