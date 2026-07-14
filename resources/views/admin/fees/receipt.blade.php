<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $fee->reference_id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color:#0f172a; }
        .wrap { border: 2px solid #2d6a4f; border-radius: 12px; padding: 18px; }
        .header { text-align:center; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; }
        .title { font-size: 18px; font-weight: 800; color:#2d6a4f; margin:0; }
        .sub { font-size: 12px; color:#64748b; margin:6px 0 0; }
        .meta { display:flex; justify-content:space-between; margin-top: 12px; font-size: 12px; color:#334155; }
        .row { display:flex; justify-content:space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; }
        .row:last-child { border-bottom: none; }
        .label { color:#475569; }
        .val { font-weight: 700; }
        .amount { font-size: 22px; font-weight: 900; color:#1b4332; }
        .badge { display:inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight:700; }
        .paid { background:#dcfce7; color:#166534; }
        .pending { background:#fee2e2; color:#991b1b; }
        .type { background:#fff7ed; color:#92400e; border:1px solid #f59e0b; }
        .footer { text-align:center; margin-top: 14px; font-size: 12px; color:#2d6a4f; font-weight:700; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="header">
            <p class="title">Madrasa Dar-ul-Falah</p>
            <p class="sub">Fees & Donation Receipt</p>
        </div>

        <div class="meta">
            <div><strong>Reference:</strong> {{ $fee->reference_id }}</div>
            <div><strong>Date:</strong> {{ optional($fee->payment_date)->format('d M Y') }}</div>
        </div>

        <div style="margin-top: 14px;">
            <div class="row">
                <div class="label">Student Name</div>
                <div class="val">{{ $fee->name }}</div>
            </div>
            <div class="row">
                <div class="label">Student ID</div>
                <div class="val">{{ $fee->student_id }}</div>
            </div>
            <div class="row">
                <div class="label">Amount (PKR)</div>
                <div class="amount">PKR {{ number_format((float) $fee->amount, 0) }}</div>
            </div>
            <div class="row">
                <div class="label">Payment Type</div>
                <div class="val"><span class="badge type">{{ $fee->payment_type }}</span></div>
            </div>
            <div class="row">
                <div class="label">Status</div>
                <div class="val">
                    @if($fee->status === 'paid')
                        <span class="badge paid">Paid</span>
                    @else
                        <span class="badge pending">Pending</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">JazakAllah Khair</div>
    </div>
</body>
</html>

