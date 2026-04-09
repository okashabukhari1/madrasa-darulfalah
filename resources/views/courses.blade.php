@extends('layouts.public')
@section('title', 'Courses — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-book"></i> Academic Programs</div>
    <h1>Our Islamic Courses</h1>
    <p>Comprehensive programs in Quranic studies, Arabic language, and Islamic sciences for every level of learner.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Courses</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Filter Programs</span>
      <h2 class="section-title">Explore Our <span>Curriculum</span></h2>
      <div class="divider"></div>
    </div>
    <div class="filters">
      <button class="filter-btn active" data-filter="all">All Courses</button>
      @foreach($categories as $cat)
        <button class="filter-btn" data-filter="{{ $cat->slug }}">{{ $cat->name }}</button>
      @endforeach
    </div>
    <div class="courses-grid">
      @forelse($courses as $course)
      <div class="full-course-card reveal stagger-{{ $loop->iteration }}" data-category="{{ $course->category?->slug ?? 'general' }}">
        <div class="course-card-top {{ $loop->index % 4 == 0 ? 'green' : ($loop->index % 4 == 1 ? 'teal' : ($loop->index % 4 == 2 ? 'navy' : 'purple')) }}" style="position:relative; overflow:hidden;">
          @if($course->image)
            <img src="{{ asset('storage/' . $course->image) }}" alt="" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:0.3;">
          @endif
          <span class="course-icon" style="position:relative; z-index:1;"><i class="bi bi-{{ $course->icon ?? 'book-half' }}"></i></span>
          <span class="course-card-badge" style="position:relative; z-index:1; text-transform: capitalize;">{{ $course->level }}</span>
        </div>
        <div class="course-card-body">
          <h3>
            {{ $course->title }}
            @if($course->urdu_title)
              <div dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 0.9em; color: var(--gold); margin-top: 0.5rem;">{{ $course->urdu_title }}</div>
            @endif
          </h3>
          <p>{{ Str::limit($course->description, 100) }}</p>
          <div class="course-details">
            <div class="course-detail-item"><i class="bi bi-stopwatch"></i> Duration: <strong>{{ $course->duration }}</strong></div>
            <div class="course-detail-item"><i class="bi bi-person"></i> Teacher: <strong>{{ $course->teacher->name ?? 'Dept. Faculty' }}</strong></div>
            <div class="course-detail-item"><i class="bi bi-cash"></i> Fee: <strong>{{ $course->fee > 0 ? '$' . number_format($course->fee, 2) : 'Free' }}</strong></div>
          </div>

          <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 1rem;">
            <a href="{{ route('public.courses.show', $course->slug) }}" class="btn-gold" style="text-align:center; padding: 0.8rem; font-size: 0.9rem; text-decoration:none; color: var(--primary); background: var(--gold-light); border: 1px solid var(--gold); border-radius: 8px; font-weight: 600; transition: all 0.3s;">View Details</a>
            <button class="enroll-btn" style="margin-top:0;" onclick="location.href='{{ route('admission') }}'">Apply Now</button>
          </div>
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1; text-align:center; padding:5rem; background:var(--beige); border-radius:15px;">
          <h3 style="color:var(--primary)">No Courses Available</h3>
          <p>We are currently updating our academic catalog. Please check back soon.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="cta-inner reveal">
    <h2 class="cta-title">Ready to Begin Your Studies?</h2>
    <p class="cta-text">New batch starting April 2025. Submit your application today and begin your journey of sacred knowledge.</p>
    <a href="{{ route('admission') }}" class="btn-primary">Apply for Admission</a>
  </div>
</section>
@endsection


