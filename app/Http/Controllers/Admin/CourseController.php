<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = \App\Models\Course::with(['teacher', 'category'])->withCount('students')->latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = \App\Models\Teacher::all();
        $categories = \App\Models\Category::all();
        return view('admin.courses.create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'urdu_title'       => 'nullable|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'urdu_description' => 'nullable|string',
            'content'          => 'nullable|string',
            'level'            => 'required|in:beginner,intermediate,advanced',
            'fee'              => 'required|numeric',
            'duration'         => 'required|string',
            'teacher_id'       => 'required|exists:teachers,id',
            'image'            => 'nullable|image|max:10240',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        $data['status'] = $request->has('status');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        \App\Models\Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = \App\Models\Course::with(['teacher', 'students'])->findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        $teachers = \App\Models\Teacher::all();
        $categories = \App\Models\Category::all();
        return view('admin.courses.edit', compact('course', 'teachers', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = \App\Models\Course::findOrFail($id);

        $request->validate([
            'title'            => 'required|string|max:255',
            'urdu_title'       => 'nullable|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'description'      => 'required|string',
            'urdu_description' => 'nullable|string',
            'content'          => 'nullable|string',
            'level'            => 'required|in:beginner,intermediate,advanced',
            'fee'              => 'required|numeric',
            'duration'         => 'required|string',
            'teacher_id'       => 'required|exists:teachers,id',
            'image'            => 'nullable|image|max:10240',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = \Illuminate\Support\Str::slug($request->title);
        $data['status'] = $request->has('status');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->hasFile('image')) {
            if ($course->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = \App\Models\Course::findOrFail($id);
        if ($course->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($course->image);
        }
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
