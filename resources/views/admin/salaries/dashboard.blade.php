@extends('admin.layouts.app')
@section('title', 'Teacher Salaries')
@section('page_title', 'Teacher Salaries Dashboard')

@section('content')
<div class="welcome-banner" style="margin-bottom:16px;">
    <div>
        <h2 style="margin:0;">Teacher Salary Management</h2>
        <p style="margin:6px 0 0;">Salary profiles, advances, attendance-based payouts, and slips.</p>
    </div>
    <div class="wb-actions">
        <a href="{{ route('admin.salaries.profiles') }}" class="btn btn-outline btn-sm" style="color:#fff;border-color:rgba(255,255,255,.4);"><i class="bi bi-sliders"></i> Salary Profiles</a>
        <a href="{{ route('admin.salaries.payouts', ['year'=>$year,'month'=>$month]) }}" class="btn btn-gold btn-sm"><i class="bi bi-cash-stack"></i> Payouts</a>
    </div>
</div>

<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card green">
        <div class="stat-icon"><i class="bi bi-check2-circle"></i></div>
        <div class="stat-info">
            <h3>{{ number_format((float)$paidTotal, 0) }}</h3>
            <p>Paid (PKR) — {{ $year }}/{{ str_pad((string)$month,2,'0',STR_PAD_LEFT) }}</p>
            <div class="stat-change up">Completed payouts</div>
        </div>
    </div>
    <div class="stat-card gold">
        <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
        <div class="stat-info">
            <h3>{{ number_format((float)$draftTotal, 0) }}</h3>
            <p>Draft (PKR) — {{ $year }}/{{ str_pad((string)$month,2,'0',STR_PAD_LEFT) }}</p>
            <div class="stat-change up">Generated, not paid</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon"><i class="bi bi-exclamation-circle"></i></div>
        <div class="stat-info">
            <h3>{{ number_format((float)$openAdvances, 0) }}</h3>
            <p>Open Advances (PKR)</p>
            <div class="stat-change down">Pending deductions</div>
        </div>
    </div>
</div>

<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-clock-history"></i> Recent Payouts</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.salaries.advances') }}" class="btn btn-outline btn-sm"><i class="bi bi-cash-coin"></i> Advances</a>
            <a href="{{ route('admin.salaries.payouts') }}" class="btn btn-outline btn-sm"><i class="bi bi-list-check"></i> All Payouts</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th>Period</th>
                    <th>Status</th>
                    <th style="text-align:right;">Net Pay</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPayouts as $p)
                    <tr>
                        <td style="font-weight:700;">{{ $p->teacher->teacher_id ?? '' }} — {{ $p->teacher->name ?? 'Teacher' }}</td>
                        <td>{{ $p->year }}/{{ str_pad((string)$p->month,2,'0',STR_PAD_LEFT) }}</td>
                        <td>
                            @if($p->status === 'paid')
                                <span class="badge badge-green">Paid</span>
                            @else
                                <span class="badge badge-gold">Draft</span>
                            @endif
                        </td>
                        <td style="text-align:right; font-weight:900; color:var(--primary);">PKR {{ number_format((float)$p->net_pay, 0) }}</td>
                        <td>
                            <a href="{{ route('admin.salaries.payouts.slip', $p->id) }}" class="btn btn-outline btn-xs" title="Slip PDF"><i class="bi bi-filetype-pdf"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center; padding:2rem; color:var(--text-light);">No payouts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

