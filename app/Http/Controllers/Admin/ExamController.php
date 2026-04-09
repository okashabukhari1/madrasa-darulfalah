<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['student', 'teacher']);

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $exams = $query->latest('date')->paginate(20);
        $teachers = Teacher::orderBy('name')->get();
        $students = Student::orderBy('student_id')->get();

        // Analytics
        $totalExams = Exam::count();
        $avgFluency = Exam::avg('fluency');
        $avgTajweed = Exam::avg('tajweed');

        return view('admin.exams.index', compact('exams', 'teachers', 'students', 'totalExams', 'avgFluency', 'avgTajweed'));
    }

    public function edit(Exam $exam)
    {
        $students = Student::orderBy('student_id')->get();
        // Allow changing teacher as well if needed, but usually just evaluation details
        return view('admin.exams.edit', compact('exam', 'students'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('exams')->where(function ($query) use ($request) {
                    return $query->where('exam_type', $request->exam_type)
                                 ->where('date', $request->date);
                })->ignore($exam->id)
            ],
            'program'   => 'required|string|in:Hifz,Nazra,Qaida',
            'exam_type' => 'required|string|in:Daily,Weekly,Monthly,Completion,Yearly',
            'date'      => 'required|date',
            'para'      => 'nullable|integer|min:1|max:30',
            'surah'     => 'nullable|string|max:100',
            'ayah_from' => 'nullable|integer|min:1',
            'ayah_to'   => 'nullable|integer|gt:ayah_from',
            'mistakes'  => 'required|integer|min:0',
            'fluency'   => 'nullable|integer|min:1|max:5',
            'tajweed'   => 'nullable|integer|min:1|max:5',
            'grade'     => 'required|string|in:Excellent,Good,Average,Weak',
            'remarks'   => 'nullable|string|max:1000',
        ]);

        $exam->update($validated);
        return redirect()->route('admin.exams.index')->with('success', 'Exam evaluation manually updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam evaluation deleted successfully.');
    }
}
