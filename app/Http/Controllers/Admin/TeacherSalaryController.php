<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\TeacherSalaryAdvance;
use App\Models\TeacherSalaryPayout;
use App\Models\TeacherSalaryProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherSalaryController extends Controller
{
    public function dashboard(Request $request)
    {
        $year = (int) ($request->get('year') ?: now()->format('Y'));
        $month = (int) ($request->get('month') ?: now()->format('m'));

        $paidTotal = TeacherSalaryPayout::query()
            ->where('status', 'paid')
            ->where('year', $year)
            ->where('month', $month)
            ->sum('net_pay');

        $draftTotal = TeacherSalaryPayout::query()
            ->where('status', 'draft')
            ->where('year', $year)
            ->where('month', $month)
            ->sum('net_pay');

        $openAdvances = TeacherSalaryAdvance::query()->where('status', 'open')->sum('amount');

        $recentPayouts = TeacherSalaryPayout::query()
            ->with('teacher')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.salaries.dashboard', compact('year', 'month', 'paidTotal', 'draftTotal', 'openAdvances', 'recentPayouts'));
    }

    public function profiles()
    {
        $teachers = Teacher::query()
            ->with('salaryProfile')
            ->orderBy('name')
            ->get();

        return view('admin.salaries.profiles', compact('teachers'));
    }

    public function saveProfile(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'base_salary' => ['required', 'numeric', 'min:0'],
            'per_present_day' => ['required', 'numeric', 'min:0'],
            'per_late_day' => ['required', 'numeric', 'min:0'],
            'per_absent_day' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
        ]);
        $data['is_active'] = $request->has('is_active');

        TeacherSalaryProfile::updateOrCreate(
            ['teacher_id' => $teacher->id],
            $data
        );

        ActivityLog::log('salary.profile', "Salary profile updated for {$teacher->teacher_id}", $teacher);

        return back()->with('success', 'Salary profile saved.');
    }

    public function advances(Request $request)
    {
        $advances = TeacherSalaryAdvance::query()
            ->with('teacher')
            ->latest('advance_date')
            ->paginate(20);

        $teachers = Teacher::query()->orderBy('name')->get();

        return view('admin.salaries.advances', compact('advances', 'teachers'));
    }

    public function storeAdvance(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'advance_date' => ['required', 'date'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        $advance = TeacherSalaryAdvance::create($data);
        ActivityLog::log('salary.advance', "Advance recorded for teacher_id={$data['teacher_id']}", $advance);

        return back()->with('success', 'Advance saved.');
    }

    public function payouts(Request $request)
    {
        $year = (int) ($request->get('year') ?: now()->format('Y'));
        $month = (int) ($request->get('month') ?: now()->format('m'));

        $payouts = TeacherSalaryPayout::query()
            ->with('teacher')
            ->where('year', $year)
            ->where('month', $month)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $teachers = Teacher::query()->with('salaryProfile')->orderBy('name')->get();

        return view('admin.salaries.payouts', compact('payouts', 'teachers', 'year', 'month'));
    }

    public function generatePayout(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $teacher = Teacher::query()->with('salaryProfile')->findOrFail($data['teacher_id']);
        $profile = $teacher->salaryProfile;

        if (!$profile || !$profile->is_active) {
            return back()->with('error', 'Salary profile not set/active for this teacher.');
        }

        $start = now()->setYear($data['year'])->setMonth($data['month'])->startOfMonth()->toDateString();
        $end = now()->setYear($data['year'])->setMonth($data['month'])->endOfMonth()->toDateString();

        $counts = Attendance::query()
            ->where('teacher_id', $teacher->id)
            ->whereBetween('date', [$start, $end])
            ->selectRaw("SUM(status='present') as present_days, SUM(status='late') as late_days, SUM(status='absent') as absent_days")
            ->first();

        $present = (int) ($counts->present_days ?? 0);
        $late = (int) ($counts->late_days ?? 0);
        $absent = (int) ($counts->absent_days ?? 0);

        $attendanceAmount =
            ($present * (float) $profile->per_present_day) +
            ($late * (float) $profile->per_late_day) +
            ($absent * (float) $profile->per_absent_day);

        $openAdvanceTotal = (float) TeacherSalaryAdvance::query()
            ->where('teacher_id', $teacher->id)
            ->where('status', 'open')
            ->sum('amount');

        $net = (float) $profile->base_salary + (float) $attendanceAmount - (float) $openAdvanceTotal;
        if ($net < 0) $net = 0;

        $payout = TeacherSalaryPayout::updateOrCreate(
            ['teacher_id' => $teacher->id, 'year' => $data['year'], 'month' => $data['month']],
            [
                'present_days' => $present,
                'late_days' => $late,
                'absent_days' => $absent,
                'base_salary' => $profile->base_salary,
                'attendance_amount' => $attendanceAmount,
                'advance_deduction' => $openAdvanceTotal,
                'other_deduction' => 0,
                'bonus' => 0,
                'net_pay' => $net,
                'status' => 'draft',
            ]
        );

        ActivityLog::log('salary.generate', "Salary generated for {$teacher->teacher_id} {$data['year']}-{$data['month']}", $payout);

        return redirect()->route('admin.salaries.payouts', ['year' => $data['year'], 'month' => $data['month']])
            ->with('success', 'Salary payout generated (draft).');
    }

    public function markPaid(Request $request, TeacherSalaryPayout $payout)
    {
        $request->validate([
            'paid_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($payout, $request) {
            $payout->status = 'paid';
            $payout->paid_date = $request->date('paid_date');
            $payout->save();

            // Mark advances settled (simple approach: if a payout included advance deduction, close all open advances)
            if ((float) $payout->advance_deduction > 0) {
                TeacherSalaryAdvance::query()
                    ->where('teacher_id', $payout->teacher_id)
                    ->where('status', 'open')
                    ->update(['status' => 'settled']);
            }
        });

        ActivityLog::log('salary.paid', "Salary marked paid payout_id={$payout->id}", $payout);
        return back()->with('success', 'Marked as paid.');
    }

    public function slipPdf(TeacherSalaryPayout $payout)
    {
        $payout->load('teacher');

        ActivityLog::log('salary.slip', "Salary slip PDF downloaded payout_id={$payout->id}", $payout);

        $pdf = Pdf::loadView('admin.salaries.slip', ['payout' => $payout])->setPaper('a4', 'portrait');
        return $pdf->download("salary-slip-{$payout->teacher->teacher_id}-{$payout->year}-" . str_pad((string)$payout->month, 2, '0', STR_PAD_LEFT) . ".pdf");
    }
}

