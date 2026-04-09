<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            abort(403, 'No teacher profile linked to this account.');
        }

        $courses = $teacher->courses()->withCount('students')->paginate(10);
        return view('teacher.courses.index', compact('courses'));
    }

    public function show($slug)
    {
        $teacher = Auth::user()->teacher;
        $course = Course::where('slug', $slug)
            ->where('teacher_id', $teacher->id)
            ->with(['students.user', 'category'])
            ->withCount('students')
            ->firstOrFail();

        $recentAttendance = Attendance::where('course_id', $course->id)
            ->latest('date')
            ->take(5)
            ->get()
            ->groupBy(function($a) {
                return $a->date->format('Y-m-d');
            });

        return view('teacher.courses.show', [
            'course' => $course,
            'students' => $course->students,
            'recentAttendance' => $recentAttendance
        ]);
    }
}
