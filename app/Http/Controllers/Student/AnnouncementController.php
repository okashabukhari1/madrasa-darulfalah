<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = \App\Models\Announcement::active()
            ->whereIn('type', ['all', 'student', 'both'])
            ->latest()
            ->get();
        return view('student.announcements', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = \App\Models\Announcement::active()
            ->whereIn('type', ['all', 'student', 'both'])
            ->findOrFail($id);
        return view('student.announcement_show', compact('announcement'));
    }
}
