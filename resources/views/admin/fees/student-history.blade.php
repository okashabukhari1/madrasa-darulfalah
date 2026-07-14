@extends('admin.layouts.app')
@section('title', 'Fee History')
@section('page_title', 'Fee History')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-clock-history"></i> {{ $student->user->name ?? 'Student' }} — {{ $student->student_id }}</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a class="btn btn-outline btn-sm" href="{{ route('admin.fees.index', ['student_id' => $student->student_id]) }}"><i class="bi bi-funnel"></i> Filter Ledger</a>
            <a class="btn btn-outline btn-sm" href="{{ route('admin.students.index') }}"><i class="bi bi-mortarboard"></i> Students</a>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr>
                        <td style="font-weight:700;">{{ $fee->reference_id }}</td>
                        <td style="font-weight:800; color:var(--primary);">PKR {{ number_format((float) $fee->amount, 0) }}</td>
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
                                <a href="{{ route('admin.fees.receipt', $fee->id) }}" class="btn btn-outline btn-xs" title="Receipt"><i class="bi bi-filetype-pdf"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:2rem; color:var(--text-light);">No transactions found.</td>
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

