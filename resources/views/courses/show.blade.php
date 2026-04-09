@extends('layouts.public')

@section('title', ($course->meta_title ?? $course->title) . ' — Madrasa Dar-ul-Falah')
@if($course->meta_description)
    @section('meta_description', $course->meta_description)
@endif

@section('content')
<section class="page-hero" style="padding: 6rem 0 3rem;">
    <div class="page-hero-inner">
        <div class="page-hero-badge">
            <i class="bi bi-book"></i> {{ $course->category->name ?? 'Course Detail' }}
        </div>
        <h1>{{ $course->title }}</h1>
        @if($course->urdu_title)
            <div dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 2.2rem; color: var(--gold); margin-top: 1rem;">
                {{ $course->urdu_title }}
            </div>
        @endif
        <div class="breadcrumb" style="margin-top:2rem;">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('courses') }}">Courses</a>
            <span>/</span>
            <span>{{ $course->title }}</span>
        </div>
    </div>
</section>

<section class="section pattern-bg">
    <div class="section-inner">
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 3rem; align-items: start;">
            
            <!-- Main Content -->
            <div class="course-main-content reveal-left">
                <div class="db-card" style="padding: 2.5rem; background: var(--white); box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div style="margin-bottom: 2.5rem;">
                        <h2 style="color: var(--primary); margin-bottom: 1rem; border-left: 4px solid var(--gold); padding-left: 1rem;">Course Overview</h2>
                        <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-dark);">{{ $course->description }}</p>
                        
                        @if($course->urdu_description)
                            <div dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 1.4rem; color: var(--text-medium); line-height: 2; margin-top: 1.5rem; text-align: right; padding: 1.5rem; background: var(--beige-light); border-radius: 12px; border-right: 4px solid var(--gold);">
                                {{ $course->urdu_description }}
                            </div>
                        @endif
                    </div>

                    @if($course->content)
                        <div class="course-curriculum" style="margin-top: 3rem;">
                            <h2 style="color: var(--primary); margin-bottom: 1.5rem; border-left: 4px solid var(--gold); padding-left: 1rem;">Curriculum & Details</h2>
                            @php
                                $lines = array_filter(explode("\n", str_replace("\r", "", $course->content)));
                            @endphp
                            
                            @if(count($lines) > 1)
                                <ul class="curriculum-list" style="list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                    @foreach($lines as $line)
                                        @php $line = trim($line, "-* \t\n\r\0\x0B"); @endphp
                                        @if($line)
                                            <li style="display: flex; align-items: flex-start; gap: 0.8rem; color: var(--text-dark); background: rgba(229,190,131,0.05); padding: 0.8rem 1rem; border-radius: 8px; border-left: 3px solid var(--gold);">
                                                <i class="bi bi-check2-circle" style="color: var(--gold); font-size: 1.1rem; margin-top: 0.1rem;"></i>
                                                <span>{{ $line }}</span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <div style="line-height: 1.8; color: var(--text-dark); white-space: pre-wrap; padding: 1.5rem; background: rgba(0,0,0,0.02); border-radius: 12px; border: 1px dashed var(--beige-dark);">{{ $course->content }}</div>
                            @endif
                        </div>
                    @endif

                    <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--beige-dark); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.8rem;">
                            <div style="width: 45px; height: 45px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 1.2rem;">
                                <i class="bi bi-patch-check"></i>
                            </div>
                            <span style="font-weight: 600; color: var(--primary);">Officially Certified Batch 2025</span>
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <button onclick="window.print()" class="btn-secondary" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
                                <i class="bi bi-printer"></i> Print Outline
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="course-sidebar reveal-right">
                <div style="position: sticky; top: 100px;">
                    <!-- Quick Info Card -->
                    <div class="db-card" style="padding: 2rem; background: var(--primary); color: var(--white); overflow: hidden; position: relative;">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 8rem; color: rgba(255,255,255,0.05); transform: rotate(-15deg);">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        
                        <h3 style="color: var(--gold-light); margin-bottom: 1.5rem; font-size: 1.3rem;">Program Summary</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem;">
                                <span style="color: rgba(255,255,255,0.7);"><i class="bi bi-bar-chart" style="margin-right: 0.5rem;"></i> Level</span>
                                <span style="font-weight: 600; text-transform: capitalize;">{{ $course->level }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem;">
                                <span style="color: rgba(255,255,255,0.7);"><i class="bi bi-stopwatch" style="margin-right: 0.5rem;"></i> Duration</span>
                                <span style="font-weight: 600;">{{ $course->duration }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.8rem;">
                                <span style="color: rgba(255,255,255,0.7);"><i class="bi bi-cash" style="margin-right: 0.5rem;"></i> Fee</span>
                                <span style="font-weight: 600; font-size: 1.2rem; color: var(--gold-light);">{{ $course->fee > 0 ? '$' . number_format($course->fee, 2) : 'Free' }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.8rem;">
                                <span style="color: rgba(255,255,255,0.7);"><i class="bi bi-tag" style="margin-right: 0.5rem;"></i> Category</span>
                                <span style="font-weight: 600;">{{ $course->category->name ?? 'General' }}</span>
                            </div>
                        </div>

                        <a href="{{ route('admission') }}" class="btn-gold" style="display: block; width: 100%; margin-top: 1.5rem; text-align: center; text-decoration: none; padding: 1rem; border-radius: 8px; font-weight: 700;">
                            Apply for Admission
                        </a>
                    </div>

                    <!-- Teacher Card -->
                    <div class="db-card" style="margin-top: 2rem; padding: 1.5rem; text-align: center;">
                        <h4 style="color: var(--primary); margin-bottom: 1rem;">Assigned Teacher</h4>
                        <div style="width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 50%; overflow: hidden; border: 3px solid var(--gold-light);">
                            <img src="{{ $course->teacher->avatar_url ?? 'https://ui-avatars.com/api/?name=Teacher&background=random' }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div style="font-weight: 700; color: var(--text-dark);">{{ $course->teacher->name ?? 'Faculty Member' }}</div>
                        <div style="font-size: 0.85rem; color: var(--text-medium); margin-top: 0.2rem;">{{ $course->teacher->specialization ?? 'Islamic Scholar' }}</div>
                        <a href="{{ route('teachers') }}" style="display: inline-block; margin-top: 1rem; color: var(--primary); font-size: 0.9rem; font-weight: 600; text-decoration: none;">View Profile <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@push('styles')
<style>
    .course-main-content h2 {
        font-family: 'Outfit', sans-serif;
        letter-spacing: -0.5px;
    }
    .curriculum-list li {
        transition: all 0.3s ease;
    }
    .curriculum-list li:hover {
        transform: translateX(5px);
        background: rgba(229,190,131,0.1) !important;
    }
    @media (max-width: 992px) {
        .section-inner > div {
            grid-template-columns: 1fr !important;
        }
        .curriculum-list {
            grid-template-columns: 1fr !important;
        }
        .course-sidebar {
            order: -1;
        }
        .course-sidebar > div {
            position: static !important;
        }
    }
</style>
@endpush
@endsection
