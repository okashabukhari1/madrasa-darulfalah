<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookCategoryController extends Controller
{
    public function index()
    {
        $categories = BookCategory::withCount('books')->latest()->get();
        return view('admin.book-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.book-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_categories',
            'description' => 'nullable|string',
        ]);

        BookCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.book-categories.index')->with('success', 'Book category created successfully.');
    }

    public function edit(BookCategory $bookCategory)
    {
        return view('admin.book-categories.edit', compact('bookCategory'));
    }

    public function update(Request $request, BookCategory $bookCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:book_categories,name,' . $bookCategory->id,
            'description' => 'nullable|string',
        ]);

        $bookCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('admin.book-categories.index')->with('success', 'Book category updated.');
    }

    public function destroy(BookCategory $bookCategory)
    {
        if ($bookCategory->books()->count() > 0) {
            return back()->with('error', 'Category cannot be deleted as it contains books.');
        }

        $bookCategory->delete();
        return redirect()->route('admin.book-categories.index')->with('success', 'Book category deleted.');
    }
}
