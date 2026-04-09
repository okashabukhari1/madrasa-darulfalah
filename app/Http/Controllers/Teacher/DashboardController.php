<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        if (!$teacher) {
            // Fallback to searching by email if relationship fails
            $teacher = \App\Models\Teacher::where('email', $user->email)->first();
            if ($teacher && !$teacher->user_id) {
                $teacher->user_id = $user->id;
                $teacher->save();
            }
        }

        if (!$teacher) {
            abort(403, 'No teacher profile linked to account: ' . $user->email . ' (User ID: ' . $user->id . ')');
        }

        $assignedStudents = $teacher->assignedStudents()->with('user')->get();
        $totalStudents = $assignedStudents->count();
        
        $todayAttendance = Attendance::where('teacher_id', $teacher->id)
            ->whereDate('date', now())
            ->count();

        // Let's get recent combined progress & attendance (from progress logs later, or attendances for now)
        $recentAttendances = Attendance::where('teacher_id', $teacher->id)
            ->with(['student.user'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_students' => $totalStudents,
            'hifz_students' => $assignedStudents->where('program', 'hifz')->count(),
            'nazra_students' => $assignedStudents->where('program', 'nazra')->count(),
            'qaida_students' => $assignedStudents->where('program', 'qaida')->count(),
            'today_attendance' => $todayAttendance,
            'attendance_rate' => $totalStudents > 0 ? round(($todayAttendance / $totalStudents) * 100) : 0,
        ];

        $announcements = \App\Models\Announcement::active()
            ->whereIn('type', ['all', 'teacher', 'both'])
            ->latest()
            ->take(3)
            ->get();

        return view('teacher.dashboard', compact('teacher', 'assignedStudents', 'stats', 'recentAttendances', 'announcements'));
    }
}
