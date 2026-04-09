<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        $attendances = Attendance::where('student_id', $student->id)
            ->with(['course', 'teacher'])
            ->latest('date')
            ->paginate(15);

        $stats = [
            'total' => Attendance::where('student_id', $student->id)->count(),
            'present' => Attendance::where('student_id', $student->id)->where('status', 'present')->count(),
            'absent' => Attendance::where('student_id', $student->id)->where('status', 'absent')->count(),
            'late' => Attendance::where('student_id', $student->id)->where('status', 'late')->count(),
        ];

        $percentage = $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100) : 0;

        return view('student.attendance.index', compact('attendances', 'stats', 'percentage'));
    }
}
