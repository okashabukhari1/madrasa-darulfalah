@extends('admin.layouts.app')
@section('title', 'Fees Records')
@section('page_title', 'Fees Records')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-cash-coin"></i> Fees & Donations Ledger</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.export.csv', request()->query()) }}"><i class="bi bi-filetype-csv"></i> Export CSV</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.export.pdf', request()->query()) }}"><i class="bi bi-filetype-pdf"></i> Export PDF</a>
            <a class="btn btn-gold btn-sm" href="{{ route('admin.fees.create') }}"><i class="bi bi-plus-circle"></i> Record Fee</a>
        </div>
    </div>

    <div style="padding: 0 1.5rem 1rem;">
        <form method="GET" action="{{ route('admin.fees.index') }}" style="display:grid; grid-template-columns: repeat(12, 1fr); gap: 12px; align-items:end;">
            <div style="grid-column: span 3;">
                <label style="font-size:12px; color: var(--text-light);">Student ID (STD000001)</label>
                <input name="student_id" value="{{ request('student_id') }}" class="form-control" placeholder="STD000001" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>
            <div style="grid-column: span 3;">
                <label style="font-size:12px; color: var(--text-light);">Teacher ID (TH00001)</label>
                <input name="teacher_id" value="{{ request('teacher_id') }}" class="form-control" placeholder="TH0000001" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>
            <div style="grid-column: span 2;">
                <label style="font-size:12px; color: var(--text-light);">Status</label>
                <select name="status" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                    <option value="">All</option>
                    <option value="paid" @selected(request('status') === 'paid')>Paid</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                </select>
            </div>
            <div style="grid-column: span 2;">
                <label style="font-size:12px; color: var(--text-light);">From</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>
            <div style="grid-column: span 2;">
                <label style="font-size:12px; color: var(--text-light);">To</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 12; display:flex; gap:10px; flex-wrap:wrap;">
                <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-funnel"></i> Apply Filters</button>
                <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.index') }}"><i class="bi bi-x-circle"></i> Reset</a>
            </div>
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Reference ID</th>
                    <th>Student ID</th>
                    <th>Teacher ID</th>
                    <th>Name</th>
                    <th style="text-align:right;">Amount</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr>
                        <td style="font-weight:600;">{{ $fee->reference_id }}</td>
                        <td>
                            <a href="{{ route('admin.fees.student.history', $fee->student_id) }}" class="btn btn-outline btn-xs" style="padding:4px 8px;">
                                {{ $fee->student_id }}
                            </a>
                        </td>
                        <td>{{ $fee->teacher_id ?? '—' }}</td>
                        <td>
                            <div style="font-weight:600; color:var(--text-dark);">{{ $fee->name }}</div>
                            <small style="color:var(--text-light);">{{ $fee->phone }}</small>
                        </td>
                        <td style="text-align:right; font-weight:700;">{{ number_format((float) $fee->amount, 0) }} PKR</td>
                        <td><span class="badge badge-gold">{{ $fee->payment_type }}</span></td>
                        <td>
                            @if($fee->status === 'paid')
                                <span class="badge badge-green">Paid</span>
                            @else
                                <span class="badge badge-red">Pending</span>
                            @endif
                        </td>
                        <td>{{ optional($fee->payment_date)->format('M d, Y') }}</td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="{{ route('admin.fees.show', $fee->id) }}" class="btn btn-outline btn-xs" title="View"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.fees.edit', $fee->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="{{ route('admin.fees.receipt', $fee->id) }}" class="btn btn-outline btn-xs" title="PDF Receipt"><i class="bi bi-filetype-pdf"></i></a>
                                <button type="button"
                                        class="btn btn-outline btn-xs delete-fee-btn"
                                        style="color:#e53e3e; border-color:rgba(229,62,62,0.3);"
                                        title="Delete"
                                        data-id="{{ $fee->id }}"
                                        data-ref="{{ $fee->reference_id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <form id="delete-fee-form-{{ $fee->id }}" action="{{ route('admin.fees.destroy', $fee->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align:center; padding:2rem; color: var(--text-light);">No fee records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="padding: 1rem 1.5rem;">
        {{ $fees->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-fee-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const ref = this.getAttribute('data-ref');
        if (confirm(`Delete fee record "${ref}"? This cannot be undone.`)) {
            document.getElementById(`delete-fee-form-${id}`).submit();
        }
    });
});
</script>
@endpush

