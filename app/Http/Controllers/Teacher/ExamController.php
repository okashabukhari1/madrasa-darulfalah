<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('student')
            ->where('teacher_id', auth()->user()->teacher->id);

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }
        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        $exams = $query->latest('date')->paginate(15);
        $students = auth()->user()->teacher->assignedStudents;

        return view('teacher.exams.index', compact('exams', 'students'));
    }

    public function create()
    {
        $students = auth()->user()->teacher->assignedStudents;
        return view('teacher.exams.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('exams')->where(function ($query) use ($request) {
                    return $query->where('exam_type', $request->exam_type)
                                 ->where('date', $request->date);
                })
            ],
            'program'   => 'required|string|in:Hifz,Nazra,Qaida',
            'exam_type' => 'required|string|in:Daily,Weekly,Monthly,Completion',
            'date'      => 'required|date|before_or_equal:today',
            'para'      => 'nullable|integer|min:1|max:30',
            'surah'     => 'nullable|string|max:100',
            'ayah_from' => 'nullable|integer|min:1',
            'ayah_to'   => 'nullable|integer|gt:ayah_from',
            'mistakes'  => 'required|integer|min:0',
            'fluency'   => 'nullable|integer|min:1|max:5',
            'tajweed'   => 'nullable|integer|min:1|max:5',
            'grade'     => 'required|string|in:Excellent,Good,Average,Weak',
            'remarks'   => 'nullable|string|max:1000',
        ], [
            'student_id.unique' => 'An evaluation of this type already exists for this student on the selected date.'
        ]);

        $validated['teacher_id'] = auth()->user()->teacher->id;
        Exam::create($validated);

        return redirect()->route('teacher.exams.index')->with('success', 'Exam evaluation saved successfully.');
    }

    public function edit(Exam $exam)
    {
        // Ensure teacher owns this exam
        if ($exam->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }
        $students = auth()->user()->teacher->assignedStudents;
        return view('teacher.exams.edit', compact('exam', 'students'));
    }

    public function update(Request $request, Exam $exam)
    {
        if ($exam->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }

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
            'exam_type' => 'required|string|in:Daily,Weekly,Monthly,Completion',
            'date'      => 'required|date|before_or_equal:today',
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
        return redirect()->route('teacher.exams.index')->with('success', 'Exam evaluation updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        if ($exam->teacher_id !== auth()->user()->teacher->id) {
            abort(403);
        }
        $exam->delete();
        return redirect()->route('teacher.exams.index')->with('success', 'Exam evaluation deleted successfully.');
    }
}
