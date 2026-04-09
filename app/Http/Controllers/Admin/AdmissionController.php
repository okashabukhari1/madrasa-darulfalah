<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admissions = \App\Models\Admission::with('course')->latest()->get();
        return view('admin.admissions.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admission = \App\Models\Admission::with(['course', 'user'])->findOrFail($id);
        return view('admin.admissions.show', compact('admission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admission = \App\Models\Admission::findOrFail($id);
        return view('admin.admissions.edit', compact('admission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admission = \App\Models\Admission::findOrFail($id);

        $request->validate([
            'status'      => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $admission->update([
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // If approved, you might want to trigger a student account creation or enrollment
        // For now, we just update the status.

        return redirect()->route('admin.admissions.index')->with('success', 'Admission status updated to ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\Admission::findOrFail($id)->delete();
        return redirect()->route('admin.admissions.index')->with('success', 'Admission record deleted.');
    }
}
