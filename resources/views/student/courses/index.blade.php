@extends('student.layouts.app')
@section('title', 'My Courses')
@section('page_title', 'Enrolled Courses')

@section('content')
<div class="db-grid">
    @forelse($courses as $course)
    <div class="db-card">
        <div style="height:150px; background:linear-gradient(135deg, var(--gold-dark), var(--gold)); position:relative; overflow:hidden;">
            <div style="position:absolute; top:1.5rem; right:1.5rem; width:45px; height:45px; border-radius:50%; background:rgba(255,255,255,0.2); backdrop-filter:blur(5px); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.5rem;">
                <i class="bi bi-{{ $course->icon ?? 'book' }}"></i>
            </div>
            <div style="position:absolute; bottom:1rem; left:1.5rem; color:#fff;">
                <span style="font-size:0.75rem; text-transform:uppercase; letter-spacing:1px; opacity:0.8;">Course Card</span>
                <h3 style="margin:0; font-size:1.2rem;">{{ $course->title }}</h3>
            </div>
        </div>
        <div class="db-card-body" style="padding:1.5rem;">
            <p style="color:var(--text-light); font-size:0.9rem; line-height:1.5; margin-bottom:1.5rem;">
                {{ Str::limit($course->description, 100) }}
            </p>
            
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; flex-direction:column;">
                    <span style="font-size:0.7rem; color:var(--text-light); text-transform:uppercase;">Instructor</span>
                    <span style="font-weight:600; color:var(--text-dark);">{{ $course->teacher->name ?? 'Dept. Faculty' }}</span>
                </div>
                <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-outline btn-sm">Course Details <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1; text-align:center; padding:5rem 2rem; background:rgba(212,175,55,0.05); border-radius:20px; border:2px dashed var(--gold-light);">
        <i class="bi bi-journal-x" style="font-size:4rem; color:var(--gold); opacity:0.3; display:block; margin-bottom:1.5rem;"></i>
        <h2 style="color:var(--text-dark); margin-bottom:0.5rem;">Not Enrolled in Any Courses</h2>
        <p style="color:var(--text-light);">Wait for the administrator to assign courses to your account.</p>
    </div>
    @endforelse
</div>
@endsection
