@extends('admin.layouts.app')
@section('title', 'Library Management')
@section('page_title', 'Maktaba Digital Library')

@section('content')
<div class="db-card reveal">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="margin:0; color: var(--primary); font-family: 'Playfair Display', serif;">Resource Collection</h3>
            <p style="margin:0; font-size: 0.85rem; color: var(--text-light);">Manage your digital books, PDFs, and Islamic literature.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add New Book
        </a>
    </div>

    <!-- Filters -->
    <div style="padding: 1.25rem 1.5rem; background: var(--white); border-bottom: 1px solid var(--gray-100);">
        <form action="{{ route('admin.books.index') }}" method="GET" style="display: flex; gap: 1rem; align-items: flex-end;">
            <div class="form-group" style="min-width: 300px; margin-bottom: 0;">
                <label>Search Collection</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400);"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title, author, or category..." class="form-control" style="padding-left: 2.5rem;">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" style="height: 45px; padding: 0 1.5rem;">Filter</button>
            @if(request('search'))
                <a href="{{ route('admin.books.index') }}" class="btn btn-outline" style="height: 45px; display: flex; align-items: center;">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Cover</th>
                    <th>Book Details</th>
                    <th>Category</th>
                    <th>Format</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td>
                        <div style="width: 50px; height: 70px; background: var(--gray-100); border-radius: 4px; overflow: hidden; border: 1px solid var(--gray-200);">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                                    <i class="bi bi-book" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--gray-800);">{{ $book->title }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-light); margin-top: 2px;">By {{ $book->author ?? 'Unknown Author' }}</div>
                    </td>
                    <td><span class="badge badge-blue">{{ $book->bookCategory->name ?? $book->category ?? 'General' }}</span></td>
                    <td>
                        @if($book->file_path)
                            <span style="font-weight: 600; text-transform: uppercase; font-size: 0.75rem; color: var(--primary);">
                                <i class="bi bi-file-earmark-{{ in_array($book->file_type, ['pdf']) ? 'pdf' : 'text' }}"></i> {{ $book->file_type }}
                            </span>
                        @elseif($book->external_link)
                            <span style="color: var(--gold); font-size: 0.75rem;"><i class="bi bi-link-45deg"></i> External</span>
                        @else
                            <span class="text-muted small">No File</span>
                        @endif
                    </td>
                    <td>
                        @if($book->is_featured)
                            <span style="color: var(--gold);"><i class="bi bi-star-fill"></i> Featured</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @if($book->status)
                            <span class="badge badge-green">Public</span>
                        @else
                            <span class="badge badge-red">Hidden</span>
                        @endif
                    </td>
                    <td style="text-align: right; padding-right: 1.5rem;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            @if($book->file_path)
                            <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank" class="btn-icon" title="Download">
                                <i class="bi bi-download"></i>
                            </a>
                            @endif
                            <a href="{{ route('admin.books.edit', $book->slug) }}" class="btn-icon" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->slug) }}" method="POST" style="display:inline;" onsubmit="return confirm('Archive this book?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 4rem; color: var(--text-light);">
                        <i class="bi bi-journal-x" style="font-size: 3rem; display: block; margin-bottom: 1rem; color: var(--gray-200);"></i>
                        No books found in the library.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($books->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--gray-100);">
        {{ $books->links() }}
    </div>
    @endif
</div>
@endsection
