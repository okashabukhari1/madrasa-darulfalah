<?php

namespace App\Http\Controllers;

use App\Models\CmsSetting;
use App\Models\Course;
use App\Models\Teacher;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::where('status', true)->where('is_featured', true)->take(3)->get();
        $teachers = Teacher::where('status', true)->orderBy('order')->take(4)->get();
        $announcements = \App\Models\Announcement::active()->where('type', 'all')->latest()->take(5)->get();
        $events = \App\Models\Event::active()->upcoming()->take(5)->get();
        
        return view('welcome', compact('featuredCourses', 'teachers', 'announcements', 'events'));
    }

    public function courses()
    {
        $courses = Course::with(['teacher', 'category'])->where('status', true)->latest()->get();
        $categories = \App\Models\Category::all(); // Fetch all categories for filtering
        return view('courses', compact('courses', 'categories'));
    }

    public function courseDetails($slug)
    {
        $course = Course::with(['teacher', 'category'])->where('slug', $slug)->where('status', true)->firstOrFail();
        return view('courses.show', compact('course'));
    }

    public function teachers()
    {
        $teachers = Teacher::where('status', true)->orderBy('order')->get();
        return view('teachers', compact('teachers'));
    }

    public function teacherDetails($slug)
    {
        $teacher = Teacher::where('slug', $slug)->where('status', true)->firstOrFail();
        return view('teachers.show', compact('teacher'));
    }

    public function gallery()
    {
        $images = \App\Models\Gallery::latest()->get();
        return view('gallery', compact('images'));
    }

    public function books()
    {
        $books = \App\Models\Book::with('bookCategory')->where('status', true)->latest()->get();
        return view('books', compact('books'));
    }
}
