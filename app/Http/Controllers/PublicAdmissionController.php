<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Course;
use Illuminate\Http\Request;

class PublicAdmissionController extends Controller
{
    /**
     * Show the admission form.
     */
    public function index()
    {
        $courses = Course::orderBy('title')->get();
        return view('admission', compact('courses'));
    }

    /**
     * Store a new admission application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female',
            'course_id' => 'required|exists:courses,id',
            'previous_education' => 'required|string|max:255',
            'boarding_required' => 'required|boolean',
            'guardian_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        Admission::create([
            'user_id' => auth()->id(),
            'course_id' => $request->course_id,
            'name' => $request->firstName . ' ' . $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'father_name' => $request->guardian_name,
            'address' => $request->address,
            'qualification' => $request->previous_education,
            'boarding_required' => $request->boarding_required,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Your application has been submitted successfully! We will contact you soon.');
    }
}
