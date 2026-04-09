<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        $courses = $teacher->courses()->withCount('students')->get();

        return view('teacher.attendance.index', compact('courses'));
    }

    public function mark($course_id)
    {
        $teacher = Auth::user()->teacher;
        $course = Course::where('id', $course_id)
            ->where('teacher_id', $teacher->id)
            ->with('students.user')
            ->firstOrFail();

        $date = request('date', date('Y-m-d'));
        
        // Check if attendance already exists for this date
        $existingAttendance = Attendance::where('course_id', $course->id)
            ->whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.mark', compact('course', 'date', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'date' => 'required|date|before_or_equal:today',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        $teacher = Auth::user()->teacher;
        $course = Course::where('id', $request->course_id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        foreach ($request->attendance as $data) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $data['student_id'],
                    'course_id' => $course->id,
                    'date' => $request->date,
                ],
                [
                    'teacher_id' => $teacher->id,
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                ]
            );
        }

        return redirect()->route('teacher.attendance.mark', ['course_id' => $course->id, 'date' => $request->date])
            ->with('success', 'Attendance marked successfully.');
    }

    public function history()
    {
        $teacher = Auth::user()->teacher;
        $course_id = request('course_id');
        $date = request('date');

        $query = Attendance::where('teacher_id', $teacher->id)
            ->with(['student.user', 'course'])
            ->latest('date');

        if ($course_id) {
            $query->where('course_id', $course_id);
        }
        if ($date) {
            $query->whereDate('date', $date);
        }

        $attendances = $query->paginate(20);
        $courses = $teacher->courses;

        return view('teacher.attendance.history', compact('attendances', 'courses'));
    }
}
