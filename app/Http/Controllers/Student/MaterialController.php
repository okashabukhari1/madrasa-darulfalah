<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $courseIds = $student->courses()->pluck('courses.id');
        $materials = \App\Models\Material::whereIn('course_id', $courseIds)->with('course')->get();
        return view('student.materials', compact('materials'));
    }
}
