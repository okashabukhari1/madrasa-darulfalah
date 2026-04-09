@extends('student.layouts.app')
@section('title', $course->title)
@section('page_title', 'Course Details')

@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Main Content -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Course Header Card -->
        <div class="db-card" style="overflow: hidden;">
            <div style="height: 200px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); position: relative; display: flex; align-items: flex-end; padding: 2rem;">
                <div style="position: absolute; top: 0; right: 0; width: 300px; height: 100%; background: url('{{ $course->image ? asset('storage/' . $course->image) : '' }}') center/cover no-repeat; opacity: 0.2; mask-image: linear-gradient(to left, rgba(0,0,0,1), rgba(0,0,0,0));"></div>
                <div style="position: relative; z-index: 1;">
                    <span style="display: inline-block; padding: 0.25rem 0.75rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(5px); border-radius: 20px; color: #fff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; margin-bottom: 0.75rem;">
                        {{ $course->category->name ?? 'General' }}
                    </span>
                    <h1 style="color: #fff; margin: 0; font-size: 2rem;">{{ $course->title }}</h1>
                </div>
            </div>
            <div class="db-card-body" style="padding: 2rem;">
                <h3 style="color: var(--gold-dark); margin-bottom: 1rem; font-size: 1.25rem; border-bottom: 1px solid var(--beige-dark); padding-bottom: 0.5rem;">
                    Course Description
                </h3>
                <div style="color: var(--text-dark); line-height: 1.8; font-size: 1rem; white-space: pre-line;">
                    {{ $course->description }}
                </div>
            </div>
        </div>

        <!-- Course Materials -->
        <div class="db-card">
            <div class="db-card-header">
                <h2><i class="bi bi-file-earmark-text"></i> Study Materials</h2>
            </div>
            <div class="db-card-body" style="padding: 1.5rem;">
                @if($course->materials && $course->materials->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($course->materials as $material)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: var(--beige-light); border-radius: 12px; border: 1px solid var(--beige-dark); transition: all 0.3s ease;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div style="width: 45px; height: 45px; border-radius: 10px; background: #fff; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.25rem; border: 1px solid var(--beige-dark);">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </div>
                                    <div>
                                        <h4 style="margin: 0; font-size: 0.95rem; color: var(--text-dark);">{{ $material->title }}</h4>
                                        <small style="color: var(--text-light);">Uploaded on {{ $material->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-gold btn-sm">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; color: var(--text-light);">
                        <i class="bi bi-inbox" style="font-size: 2.5rem; opacity: 0.3; display: block; margin-bottom: 0.5rem;"></i>
                        No study materials uploaded for this course yet.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Instructor Details -->
        <div class="db-card">
            <div class="db-card-header">
                <h2><i class="bi bi-person-badge"></i> Your Instructor</h2>
            </div>
            <div class="db-card-body" style="padding: 1.5rem; text-align: center;">
                <div style="width: 100px; height: 100px; border-radius: 50%; background: var(--beige); margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; border: 3px solid var(--gold-light); overflow: hidden;">
                    @if($course->teacher && $course->teacher->photo)
                        <img src="{{ asset('storage/' . $course->teacher->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="bi bi-person" style="font-size: 3rem; color: var(--gold-dark);"></i>
                    @endif
                </div>
                <h3 style="margin: 0 0 0.25rem; font-size: 1.1rem; color: var(--text-dark);">
                    {{ $course->teacher->name ?? 'Faculty Member' }}
                </h3>
                <span class="badge badge-gold" style="font-size: 0.75rem; margin-bottom: 1.25rem;">
                    {{ $course->teacher->designation ?? 'Instructor' }}
                </span>
                
                @if($course->teacher && $course->teacher->specialization)
                    <div style="background: var(--beige-light); padding: 1rem; border-radius: 8px; text-align: left;">
                        <span style="display: block; font-size: 0.7rem; color: var(--text-light); text-transform: uppercase; font-weight: 700; margin-bottom: 0.25rem;">Specialization</span>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-dark);">{{ $course->teacher->specialization }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Course Meta -->
        <div class="db-card" style="background: var(--primary); color: #fff; border: none;">
            <div class="db-card-body" style="padding: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="bi bi-clock" style="font-size: 1.25rem; color: var(--gold-light);"></i>
                        <div>
                            <small style="display: block; opacity: 0.7; font-size: 0.7rem; text-transform: uppercase;">Duration</small>
                            <span style="font-weight: 600;">{{ $course->duration ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="bi bi-cash-stack" style="font-size: 1.25rem; color: var(--gold-light);"></i>
                        <div>
                            <small style="display: block; opacity: 0.7; font-size: 0.7rem; text-transform: uppercase;">Fee Structure</small>
                            <span style="font-weight: 600;">{{ number_format($course->fee ?? 0) }} PKR</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <i class="bi bi-calendar-check" style="font-size: 1.25rem; color: var(--gold-light);"></i>
                        <div>
                            <small style="display: block; opacity: 0.7; font-size: 0.7rem; text-transform: uppercase;">Enrolled Since</small>
                            <span style="font-weight: 600;">{{ auth()->user()->student->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
