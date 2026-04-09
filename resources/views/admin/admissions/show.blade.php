@extends('admin.layouts.app')
@section('title', 'Review Admission')
@section('page_title', 'Application Details')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Main Details -->
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-person-lines-fill"></i> Applicant Information</h2>
            <span class="badge {{ $admission->status === 'approved' ? 'badge-green' : ($admission->status === 'rejected' ? 'badge-red' : 'badge-gold') }}">
                {{ ucfirst($admission->status) }}
            </span>
        </div>
        
        <div class="db-card-body" style="padding: 2rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Full Name</label>
                    <p style="font-weight: 600; font-size: 1.1rem;">{{ $admission->name }}</p>
                </div>
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Applying for Course</label>
                    <p style="font-weight: 600; color: var(--gold-dark);">{{ $admission->course->title ?? 'N/A' }}</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Email Address</label>
                    <p>{{ $admission->email }}</p>
                </div>
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Phone Number</label>
                    <p>{{ $admission->phone }}</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Father's Name</label>
                    <p>{{ $admission->father_name }}</p>
                </div>
                <div>
                    <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Date of Birth</label>
                    <p>{{ $admission->dob ? $admission->dob->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Address</label>
                <p>{{ $admission->address }}, {{ $admission->city }}</p>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="color: var(--text-light); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Message / Note from Applicant</label>
                <div style="background: var(--beige-light); padding: 1rem; border-radius: 8px; font-style: italic; border-left: 4px solid var(--gold);">
                    "{{ $admission->message ?? 'No message provided.' }}"
                </div>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <div class="db-card">
            <div class="db-card-header">
                <h3><i class="bi bi-shield-check"></i> Action Center</h3>
            </div>
            <div class="db-card-body" style="padding: 1.5rem;">
                <form action="{{ route('admin.admissions.update', $admission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Update Application Status</label>
                        <select name="status" class="form-control" style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">
                            <option value="pending" {{ $admission->status === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="approved" {{ $admission->status === 'approved' ? 'selected' : '' }}>Approve Admission</option>
                            <option value="rejected" {{ $admission->status === 'rejected' ? 'selected' : '' }}>Reject Application</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display:block; margin-bottom:0.5rem; font-weight:600;">Internal Admin Notes</label>
                        <textarea name="admin_notes" rows="4" placeholder="Add notes here..." style="width:100%; padding:0.75rem; border:1px solid var(--beige-dark); border-radius:8px;">{{ old('admin_notes', $admission->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-gold w-100" style="width:100%; padding:0.8rem;">Update Status</button>
                </form>
            </div>
        </div>

        @if($admission->status !== 'pending')
        <div class="db-card" style="background: rgba(var(--gold-rgb), 0.05);">
            <div class="db-card-body" style="padding: 1rem; font-size: 0.9rem;">
                <p><strong>Reviewed By:</strong> {{ $admission->reviewer->name ?? 'System' }}</p>
                <p style="margin-top: 0.5rem;"><strong>Reviewed At:</strong> {{ $admission->reviewed_at ? $admission->reviewed_at->format('M d, Y H:i') : 'N/A' }}</p>
            </div>
        </div>
        @endif
        
        <a href="{{ route('admin.admissions.index') }}" class="btn btn-outline w-100" style="text-align:center;"><i class="bi bi-arrow-left"></i> Back to All Admissions</a>
        
        <form action="{{ route('admin.admissions.destroy', $admission->id) }}" method="POST" onsubmit="return confirm('Permanently delete this application record?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline w-100" style="color: #ff4d4d; border-color: rgba(255, 77, 77, 0.2); width:100%;">Delete Application</button>
        </form>
    </div>
</div>
@endsection
