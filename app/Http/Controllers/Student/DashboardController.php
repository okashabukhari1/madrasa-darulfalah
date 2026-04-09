<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Book;
use App\Models\Attendance;
use App\Models\ProgressLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        $recentAnnouncements = Announcement::active()->latest()->take(4)->get();
        $recentMaterials = Book::latest()->take(3)->get();
        
        $todayAttendance = null;
        $recentProgress = collect();
        $recentAttendances = collect();
        $hifzData = null;

        if ($student) {
            $todayAttendance = Attendance::where('student_id', $student->id)
                ->whereDate('date', today())
                ->first();

            $recentAttendances = Attendance::where('student_id', $student->id)
                ->latest('date')
                ->take(5)
                ->get();

            $recentProgress = ProgressLog::where('student_id', $student->id)
                ->with('teacher')
                ->latest('date')
                ->take(5)
                ->get();

            if ($student->program === 'hifz') {
                $maxPara = ProgressLog::where('student_id', $student->id)->max('para');
                $hifzData = [
                    'max_para' => $maxPara ?? 0,
                    'percentage' => $maxPara ? round(($maxPara / 30) * 100) : 0,
                ];
            }
        }
        
        $stats = [
            'study_materials'  => Book::count(),
            'announcements'    => Announcement::active()->count(),
            'classes_week'     => 5,
        ];

        return view('student.dashboard', compact('student', 'stats', 'recentAnnouncements', 'recentMaterials', 'todayAttendance', 'recentProgress', 'recentAttendances', 'hifzData'));
    }
}
