<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = \App\Models\User::whereIn('role', ['admin'])->latest()->get();
        return view('admin.management.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone'    => 'nullable|string',
        ]);

        \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'     => 'admin',
            'phone'    => $request->phone,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.management.index')->with('success', 'Staff member added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = \App\Models\User::findOrFail($id);
        return view('admin.management.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = \App\Models\User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $member->id,
            'password' => 'nullable|min:8',
            'phone'    => 'nullable|string',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.management.index')->with('success', 'Staff member updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = \App\Models\User::findOrFail($id);
        
        if ($member->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $member->delete();
        return redirect()->route('admin.management.index')->with('success', 'Staff member removed.');
    }
}
