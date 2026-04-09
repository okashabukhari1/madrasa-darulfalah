<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gallery = \App\Models\Gallery::latest()->get();
        return view('admin.gallery.index', compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string',
            'image'    => 'required|image|max:51200',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        \App\Models\Gallery::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Image added to gallery.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $image = \App\Models\Gallery::findOrFail($id);
        return view('admin.gallery.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $image = \App\Models\Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $image = \App\Models\Gallery::findOrFail($id);

        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string',
            'image'    => 'nullable|image|max:51200',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            if ($image->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
            }
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $image->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = \App\Models\Gallery::findOrFail($id);
        if ($image->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image);
        }
        $image->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Image removed from gallery.');
    }
}
