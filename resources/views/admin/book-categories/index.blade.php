@extends('admin.layouts.app')
@section('title', 'Book Categories')
@section('page_title', 'Library Management')

@section('content')
<div class="db-card reveal">
    <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 style="margin:0; color: var(--primary); font-family: 'Playfair Display', serif;">Book Categories</h3>
            <p style="margin:0; font-size: 0.85rem; color: var(--text-light);">Organize your digital library with custom sections.</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.books.index') }}" class="btn btn-outline">
                <i class="bi bi-book"></i> View Books
            </a>
            <a href="{{ route('admin.book-categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add New Category
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="db-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th style="text-align: center;">Books Count</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--gray-800);">{{ $category->name }}</div>
                    </td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td style="max-width: 300px; color: var(--text-light); font-size: 0.9rem;">
                        {{ Str::limit($category->description, 80) ?? 'No description.' }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge badge-blue">{{ $category->books_count }}</span>
                    </td>
                    <td style="text-align: right; padding-right: 1.5rem;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.book-categories.edit', $category->slug) }}" class="btn-icon" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.book-categories.destroy', $category->slug) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                    <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-light);">
                        <i class="bi bi-tags" style="font-size: 3rem; display: block; margin-bottom: 1rem; color: var(--gray-200);"></i>
                        No categories defined for books.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
