<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->student->courses()->with('teacher')->get();
        return view('student.courses.index', compact('courses'));
    }

    public function show(string $id)
    {
        $course = auth()->user()->student->courses()
            ->with(['teacher', 'category', 'materials'])
            ->findOrFail($id);
            
        return view('student.courses.show', compact('course'));
    }
}
