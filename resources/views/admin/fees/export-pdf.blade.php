<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fees Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#0f172a; font-size: 12px; }
        .head { display:flex; justify-content:space-between; align-items:flex-end; border-bottom: 2px solid #2d6a4f; padding-bottom: 10px; margin-bottom: 12px; }
        .title { font-size: 16px; font-weight: 900; color:#2d6a4f; margin:0; }
        .sub { color:#64748b; margin:4px 0 0; }
        table { width:100%; border-collapse: collapse; }
        th, td { border: 1px solid #e2e8f0; padding: 6px 8px; }
        th { background:#f1f5f9; text-align:left; }
        .right { text-align:right; }
        .badge { display:inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; }
        .paid { background:#dcfce7; color:#166534; }
        .pending { background:#fee2e2; color:#991b1b; }
        .type { background:#fff7ed; color:#92400e; border:1px solid #f59e0b; }
        .total { margin-top: 12px; font-size: 13px; font-weight: 900; color:#1b4332; text-align:right; }
        .filters { font-size: 10px; color:#64748b; }
    </style>
</head>
<body>
    <div class="head">
        <div>
            <p class="title">Madrasa Dar-ul-Falah — Fees Report</p>
            <p class="sub">Generated: {{ now()->format('d M Y, h:i A') }}</p>
            <div class="filters">
                Filters:
                Student: {{ $filters['student_id'] ?? 'Any' }},
                Teacher: {{ $filters['teacher_id'] ?? 'Any' }},
                Status: {{ $filters['status'] ?? 'Any' }},
                From: {{ $filters['from_date'] ?? 'Any' }},
                To: {{ $filters['to_date'] ?? 'Any' }}
            </div>
        </div>
        <div style="text-align:right;">
            <div><strong>Total Paid:</strong> PKR {{ number_format((float) $total, 0) }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Student</th>
                <th>Teacher</th>
                <th>Type</th>
                <th>Status</th>
                <th>Date</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $fee)
                <tr>
                    <td>{{ $fee->reference_id }}</td>
                    <td>{{ $fee->student_id }} — {{ $fee->name }}</td>
                    <td>{{ $fee->teacher_id ?? '—' }}</td>
                    <td><span class="badge type">{{ $fee->payment_type }}</span></td>
                    <td>
                        @if($fee->status === 'paid')
                            <span class="badge paid">Paid</span>
                        @else
                            <span class="badge pending">Pending</span>
                        @endif
                    </td>
                    <td>{{ optional($fee->payment_date)->format('Y-m-d') }}</td>
                    <td class="right">PKR {{ number_format((float) $fee->amount, 0) }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align:center; padding:14px; color:#64748b;">No records.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">Total Paid Revenue: PKR {{ number_format((float) $total, 0) }}</div>
</body>
</html>

