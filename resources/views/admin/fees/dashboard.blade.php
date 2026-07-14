@extends('admin.layouts.app')
@section('title', 'Fees Dashboard')
@section('page_title', 'Fees & Financial Dashboard')

@section('content')
<div class="welcome-banner" style="margin-bottom:16px;">
    <div>
        <h2 style="margin:0;">Fees & Financial Management</h2>
        <p style="margin:6px 0 0;">Centralized collection, reporting, and receipts ({{ $year }}).</p>
    </div>
    <div class="wb-actions">
        <a href="{{ route('admin.fees.index') }}" class="btn btn-outline btn-sm" style="color:#fff;border-color:rgba(255,255,255,.4);"><i class="bi bi-list-check"></i> All Records</a>
        <a href="{{ route('admin.fees.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-circle"></i> Record Fee</a>
    </div>
</div>

<div class="stats-grid" style="margin-bottom:24px;">
    <div class="stat-card green">
        <div class="stat-icon"><i class="bi bi-cash-stack"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($totalCollection, 0) }}</h3>
            <p>Total Collection (PKR)</p>
            <div class="stat-change up">All-time paid</div>
        </div>
    </div>
    <div class="stat-card gold">
        <div class="stat-icon"><i class="bi bi-calendar2-month"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($monthlyCollection, 0) }}</h3>
            <p>Monthly Collection (PKR)</p>
            <div class="stat-change up">Current month</div>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="bi bi-calendar2-week"></i></div>
        <div class="stat-info">
            <h3>{{ number_format($yearlyCollection, 0) }}</h3>
            <p>Yearly Collection (PKR)</p>
            <div class="stat-change up">{{ $year }}</div>
        </div>
    </div>
</div>

<div class="grid-2" style="align-items:start;">
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-bar-chart"></i> Monthly Report ({{ $year }})</h2>
            <a href="{{ route('admin.fees.index') }}" class="btn btn-outline btn-xs">View Records</a>
        </div>
        <div class="db-card-body">
            <div class="table-wrap" style="max-height:360px; overflow:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th style="text-align:right;">Total (PKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($months as $row)
                            <tr>
                                <td>{{ $row['month'] }}</td>
                                <td style="text-align:right; font-weight:600;">{{ number_format($row['total'], 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="display:flex; flex-direction:column; gap:24px;">
        <div class="db-card">
            <div class="db-card-header">
                <h2><i class="bi bi-pie-chart"></i> Payment Type Distribution</h2>
                <span class="badge badge-gold">{{ $year }}</span>
            </div>
            <div class="db-card-body" style="padding:18px;">
                <canvas id="paymentTypePie" height="240"></canvas>
            </div>
        </div>

        <div class="db-card">
            <div class="db-card-header">
                <h2><i class="bi bi-graph-up"></i> Yearly Totals</h2>
            </div>
            <div class="db-card-body">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Year</th>
                                <th style="text-align:right;">Total (PKR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($yearlyReport as $y)
                                <tr>
                                    <td>{{ $y->year_num }}</td>
                                    <td style="text-align:right; font-weight:600;">{{ number_format((float) $y->total, 0) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" style="text-align:center; color:var(--text-light); padding:18px;">No data yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(() => {
    const ctx = document.getElementById('paymentTypePie');
    if (!ctx) return;

    const labels = @json($pieLabels);
    const data = @json($pieData);
    const colors = [
        '#2d6a4f', // green
        '#d4af37', // gold
        '#1d4ed8', // blue
        '#ef4444', // red
        '#0ea5e9', // sky
        '#a855f7', // purple
        '#64748b'  // slate
    ];

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data,
                backgroundColor: colors.slice(0, labels.length),
                borderColor: 'rgba(255,255,255,0.85)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: (item) => `${item.label}: PKR ${Number(item.raw || 0).toLocaleString()}`
                    }
                }
            }
        }
    });
})();
</script>
@endpush

