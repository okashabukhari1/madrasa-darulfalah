<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = \App\Models\Announcement::latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'nullable|string|max:255',
            'content'      => 'nullable|string',
            'type'         => 'required|in:all,student,teacher,both',
            'expires_at'   => 'nullable|date|after:today',
        ]);

        \App\Models\Announcement::create([
            'title'        => $request->title,
            'content'      => $request->content,
            'type'         => $request->type,
            'is_active'    => $request->has('is_active'),
            'expires_at'   => $request->expires_at,
            'created_by'   => auth()->id(),
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement published.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);

        $request->validate([
            'title'        => 'nullable|string|max:255',
            'content'      => 'nullable|string',
            'type'         => 'required|in:all,student,teacher,both',
            'expires_at'   => 'nullable|date',
        ]);

        $announcement->update([
            'title'        => $request->title,
            'content'      => $request->content,
            'type'         => $request->type,
            'is_active'    => $request->has('is_active'),
            'expires_at'   => $request->expires_at,
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\Announcement::findOrFail($id)->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
