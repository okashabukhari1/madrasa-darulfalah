<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Book;
use App\Models\Admission;
use App\Models\Message;
use App\Models\Announcement;
use App\Models\ProgressLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'  => Student::count(),
            'hifz_students'   => Student::where('program', 'hifz')->count(),
            'nazra_students'  => Student::where('program', 'nazra')->count(),
            'qaida_students'  => Student::where('program', 'qaida')->count(),
            'total_teachers'  => Teacher::count(),
            'pending_adm'     => Admission::where('status', 'pending')->count(),
            'unread_messages' => Message::where('is_read', false)->count(),
        ];

        $recentAdmissions = Admission::latest()->take(5)->get();
        $recentStudents = Student::with(['user', 'teacher'])->latest()->take(5)->get();
        $recentAnnouncements = Announcement::active()->latest()->take(5)->get();
        $recentProgress = ProgressLog::with(['student.user', 'teacher'])->latest('date')->take(5)->get();
        $coursesData = Course::withCount('students')->get();

        return view('admin.dashboard', compact('stats', 'recentAdmissions', 'recentStudents', 'recentAnnouncements', 'recentProgress', 'coursesData'));
    }
}
