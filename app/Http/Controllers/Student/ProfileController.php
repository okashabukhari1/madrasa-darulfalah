<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('student.profile');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $student = $user->student;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
        ]);

        $student->update([
            'father_name' => $request->father_name,
            'dob' => $request->dob,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }
}
