<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::active()
            ->whereIn('type', ['all', 'teacher', 'both'])
            ->latest()
            ->get();
        return view('teacher.announcements', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = Announcement::active()
            ->whereIn('type', ['all', 'teacher', 'both'])
            ->findOrFail($id);
        return view('teacher.announcement_show', compact('announcement'));
    }
}
