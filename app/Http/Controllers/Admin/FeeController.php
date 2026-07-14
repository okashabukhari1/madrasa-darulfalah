<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class FeeController extends Controller
{
    public function lookupStudent(string $studentId)
    {
        $studentId = Str::of($studentId)->trim()->value();

        $student = Student::query()
            ->with(['user', 'teacher'])
            ->where('student_id', $studentId)
            ->first();

        if (!$student) {
            return response()->json(['ok' => false, 'message' => 'Student not found.'], 404);
        }

        return response()->json([
            'ok' => true,
            'student' => [
                'student_id' => $student->student_id,
                'name' => $student->user->name ?? $student->name,
                'phone' => $student->user->phone ?? $student->guardian_phone,
            ],
            'teacher' => $student->teacher ? [
                'teacher_id' => $student->teacher->teacher_id,
                'name' => $student->teacher->name,
            ] : null,
        ]);
    }

    public function index(Request $request)
    {
        $query = Fee::query()->with(['student.user', 'teacher.user'])->latest('payment_date');

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->string('student_id')->trim()->value());
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->string('teacher_id')->trim()->value());
        }
        if ($request->filled('status') && in_array($request->status, ['paid', 'pending'], true)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->date('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->date('to_date'));
        }

        $fees = $query->paginate(15)->withQueryString();

        return view('admin.fees.index', [
            'fees' => $fees,
            'paymentTypes' => Fee::PAYMENT_TYPES,
        ]);
    }

    public function create()
    {
        return view('admin.fees.create', [
            'paymentTypes' => Fee::PAYMENT_TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['required', 'string', 'exists:students,student_id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:' . implode(',', Fee::PAYMENT_TYPES)],
            'status' => ['nullable', 'in:paid,pending'],
            'payment_date' => ['required', 'date'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'check_no' => ['nullable', 'string', 'max:100'],
            'bank' => ['nullable', 'string', 'max:100'],
        ]);

        if (($request->filled('check_no') xor $request->filled('bank'))) {
            return back()->withErrors(['check_no' => 'Check no and bank must be provided together.', 'bank' => 'Bank and check no must be provided together.'])->withInput();
        }

        $student = Student::query()->with(['user', 'teacher'])->where('student_id', $data['student_id'])->firstOrFail();
        $teacher = $student->teacher;

        $name = $data['name'] ?? ($student->user->name ?? $student->name ?? 'Student');
        $phone = $data['phone'] ?? ($student->user->phone ?? $student->guardian_phone ?? null);

        $fee = new Fee();
        $fee->student_id = $student->student_id;
        $fee->teacher_id = $teacher?->teacher_id; // auto from student's assigned teacher
        $fee->name = $name;
        $fee->phone = $phone;
        $fee->amount = $data['amount'];
        $fee->payment_type = $data['payment_type'];
        $fee->status = $data['status'] ?? 'paid';
        $fee->check_no = Arr::get($data, 'check_no');
        $fee->bank = Arr::get($data, 'bank');
        $fee->payment_date = $data['payment_date'];
        $fee->reference_id = Fee::generateReferenceId((int) date('Y', strtotime($data['payment_date'])));
        $fee->save();

        ActivityLog::log('fee.create', "Fee created: {$fee->reference_id} ({$fee->payment_type})", $fee);

        return redirect()->route('admin.fees.show', $fee->id)->with('success', 'Fee recorded successfully.');
    }

    public function show(Fee $fee)
    {
        $fee->load(['student.user', 'teacher.user']);

        return view('admin.fees.show', [
            'fee' => $fee,
        ]);
    }

    public function edit(Fee $fee)
    {
        $fee->load(['student.user', 'teacher.user']);

        return view('admin.fees.edit', [
            'fee' => $fee,
            'paymentTypes' => Fee::PAYMENT_TYPES,
        ]);
    }

    public function update(Request $request, Fee $fee)
    {
        $data = $request->validate([
            'student_id' => ['required', 'string', 'exists:students,student_id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:' . implode(',', Fee::PAYMENT_TYPES)],
            'status' => ['required', 'in:paid,pending'],
            'payment_date' => ['required', 'date'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'check_no' => ['nullable', 'string', 'max:100'],
            'bank' => ['nullable', 'string', 'max:100'],
        ]);

        if (($request->filled('check_no') xor $request->filled('bank'))) {
            return back()->withErrors(['check_no' => 'Check no and bank must be provided together.', 'bank' => 'Bank and check no must be provided together.'])->withInput();
        }

        $student = Student::query()->with('teacher')->where('student_id', $data['student_id'])->firstOrFail();
        $fee->student_id = $student->student_id;
        $fee->teacher_id = $student->teacher?->teacher_id; // always derived from student
        $fee->amount = $data['amount'];
        $fee->payment_type = $data['payment_type'];
        $fee->status = $data['status'];
        $fee->payment_date = $data['payment_date'];
        $fee->name = $data['name'] ?? $fee->name;
        $fee->phone = $data['phone'] ?? $fee->phone;
        $fee->bank = Arr::get($data, 'bank');
        $fee->check_no = Arr::get($data, 'check_no');
        $fee->save();

        ActivityLog::log('fee.update', "Fee updated: {$fee->reference_id}", $fee);

        return redirect()->route('admin.fees.show', $fee->id)->with('success', 'Fee updated successfully.');
    }

    public function destroy(Fee $fee)
    {
        $ref = $fee->reference_id;
        $fee->delete();

        ActivityLog::log('fee.delete', "Fee deleted: {$ref}");

        return redirect()->route('admin.fees.index')->with('success', "Fee record {$ref} deleted.");
    }

    public function receipt(Fee $fee)
    {
        $fee->load(['student.user', 'teacher.user']);

        ActivityLog::log('fee.receipt', "Receipt downloaded: {$fee->reference_id}", $fee);

        $pdf = Pdf::loadView('admin.fees.receipt', ['fee' => $fee])->setPaper('a5', 'portrait');
        return $pdf->download("receipt-{$fee->reference_id}.pdf");
    }

    public function studentHistory(string $studentId, Request $request)
    {
        $student = Student::query()->with('user')->where('student_id', $studentId)->firstOrFail();

        $fees = Fee::query()
            ->where('student_id', $studentId)
            ->with(['teacher.user'])
            ->latest('payment_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.fees.student-history', [
            'student' => $student,
            'fees' => $fees,
        ]);
    }

    public function exportCsv(Request $request)
    {
        $query = Fee::query()->with(['student.user', 'teacher.user'])->latest('payment_date');

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->string('student_id')->trim()->value());
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->string('teacher_id')->trim()->value());
        }
        if ($request->filled('status') && in_array($request->status, ['paid', 'pending'], true)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->date('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->date('to_date'));
        }

        $rows = $query->get();

        ActivityLog::log('fee.export_csv', 'Fees exported to CSV');

        $filename = 'fees-export-' . now()->format('Ymd-His') . '.csv';

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Reference ID', 'Student ID', 'Teacher ID', 'Name', 'Phone', 'Amount', 'Payment Type', 'Status', 'Payment Date', 'Bank', 'Check No']);

            foreach ($rows as $fee) {
                fputcsv($out, [
                    $fee->reference_id,
                    $fee->student_id,
                    $fee->teacher_id,
                    $fee->name,
                    $fee->phone,
                    (string) $fee->amount,
                    $fee->payment_type,
                    $fee->status,
                    optional($fee->payment_date)->format('Y-m-d'),
                    $fee->bank,
                    $fee->check_no,
                ]);
            }

            fclose($out);
        };

        return Response::streamDownload($callback, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportPdf(Request $request)
    {
        $query = Fee::query()->latest('payment_date');

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->string('student_id')->trim()->value());
        }
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->string('teacher_id')->trim()->value());
        }
        if ($request->filled('status') && in_array($request->status, ['paid', 'pending'], true)) {
            $query->where('status', $request->status);
        }
        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->date('from_date'));
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->date('to_date'));
        }

        $fees = $query->get();
        $total = (float) $fees->where('status', 'paid')->sum('amount');

        ActivityLog::log('fee.export_pdf', 'Fees exported to PDF');

        $pdf = Pdf::loadView('admin.fees.export-pdf', [
            'fees' => $fees,
            'total' => $total,
            'filters' => $request->only(['student_id', 'teacher_id', 'status', 'from_date', 'to_date']),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('fees-report-' . now()->format('Ymd-His') . '.pdf');
    }
}

