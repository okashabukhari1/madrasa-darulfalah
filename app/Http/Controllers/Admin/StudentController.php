<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->latest()->paginate(15);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $teachers = \App\Models\Teacher::all();
        $courses = \App\Models\Course::all();
        return view('admin.students.create', compact('teachers', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'nullable|string|max:255',
            'urdu_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'program' => 'required|in:hifz,nazra,qaida',
            'teacher_id' => 'nullable|exists:teachers,id',
            'course_id' => 'nullable|exists:courses,id',
            'phone' => 'nullable|string',
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name ?? $request->urdu_name ?? 'Student',
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'student',
                'phone'    => $request->phone,
                'email_verified_at' => now(),
            ]);

            $student = Student::create([
                'student_id'  => Student::generateStudentId(),
                'user_id'     => $user->id,
                'name'        => $request->name,
                'urdu_name'   => $request->urdu_name,
                'guardian_name' => $request->guardian_name,
                'guardian_phone' => $request->guardian_phone,
                'program' => $request->program,
                'teacher_id' => $request->teacher_id,
                'status'      => 'active',
            ]);

            if ($request->course_id) {
                $student->courses()->attach($request->course_id);
            }

            return redirect()->route('admin.students.index')->with('success', 'Student account and profile created successfully.');
        });
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::with('courses')->findOrFail($id);
        $teachers = \App\Models\Teacher::all();
        $courses = \App\Models\Course::all();
        return view('admin.students.edit', compact('student', 'teachers', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;

        $request->validate([
            'name'  => 'nullable|string|max:255',
            'urdu_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'guardian_name' => 'nullable|string',
            'guardian_phone' => 'nullable|string',
            'program' => 'required|in:hifz,nazra,qaida',
            'teacher_id' => 'nullable|exists:teachers,id',
            'phone' => 'nullable|string',
            'course_id' => 'nullable|exists:courses,id',
            'status' => 'required|in:active,inactive,graduated',
        ]);

        $userData = [
            'name'  => $request->name ?? $request->urdu_name ?? $user->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $student->update([
            'name'      => $request->name,
            'urdu_name' => $request->urdu_name,
            'guardian_name' => $request->guardian_name,
            'guardian_phone' => $request->guardian_phone,
            'program' => $request->program,
            'teacher_id' => $request->teacher_id,
            'status'      => $request->status,
        ]);

        if ($request->course_id) {
            $student->courses()->sync([$request->course_id]);
        } else {
            $student->courses()->detach();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;
        
        // Deleting the user will automatically cascade-delete the student profile
        // and all related records (attendance, progress, exams) due to DB foreign keys.
        if ($user) {
            $user->delete();
        } else {
            $student->delete();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student and associated user account deleted.');
    }
}
