@extends('student.layouts.app')
@section('title', 'Study Materials')
@section('page_title', 'Course Resources')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-file-earmark-arrow-down"></i> Available Downloads</h2>
    </div>
    
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Course</th>
                    <th>Type</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr>
                    <td>
                        <div style="font-weight:600; color:var(--text-dark); display:flex; align-items:center; gap:0.5rem;">
                            <i class="bi bi-file-earmark-{{ in_array($material->file_type, ['pdf', 'doc', 'docx']) ? 'text' : 'image' }}" style="color:var(--gold-dark); font-size:1.2rem;"></i>
                            {{ $material->title }}
                        </div>
                    </td>
                    <td>{{ $material->course->title ?? 'General' }}</td>
                    <td><span class="badge badge-blue">{{ strtoupper($material->file_type) }}</span></td>
                    <td>{{ $material->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-gold btn-xs" download>
                            <i class="bi bi-download"></i> Download
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 4rem; color: var(--text-light);">
                        <i class="bi bi-folder-x" style="font-size:3rem; display:block; margin-bottom:1rem; opacity:0.3;"></i>
                        No study materials available yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
