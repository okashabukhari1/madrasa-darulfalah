<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::latest()->paginate(15);
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        // Placeholder for store logic
        return redirect()->route('admin.materials.index')->with('success', 'Material created successfully.');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        // Placeholder for update logic
        return redirect()->route('admin.materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy($id)
    {
        Material::findOrFail($id)->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Material deleted.');
    }
}
