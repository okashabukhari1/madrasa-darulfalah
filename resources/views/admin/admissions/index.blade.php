@extends('admin.layouts.app')
@section('title', 'Manage Admissions')
@section('page_title', 'Admissions Applications')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-clipboard-data"></i> New Applications</h2>
        <div class="db-card-actions">
            <span class="badge badge-gold">Total: {{ count($admissions) }}</span>
        </div>
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
                    <th>Applicant Name</th>
                    <th>Course</th>
                    <th>Father Name</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admissions as $admission)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark);">{{ $admission->name }}</div>
                        <small style="color:var(--text-light);">{{ $admission->email }}</small>
                    </td>
                    <td>{{ $admission->course->title ?? 'N/A' }}</td>
                    <td>{{ $admission->father_name }}</td>
                    <td>{{ $admission->phone }}</td>
                    <td>{{ $admission->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($admission->status === 'approved')
                            <span class="badge badge-green">Approved</span>
                        @elseif($admission->status === 'rejected')
                            <span class="badge badge-red">Rejected</span>
                        @else
                            <span class="badge badge-gold">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.5rem;">
                            <a href="{{ route('admin.admissions.show', $admission->id) }}" class="btn btn-outline btn-xs" title="Review Details"><i class="bi bi-eye"></i> View & Review</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-light);">No admission applications yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
