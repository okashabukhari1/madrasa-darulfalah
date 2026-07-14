@extends('admin.layouts.app')
@section('title', 'Salary Payouts')
@section('page_title', 'Salary Payouts')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-cash-stack"></i> Salary Payouts</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.salaries.dashboard') }}" class="btn btn-outline btn-sm"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="{{ route('admin.salaries.advances') }}" class="btn btn-outline btn-sm"><i class="bi bi-cash-coin"></i> Advances</a>
            <a href="{{ route('admin.salaries.profiles') }}" class="btn btn-outline btn-sm"><i class="bi bi-sliders"></i> Profiles</a>
        </div>
    </div>

    <div style="padding: 0 1.5rem 1rem;">
        <form method="GET" action="{{ route('admin.salaries.payouts') }}" style="display:flex; gap:10px; flex-wrap:wrap; align-items:end;">
            <div>
                <label style="font-size:12px; color: var(--text-light);">Year</label>
                <input type="number" name="year" value="{{ request('year', $year) }}" style="padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08); width:120px;">
            </div>
            <div>
                <label style="font-size:12px; color: var(--text-light);">Month</label>
                <input type="number" name="month" min="1" max="12" value="{{ request('month', $month) }}" style="padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08); width:120px;">
            </div>
            <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-funnel"></i> Apply</button>
        </form>
    </div>

    <div style="padding: 0 1.5rem 1rem;">
        <div style="background:rgba(0,0,0,.03); border:1px solid rgba(0,0,0,.06); padding:12px; border-radius:12px;">
            <form method="POST" action="{{ route('admin.salaries.payouts.generate') }}" style="display:flex; gap:10px; flex-wrap:wrap; align-items:end;">
                @csrf
                <div style="min-width: 260px;">
                    <label style="font-size:12px; color: var(--text-light);">Generate payout for teacher</label>
                    <select name="teacher_id" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                        <option value="">Select</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}">{{ $t->teacher_id }} — {{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="font-size:12px; color: var(--text-light);">Year</label>
                    <input type="number" name="year" value="{{ $year }}" style="padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08); width:120px;">
                </div>
                <div>
                    <label style="font-size:12px; color: var(--text-light);">Month</label>
                    <input type="number" name="month" min="1" max="12" value="{{ $month }}" style="padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08); width:120px;">
                </div>
                <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-lightning-charge"></i> Generate Draft</button>
            </form>
            <div style="margin-top:8px; color:var(--text-light); font-size:12px;">
                Uses attendance table for the selected month and applies the teacher's salary profile. Open advances are deducted.
            </div>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Attendance</th>
                    <th style="text-align:right;">Base</th>
                    <th style="text-align:right;">Attendance</th>
                    <th style="text-align:right;">Advance</th>
                    <th style="text-align:right;">Net Pay</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payouts as $p)
                    <tr>
                        <td style="font-weight:700;">{{ $p->teacher->teacher_id ?? '' }} — {{ $p->teacher->name ?? 'Teacher' }}</td>
                        <td>
                            <span class="badge badge-green">P: {{ $p->present_days }}</span>
                            <span class="badge badge-gold">L: {{ $p->late_days }}</span>
                            <span class="badge badge-red">A: {{ $p->absent_days }}</span>
                        </td>
                        <td style="text-align:right;">{{ number_format((float)$p->base_salary, 0) }}</td>
                        <td style="text-align:right;">{{ number_format((float)$p->attendance_amount, 0) }}</td>
                        <td style="text-align:right;">{{ number_format((float)$p->advance_deduction, 0) }}</td>
                        <td style="text-align:right; font-weight:900; color:var(--primary);">PKR {{ number_format((float)$p->net_pay, 0) }}</td>
                        <td>
                            @if($p->status === 'paid')
                                <span class="badge badge-green">Paid</span>
                            @else
                                <span class="badge badge-gold">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                                <a href="{{ route('admin.salaries.payouts.slip', $p->id) }}" class="btn btn-outline btn-xs" title="Slip PDF"><i class="bi bi-filetype-pdf"></i></a>
                                @if($p->status !== 'paid')
                                    <form method="POST" action="{{ route('admin.salaries.payouts.paid', $p->id) }}" style="display:flex; gap:6px; align-items:center;">
                                        @csrf
                                        <input type="date" name="paid_date" value="{{ now()->format('Y-m-d') }}" style="padding:6px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                                        <button class="btn btn-gold btn-xs" type="submit"><i class="bi bi-check2-circle"></i> Mark Paid</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" style="text-align:center; padding:2rem; color:var(--text-light);">No payouts for this period.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem;">
        {{ $payouts->links() }}
    </div>
</div>
@endsection

