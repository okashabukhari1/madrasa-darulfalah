@extends('admin.layouts.app')
@section('title', 'Announcements')
@section('page_title', 'Push Notifications')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-megaphone"></i> All Announcements</h2>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Announcement</a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Audience</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($announcements as $ann)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">{{ $ann->title }}</div>
                        <small style="color:var(--text-light);">{{ Str::limit($ann->content, 60) }}</small>
                    </td>
                    <td>
                        @if($ann->type === 'all')
                            <span class="badge badge-blue">Everyone</span>
                        @elseif($ann->type === 'student')
                            <span class="badge badge-gold">Students</span>
                        @elseif($ann->type === 'teacher')
                            <span class="badge badge-green">Teachers</span>
                        @elseif($ann->type === 'both')
                            <span class="badge badge-purple">Students & Teachers</span>
                        @endif
                    </td>
                    <td>{{ $ann->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($ann->is_active)
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-gray">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.announcements.edit', $ann->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.announcements.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-xs" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No announcements yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
