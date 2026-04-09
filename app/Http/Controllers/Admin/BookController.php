<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('bookCategory');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhereHas('bookCategory', function($bq) use ($search) {
                      $bq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $books = $query->latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = \App\Models\BookCategory::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'book_category_id' => 'nullable|exists:book_categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'book_file' => 'nullable|file|mimes:pdf,doc,docx,epub|max:20480',
            'external_link' => 'nullable|url',
        ]);

        $data = $request->except(['cover_image', 'book_file']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->has('status');
        $data['is_featured'] = $request->has('is_featured');
        
        // Sync the old string category field for backward compatibility if needed, 
        // but primarily we use the relation now.
        if ($request->book_category_id) {
            $data['category'] = \App\Models\BookCategory::find($request->book_category_id)->name;
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('book_file')) {
            $file = $request->file('book_file');
            $data['file_path'] = $file->store('books/files', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Book added to library successfully.');
    }

    public function edit(Book $book)
    {
        $categories = \App\Models\BookCategory::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'book_category_id' => 'nullable|exists:book_categories,id',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'book_file' => 'nullable|file|mimes:pdf,doc,docx,epub|max:20480',
            'external_link' => 'nullable|url',
        ]);

        $data = $request->except(['cover_image', 'book_file']);
        $data['slug'] = Str::slug($request->title);
        $data['status'] = $request->has('status');
        $data['is_featured'] = $request->has('is_featured');

        if ($request->book_category_id) {
            $data['category'] = \App\Models\BookCategory::find($request->book_category_id)->name;
        }

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) Storage::disk('public')->delete($book->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        if ($request->hasFile('book_file')) {
            if ($book->file_path) Storage::disk('public')->delete($book->file_path);
            $file = $request->file('book_file');
            $data['file_path'] = $file->store('books/files', 'public');
            $data['file_type'] = $file->getClientOriginalExtension();
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Book details updated.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover_image) Storage::disk('public')->delete($book->cover_image);
        if ($book->file_path) Storage::disk('public')->delete($book->file_path);
        
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Book removed from library.');
    }
}
