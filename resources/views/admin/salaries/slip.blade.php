<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Salary Slip</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#0f172a; font-size: 12px; }
        .wrap { border: 2px solid #2d6a4f; border-radius: 12px; padding: 16px; }
        .head { display:flex; justify-content:space-between; align-items:flex-end; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 12px; }
        .title { font-size: 16px; font-weight: 900; color:#2d6a4f; margin:0; }
        .sub { color:#64748b; margin:4px 0 0; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border: 1px solid #e2e8f0; padding: 8px; }
        th { background:#f1f5f9; text-align:left; }
        .right { text-align:right; }
        .net { font-size: 14px; font-weight: 900; color:#1b4332; }
        .badge { display:inline-block; padding: 2px 8px; border-radius: 999px; font-size: 10px; font-weight: 700; }
        .paid { background:#dcfce7; color:#166534; }
        .draft { background:#fff7ed; color:#92400e; border:1px solid #f59e0b; }
        .foot { margin-top: 12px; text-align:center; color:#2d6a4f; font-weight:700; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="head">
            <div>
                <p class="title">Madrasa Dar-ul-Falah — Salary Slip</p>
                <p class="sub">Teacher: {{ $payout->teacher->teacher_id }} — {{ $payout->teacher->name }}</p>
            </div>
            <div style="text-align:right;">
                <div><strong>Period:</strong> {{ $payout->year }}/{{ str_pad((string)$payout->month,2,'0',STR_PAD_LEFT) }}</div>
                <div>
                    <strong>Status:</strong>
                    @if($payout->status === 'paid')
                        <span class="badge paid">Paid</span>
                    @else
                        <span class="badge draft">Draft</span>
                    @endif
                </div>
                @if($payout->paid_date)
                    <div><strong>Paid date:</strong> {{ optional($payout->paid_date)->format('d M Y') }}</div>
                @endif
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="right">Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Base Salary</td>
                    <td class="right">PKR {{ number_format((float)$payout->base_salary, 0) }}</td>
                </tr>
                <tr>
                    <td>Attendance Amount</td>
                    <td class="right">PKR {{ number_format((float)$payout->attendance_amount, 0) }}</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td class="right">PKR {{ number_format((float)$payout->bonus, 0) }}</td>
                </tr>
                <tr>
                    <td>Advance Deduction</td>
                    <td class="right">- PKR {{ number_format((float)$payout->advance_deduction, 0) }}</td>
                </tr>
                <tr>
                    <td>Other Deduction</td>
                    <td class="right">- PKR {{ number_format((float)$payout->other_deduction, 0) }}</td>
                </tr>
                <tr>
                    <td><strong>Net Pay</strong></td>
                    <td class="right net">PKR {{ number_format((float)$payout->net_pay, 0) }}</td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top:10px; color:#64748b;">
            Attendance summary: Present {{ $payout->present_days }}, Late {{ $payout->late_days }}, Absent {{ $payout->absent_days }}.
        </div>

        <div class="foot">JazakAllah Khair</div>
    </div>
</body>
</html>

