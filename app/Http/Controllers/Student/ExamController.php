<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        
        $query = Exam::where('student_id', $student->id)->with('teacher');

        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }
        if ($request->filled('exam_type')) {
            $query->where('exam_type', $request->exam_type);
        }

        $exams = $query->latest('date')->paginate(15);

        // Simple analytics for the student
        $totalMistakes = $student->exams()->sum('mistakes');
        $averageFluency = $student->exams()->avg('fluency');
        $averageTajweed = $student->exams()->avg('tajweed');

        return view('student.exams', compact('exams', 'totalMistakes', 'averageFluency', 'averageTajweed'));
    }
}
