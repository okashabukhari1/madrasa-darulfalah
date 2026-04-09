@extends('admin.layouts.app')
@section('title', 'Staff Management')
@section('page_title', 'Administrative Staff')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-people"></i> Admin Users</h2>
        <a href="{{ route('admin.management.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-person-plus"></i> Add Staff</a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="padding: 1rem; background: rgba(229,62,62,0.1); color: #e53e3e; border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Last Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">{{ $member->name }}</div>
                    </td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? 'N/A' }}</td>
                    <td><span class="badge badge-purple">{{ ucfirst($member->role) }}</span></td>
                    <td>{{ $member->updated_at->diffForHumans() }}</td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.management.edit', $member->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                            @if($member->id !== auth()->id())
                            <form action="{{ route('admin.management.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Remove this admin user?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline btn-xs" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-light);">No staff members found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
