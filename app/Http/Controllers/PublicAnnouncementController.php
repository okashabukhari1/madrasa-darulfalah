<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class PublicAnnouncementController extends Controller
{
    public function show($id)
    {
        $announcement = Announcement::active()->findOrFail($id);
        
        return view('public.announcements.show', compact('announcement'));
    }
}
