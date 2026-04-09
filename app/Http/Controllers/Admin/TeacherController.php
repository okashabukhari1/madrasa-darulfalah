<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = \App\Models\Teacher::latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'nullable|string|max:255',
            'urdu_name'      => 'nullable|string|max:255',
            'designation'    => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email|unique:teachers,email',
            'password'       => 'required|string|min:8|confirmed',
            'photo'          => 'nullable|image|max:10240',
            'bio'            => 'nullable|string',
            'qualification'  => 'nullable|string|max:255',
            'experience'     => 'nullable|string|max:255',
        ]);

        return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            // 1. Create User Account
            $user = \App\Models\User::create([
                'name'     => $request->name ?? $request->urdu_name ?? 'Teacher',
                'email'    => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role'     => 'teacher',
                'status'   => true,
            ]);

            // 2. Create Teacher Profile
            $data = $request->except(['password', 'password_confirmation']);
            $data['user_id'] = $user->id;
            $data['slug'] = \Illuminate\Support\Str::slug($request->name);
            $data['status'] = $request->has('status');

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('teachers', 'public');
            }

            \App\Models\Teacher::create($data);

            return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile and account created successfully.');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = \App\Models\Teacher::with('courses')->findOrFail($id);
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);

        $request->validate([
            'name'           => 'nullable|string|max:255',
            'urdu_name'      => 'nullable|string|max:255',
            'designation'    => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'email'          => 'required|email|unique:teachers,email,' . $id,
            'password'       => 'nullable|string|min:8|confirmed',
            'photo'          => 'nullable|image|max:10240',
            'bio'            => 'nullable|string',
            'qualification'  => 'nullable|string|max:255',
            'experience'     => 'nullable|string|max:255',
        ]);

        // 1. Update/Link User Account
        if ($teacher->user_id) {
            $user = \App\Models\User::findOrFail($teacher->user_id);
            $user->update([
                'name'  => $request->name ?? $request->urdu_name ?? $user->name,
                'email' => $request->email,
            ]);
            
            if ($request->filled('password')) {
                $user->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                ]);
            }
        }

        // 2. Update Teacher Profile
        $data = $request->except(['password', 'password_confirmation']);
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
        $data['status'] = $request->has('status');

        if ($request->hasFile('photo')) {
            if ($teacher->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($teacher->photo);
            }
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher profile and account updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = \App\Models\Teacher::findOrFail($id);
        
        if ($teacher->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($teacher->photo);
        }

        $user = $teacher->user;
        if ($user) {
            $user->delete(); // This will cascade delete teacher due to foreign key
        } else {
            $teacher->delete();
        }

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher and associated user account deleted.');
    }
}
