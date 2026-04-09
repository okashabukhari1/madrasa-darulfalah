@extends('admin.layouts.app')
@section('title', 'Messages')
@section('page_title', 'Inquiry Inbox')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-envelope"></i> Contact Messages</h2>
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
                    <th>Sender</th>
                    <th>Subject</th>
                    <th>Message Snippet</th>
                    <th>Received</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                <tr style="{{ !$msg->is_read ? 'background:rgba(212,175,55,0.05); font-weight:600;' : '' }}">
                    <td>
                        <div style="color:var(--text-dark);">{{ $msg->name }}</div>
                        <small style="color:var(--text-light);">{{ $msg->email }}</small>
                    </td>
                    <td>{{ $msg->subject }}</td>
                    <td>{{ Str::limit($msg->message, 60) }}</td>
                    <td>{{ $msg->created_at->diffForHumans() }}</td>
                    <td>
                        @if(!$msg->is_read)
                            <span class="badge badge-gold">Unread</span>
                        @else
                            <span class="badge badge-gray">Read</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.messages.show', $msg->id) }}" class="btn btn-outline btn-xs" title="View Message"><i class="bi bi-eye"></i></a>
                            <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-xs" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">Inbox is empty.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
