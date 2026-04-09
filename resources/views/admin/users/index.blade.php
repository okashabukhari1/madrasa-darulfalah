@extends('admin.layouts.app')

@section('title', 'User Management')
@section('page_title', 'User Accounts')

@section('content')
<div class="db-card">
    <div class="db-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2><i class="bi bi-people"></i> Manage User Accounts</h2>
            <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 0.2rem;">Create, edit, and monitor all system users.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-gold">
            <i class="bi bi-person-plus"></i> Add New User
        </a>
    </div>

    <!-- Filters -->
    <div style="padding: 1.5rem; background: var(--white); border-bottom: 1px solid var(--gray-100);">
        <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
            <div class="form-group" style="min-width: 240px; margin-bottom: 0;">
                <label>Search User</label>
                <div style="position: relative;">
                    <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400);"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, or phone..." class="form-control" style="padding-left: 2.5rem;">
                </div>
            </div>
            
            <div class="form-group" style="min-width: 180px; margin-bottom: 0;">
                <label>Role Filter</label>
                <select name="role" class="form-control">
                    <option value="">All Account Types</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrators</option>
                    <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Faculty / Teachers</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Enrolled Students</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>General Users</option>
                </select>
            </div>

            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn btn-primary" style="height: 45px; padding: 0 1.5rem;">
                    <i class="bi bi-funnel"></i> Apply Filter
                </button>
                @if(request()->anyFilled(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="height: 45px; padding: 0 1.2rem; display: flex; align-items: center;">
                        <i class="bi bi-arrow-counterclockwise"></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="db-card-body" style="padding: 0; overflow-x: auto;">
        <table class="db-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email & Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <img src="{{ $user->avatar_url }}" alt="" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--gold-light); object-fit: cover;">
                            <div style="display: flex; flex-direction: column;">
                                <div style="font-weight: 600; color: var(--gray-800); font-size: 0.95rem;">
                                    {{ $user->name }}
                                    @if($user->isTeacher() && $user->teacher?->urdu_name)
                                        <span class="urdu-font" style="margin-left: 0.4rem; color: var(--primary); font-size: 1.1rem;">({{ $user->teacher->urdu_name }})</span>
                                    @elseif($user->isStudent() && $user->student?->urdu_name)
                                        <span class="urdu-font" style="margin-left: 0.4rem; color: var(--primary); font-size: 1.1rem;">({{ $user->student->urdu_name }})</span>
                                    @endif
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.4rem; margin-top: 0.1rem;">
                                    <span class="badge {{ $user->isAdmin() ? 'badge-gold' : ($user->isTeacher() ? 'badge-green' : 'badge-blue') }}" style="font-size: 10px; padding: 1px 6px;">{{ $user->role }}</span>
                                    <small style="color: var(--gray-400); font-size: 11px;">#{{ $user->id }}</small>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 0.9rem;">{{ $user->email }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">{{ $user->phone ?? 'No Phone' }}</div>
                    </td>
                    <td>
                        @php
                            $roleClass = match($user->role) {
                                'admin' => 'badge-gold',
                                'teacher' => 'badge-green',
                                'student' => 'badge-blue',
                                default => 'badge-gray'
                            };
                        @endphp
                        <span class="badge {{ $roleClass }}" style="text-transform: capitalize;">{{ $user->role }}</span>
                    </td>
                    <td>
                        @if($user->status)
                            <span class="badge badge-green"><i class="bi bi-check-circle"></i> Active</span>
                        @else
                            <span class="badge badge-gray"><i class="bi bi-dash-circle"></i> Inactive</span>
                        @endif
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-light);">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td style="text-align: right; padding-right: 1.5rem;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-icon" title="Edit User">
                                <i class="bi bi-pencil" style="font-size: 1.1rem;"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <button type="button" class="btn-icon btn-icon-danger delete-user-btn" 
                                    data-id="{{ $user->id }}" 
                                    data-name="{{ $user->name }}" 
                                    title="Delete User">
                                <i class="bi bi-trash" style="font-size: 1.1rem;"></i>
                            </button>
                            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-light);">
                        <i class="bi bi-people" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                        No users found matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding: 1.5rem; border-top: 1px solid var(--beige-dark);">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBtns = document.querySelectorAll('.delete-user-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                if (confirm('Are you sure you want to delete user "' + name + '"? This action cannot be undone and may affect related records.')) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
