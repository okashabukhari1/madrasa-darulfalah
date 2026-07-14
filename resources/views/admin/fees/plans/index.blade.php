@extends('admin.layouts.app')
@section('title', 'Fee Plans')
@section('page_title', 'Fee Plans (Monthly Dues)')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-diagram-3"></i> Monthly Fee Plans</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.dashboard') }}"><i class="bi bi-speedometer2"></i> Fees Dashboard</a>
            <a class="btn btn-gold btn-sm" href="{{ route('admin.fees.plans.create') }}"><i class="bi bi-plus-circle"></i> Create Plan</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Class</th>
                    <th>Course</th>
                    <th style="text-align:right;">Monthly Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($plans as $plan)
                    <tr>
                        <td style="font-weight:700;">{{ $plan->name }}</td>
                        <td>{{ $plan->program ? strtoupper($plan->program) : 'Any' }}</td>
                        <td>{{ $plan->class ?? 'Any' }}</td>
                        <td>{{ $plan->course_id ?? 'Any' }}</td>
                        <td style="text-align:right; font-weight:800; color:var(--primary);">PKR {{ number_format((float)$plan->monthly_amount, 0) }}</td>
                        <td>
                            @if($plan->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-gray">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="{{ route('admin.fees.plans.edit', $plan->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.fees.plans.destroy', $plan->id) }}" method="POST" onsubmit="return confirm('Delete this fee plan?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-xs" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; padding:2rem; color:var(--text-light);">No fee plans yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem;">
        {{ $plans->links() }}
    </div>
</div>

<div class="db-card" style="margin-top:18px;">
    <div class="db-card-header">
        <h2><i class="bi bi-lightning-charge"></i> How auto-generation works</h2>
    </div>
    <div style="padding:1rem 1.5rem; color:var(--text-light); line-height:1.6;">
        The system runs a scheduled command on the <strong>1st of every month</strong> to create <strong>monthly dues</strong> for <strong>active</strong> students.
        It is <strong>idempotent</strong> (won’t create duplicates because dues are unique per student/month/year).
        You can also run it manually:
        <div style="margin-top:10px; background:rgba(0,0,0,.04); border:1px solid rgba(0,0,0,.06); padding:10px; border-radius:10px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;">
            php artisan fees:generate-monthly-dues --year=2026 --month=4
        </div>
    </div>
</div>
@endsection

