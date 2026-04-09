<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $teachers = Teacher::all();
        $date = request('date');
        $course_id = request('course_id');
        $program = request('program');
        $teacher_id = request('teacher_id');

        $query = Attendance::with(['student.user', 'course', 'teacher'])->latest('date');

        if ($date) {
            $query->whereDate('date', $date);
        }
        if ($course_id) {
            $query->where('course_id', $course_id);
        }
        if ($program) {
            $query->whereHas('student', function($q) use ($program) {
                $q->where('program', $program);
            });
        }
        if ($teacher_id) {
            $query->where('teacher_id', $teacher_id);
        }

        $attendances = $query->paginate(30);

        return view('admin.attendance.index', compact('attendances', 'courses', 'teachers'));
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record deleted successfully.');
    }
}
