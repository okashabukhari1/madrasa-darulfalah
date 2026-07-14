@extends('admin.layouts.app')
@section('title', 'Fee Details')
@section('page_title', 'Fee Details')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-receipt"></i> {{ $fee->reference_id }}</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.fees.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
            <a href="{{ route('admin.fees.edit', $fee->id) }}" class="btn btn-outline btn-sm"><i class="bi bi-pencil"></i> Edit</a>
            <a href="{{ route('admin.fees.receipt', $fee->id) }}" class="btn btn-gold btn-sm"><i class="bi bi-filetype-pdf"></i> Download Receipt</a>
            <form action="{{ route('admin.fees.destroy', $fee->id) }}" method="POST" onsubmit="return confirm('Delete this fee record? This cannot be undone.');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline btn-sm" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div style="padding:1.5rem; display:grid; grid-template-columns: repeat(12, 1fr); gap: 14px;">
        <div style="grid-column: span 6;">
            <div style="color:var(--text-light); font-size:12px;">Student</div>
            <div style="font-weight:700; margin-top:4px;">{{ $fee->name }}</div>
            <div style="color:var(--text-light); margin-top:4px;">Student ID: <strong>{{ $fee->student_id }}</strong></div>
            <div style="color:var(--text-light); margin-top:4px;">Phone: <strong>{{ $fee->phone ?? '—' }}</strong></div>
            <div style="margin-top:10px;">
                <a href="{{ route('admin.fees.student.history', $fee->student_id) }}" class="btn btn-outline btn-xs"><i class="bi bi-clock-history"></i> Fee History</a>
            </div>
        </div>

        <div style="grid-column: span 6;">
            <div style="color:var(--text-light); font-size:12px;">Payment</div>
            <div style="margin-top:8px; display:flex; gap:10px; flex-wrap:wrap;">
                <span class="badge badge-gold">{{ $fee->payment_type }}</span>
                @if($fee->status === 'paid')
                    <span class="badge badge-green">Paid</span>
                @else
                    <span class="badge badge-red">Pending</span>
                @endif
            </div>
            <div style="margin-top:10px; font-size:28px; font-weight:900; color:var(--primary);">
                PKR {{ number_format((float) $fee->amount, 0) }}
            </div>
            <div style="color:var(--text-light); margin-top:6px;">Date: <strong>{{ optional($fee->payment_date)->format('M d, Y') }}</strong></div>

            <div style="margin-top:10px; color:var(--text-light);">
                Teacher ID: <strong>{{ $fee->teacher_id ?? '—' }}</strong>
            </div>
            @if($fee->bank || $fee->check_no)
                <div style="margin-top:8px; color:var(--text-light);">
                    Bank: <strong>{{ $fee->bank }}</strong> · Check No: <strong>{{ $fee->check_no }}</strong>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

