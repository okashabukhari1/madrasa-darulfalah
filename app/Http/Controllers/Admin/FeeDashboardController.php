<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use Illuminate\Support\Facades\DB;

class FeeDashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $year = (int) $now->format('Y');

        $totalCollection = Fee::query()->where('status', 'paid')->sum('amount');
        $monthlyCollection = Fee::query()
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', (int) $now->format('m'))
            ->sum('amount');
        $yearlyCollection = Fee::query()
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->sum('amount');

        $monthlyReport = Fee::query()
            ->selectRaw('MONTH(payment_date) as month_num, SUM(amount) as total')
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->groupBy('month_num')
            ->orderBy('month_num')
            ->get()
            ->keyBy('month_num');

        $months = collect(range(1, 12))->map(function ($m) use ($monthlyReport) {
            $label = now()->setMonth($m)->format('M');
            $total = (float) ($monthlyReport[$m]->total ?? 0);
            return ['month' => $label, 'total' => $total];
        });

        $yearlyReport = Fee::query()
            ->selectRaw('YEAR(payment_date) as year_num, SUM(amount) as total')
            ->where('status', 'paid')
            ->groupBy('year_num')
            ->orderByDesc('year_num')
            ->limit(6)
            ->get();

        $paymentTypeBreakdown = Fee::query()
            ->select('payment_type', DB::raw('SUM(amount) as total'))
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->groupBy('payment_type')
            ->pluck('total', 'payment_type')
            ->toArray();

        $pieLabels = Fee::PAYMENT_TYPES;
        $pieData = array_map(fn ($t) => (float) ($paymentTypeBreakdown[$t] ?? 0), $pieLabels);

        return view('admin.fees.dashboard', [
            'totalCollection' => (float) $totalCollection,
            'monthlyCollection' => (float) $monthlyCollection,
            'yearlyCollection' => (float) $yearlyCollection,
            'months' => $months,
            'yearlyReport' => $yearlyReport,
            'pieLabels' => $pieLabels,
            'pieData' => $pieData,
            'year' => $year,
        ]);
    }
}

