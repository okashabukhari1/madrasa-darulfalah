@extends('layouts.public')
@section('title', 'Madrasa Dar-ul-Falah — Home')

@section('content')
<!-- Hero Section -->
<section class="hero">
  <canvas id="hero-canvas"></canvas>
  <div class="hero-pattern"></div>
  <div class="hero-content">
    <div class="hero-text">
      <div class="hero-badge">Est. 1995 · Lahore, Pakistan</div>
      <h1 class="hero-title">
        <span class="arabic">مدرسة دار الفلاح</span>
        <span class="english">Madrasa Dar-ul-Falah</span>
      </h1>
      <p class="hero-subtitle">A beacon of Islamic education — nurturing minds with Quran, knowledge, and character since 1995. Join our family of scholars, seekers, and servants of Allah.</p>
      <div class="hero-btns">
        <a href="{{ route('admission') }}" class="btn-primary">Apply for Admission</a>
        <a href="{{ route('courses') }}" class="btn-secondary">Explore Courses</a>
      </div>
      <div class="hero-stats">
        <div class="hero-stat"><span class="num" data-count="1200" data-suffix="+">0+</span><span class="label">Graduates</span></div>
        <div class="hero-stat"><span class="num" data-count="28" data-suffix="+">0+</span><span class="label">Years</span></div>
        <div class="hero-stat"><span class="num" data-count="15">0</span><span class="label">Courses</span></div>
        <div class="hero-stat"><span class="num" data-count="42">0</span><span class="label">Teachers</span></div>
      </div>
    </div>
    <div class="hero-visual">
      <canvas id="lantern-canvas" width="450" height="450"></canvas>
    </div>
  </div>
  <div class="hero-scroll">
    <span>Scroll</span><span class="arrow">↓</span>
  </div>
</section>

<!-- Marquee -->
<div class="marquee-section">
  <div class="marquee-track">
    <span class="marquee-item">Hifz-ul-Quran</span>
    <span class="marquee-item">Tajweed ul Quran</span>
    <span class="marquee-item">Alim Course</span>
    <span class="marquee-item">Arabic Language</span>
    <span class="marquee-item">Islamic Studies</span>
    <span class="marquee-item">Fiqh & Hadith</span>
    <span class="marquee-item">Seerah</span>
    <span class="marquee-item">Tafseer</span>
    <span class="marquee-item">Islamic Ethics</span>
  </div>
</div>

<!-- Introduction -->
<section class="section intro-section pattern-bg">
  <div class="section-inner intro-grid">
    <div class="intro-img-wrap reveal-left">
      <div class="intro-img-main">
        <span class="placeholder-art"><i class="bi bi-bank"></i></span>
      </div>
      <div class="intro-img-badge">
        <span class="years">28</span>
        <span class="text">Years of Excellence</span>
      </div>
    </div>
    <div class="intro-text reveal-right">
      <span class="section-label">About Us</span>
      <h2>Rooted in <span>Faith</span>, Growing in Knowledge</h2>
      <div class="divider"></div>
      <p>Madrasa Dar-ul-Falah has been a cornerstone of Islamic education in Lahore since 1995. Our institute combines traditional Islamic scholarship with modern pedagogical methods, producing well-rounded Muslim scholars who excel in both religious and worldly domains.</p>
      <p>We believe that seeking knowledge is an obligation upon every Muslim. Our dedicated faculty and comprehensive curriculum ensure every student develops a strong connection with Allah, His book, and the Sunnah of His Prophet ﷺ.</p>
      <div class="intro-features">
        <div class="intro-feature stagger-1">
          <div class="icon"><i class="bi bi-book"></i></div>
          <div><div class="label">Quran Memorization</div><div class="sub">Complete Hifz program</div></div>
        </div>
        <div class="intro-feature stagger-2">
          <div class="icon"><i class="bi bi-mortarboard"></i></div>
          <div><div class="label">Qualified Faculty</div><div class="sub">42+ experienced scholars</div></div>
        </div>
        <div class="intro-feature stagger-3">
          <div class="icon">🏫</div>
          <div><div class="label">Modern Facilities</div><div class="sub">Library, labs & more</div></div>
        </div>
        <div class="intro-feature stagger-4">
          <div class="icon"><i class="bi bi-moon"></i></div>
          <div><div class="label">Islamic Environment</div><div class="sub">Nurturing & safe</div></div>
        </div>
      </div>
      <a href="{{ route('about') }}" class="btn-primary" style="margin-top:1.5rem">Learn More About Us</a>
    </div>
  </div>
</section>

<!-- Courses Preview -->
<section class="section" id="courses">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Programs</span>
      <h2 class="section-title">Featured <span>Courses</span></h2>
      <div class="divider"></div>
      <p class="section-desc">Comprehensive Islamic education programs designed for every level of learner.</p>
    </div>
    <div class="courses-grid">
      @foreach($featuredCourses as $course)
      <div class="course-card reveal stagger-{{ $loop->iteration + 2 }}">
        <div class="course-card-top {{ $loop->even ? 'purple' : 'green' }}">
          <span class="course-icon"><i class="bi bi-{{ $course->icon ?? 'book' }}"></i></span>
          <span class="course-card-badge">{{ $course->duration ?? 'New' }}</span>
        </div>
        <div class="course-card-body">
          <h3>{{ $course->title }} @if($course->urdu_title) <span dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 0.9em; color: var(--gold); margin-left: 0.5rem;">{{ $course->urdu_title }}</span> @endif</h3>
          <p>{{ Str::words($course->description, 15) }}</p>
          <div class="course-meta">
            <div class="course-meta-item"><i class="bi bi-stopwatch"></i> <span>{{ $course->duration }}</span></div>
            <div class="course-meta-item"><i class="bi bi-person"></i> <span>{{ $course->teacher->name ?? 'Dept. Faculty' }}</span></div>
          </div>
          <div style="margin-top: 1rem; border-top: 1px solid var(--beige-dark); padding-top: 1rem;">
             <a href="{{ route('public.courses.show', $course->slug) }}" style="color:var(--gold); font-weight:700; font-size:0.95rem; text-decoration:none; display: flex; align-items: center; gap: 0.5rem;">View Full Details <i class="bi bi-arrow-right-circle-fill"></i></a>
          </div>
        </div>
      </div>
      @endforeach
      
      <div class="course-card reveal stagger-1" style="display:flex;align-items:center;justify-content:center;background:var(--beige);min-height:200px;">
        <div style="text-align:center;padding:2rem;">
          <div style="font-size:3rem;margin-bottom:1rem">📚</div>
          <h3 style="color:var(--primary)">View More Courses</h3>
          <p style="font-size:.85rem;color:var(--text-medium);margin:.5rem 0 1rem">Discover our complete curriculum</p>
          <a href="{{ route('courses') }}" class="btn-primary" style="font-size:.85rem;padding:.7rem 1.5rem">Browse All Courses</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Teachers Preview -->
<section class="section teachers-section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Scholars</span>
      <h2 class="section-title" style="color:var(--white)">Meet Our <span style="color:var(--gold-light)">Teachers</span></h2>
      <div class="divider"></div>
      <p class="section-desc">Dedicated scholars and educators committed to excellence in Islamic teaching.</p>
    </div>
    <div class="teachers-grid">
      @forelse($teachers as $teacher)
      <div class="teacher-card reveal stagger-{{ $loop->iteration }}">
        <div class="teacher-avatar">
          <img src="{{ $teacher->avatar_url }}" alt="{{ $teacher->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
        </div>
        <div class="teacher-name">{{ $teacher->name }} @if($teacher->urdu_name) <div dir="rtl" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; font-size: 0.9em; color: var(--gold-light); margin-top: 0.2rem;">{{ $teacher->urdu_name }}</div> @endif</div>
        <div class="teacher-role">{{ $teacher->designation }}</div>
        <div class="teacher-qual">{{ $teacher->specialization }} · {{ $teacher->experience }} Years Experience</div>
      </div>
      @empty
      <div style="grid-column:1/-1; text-align:center; color:rgba(255,255,255,0.6); padding:3rem">
        <p>Faculty details are being updated.</p>
      </div>
      @endforelse
    </div>
    <div style="text-align:center;margin-top:3rem">
      <a href="{{ route('teachers') }}" class="btn-primary">View All Teachers</a>
    </div>
  </div>
</section>

<!-- Announcements & Events -->
<section class="section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Stay Updated</span>
      <h2 class="section-title">Announcements & <span>Events</span></h2>
      <div class="divider"></div>
    </div>
    <div class="announce-grid">
      <div class="announce-list">
        @forelse($announcements as $announce)
        <div class="announce-item reveal stagger-{{ $loop->iteration }}">
          <div class="announce-date">
            <div class="day">{{ $announce->created_at->format('d') }}</div>
            <div class="month">{{ $announce->created_at->format('M') }}</div>
          </div>
          <div class="announce-content">
            <h4 style="text-align: auto; font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">
              <a href="{{ route('public.announcements.show', $announce->id) }}" style="color: inherit; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='inherit'">{{ $announce->title }}</a>
            </h4>
            <p style="text-align: auto; font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; line-height: 1.8;">
              {{ str($announce->content)->limit(150) }}
              <a href="{{ route('public.announcements.show', $announce->id) }}" style="color: var(--primary); font-weight: 600; font-size: 0.9rem; margin-left: 0.5rem;">Read More...</a>
            </p>
            <span class="announce-tag" style="text-transform: capitalize;">{{ $announce->type }} Notification</span>
          </div>
        </div>
        @empty
        <div style="padding: 2rem; background: var(--beige); border-radius: 15px; text-align: center;">
          <p style="color: var(--text-medium);">No recent announcements at this time.</p>
        </div>
        @endforelse
      </div>
      <div class="events-sidebar reveal-right">
        <h3><i class="bi bi-calendar"></i> Upcoming Events</h3>
        @forelse($events as $event)
        <a href="{{ route('public.events.show', $event->id) }}" class="event-item reveal-right stagger-{{ $loop->iteration }}" style="text-decoration: none; display: block; border: 1px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--gold)'; this.style.background='rgba(255,255,255,0.08)'" onmouseout="this.style.borderColor='transparent'; this.style.background='rgba(255,255,255,0.05)'">
          <div class="event-time">
            {{ $event->event_date->format('M d, Y') }} · {{ $event->event_date->format('h:i A') }}
          </div>
          <div class="event-name" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; text-align: auto;">{{ $event->title }}</div>
          <div class="event-loc" style="font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; text-align: auto;">
            <i class="bi bi-geo-alt"></i> {{ $event->location ?? 'To Be Announced' }}
          </div>
        </a>
        @empty
        <div style="padding: 1.5rem; background: rgba(255,255,255,0.05); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); text-align: center;">
          No upcoming events scheduled.
        </div>
        @endforelse
      </div>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="section testimonials-section">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Student Stories</span>
      <h2 class="section-title">What Our <span>Community</span> Says</h2>
      <div class="divider"></div>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card reveal stagger-1">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">Alhamdulillah, my son completed his Hifz at Dar-ul-Falah in just 3 years. The teachers are incredibly dedicated and the environment is exactly what every Muslim parent dreams of for their child.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">A</div>
          <div><div class="testimonial-name">Ahmad Bilal</div><div class="testimonial-role">Parent of Hafiz Student</div></div>
        </div>
      </div>
      <div class="testimonial-card reveal stagger-2">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">The Alim course here gave me not just knowledge but a complete transformation. Mufti Abdur Rauf's classes are life-changing. I'm now teaching at my local mosque — all thanks to this amazing institution.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">M</div>
          <div><div class="testimonial-name">Muhammad Umar</div><div class="testimonial-role">Graduate, Class of 2020</div></div>
        </div>
      </div>
      <div class="testimonial-card reveal stagger-3">
        <div class="testimonial-stars">★★★★★</div>
        <p class="testimonial-text">As a woman seeking Islamic education, I felt completely welcomed and supported. The sisters' section is exceptional. The Arabic program helped me read the Quran with real understanding.</p>
        <div class="testimonial-author">
          <div class="testimonial-avatar">F</div>
          <div><div class="testimonial-name">Fatima Noor</div><div class="testimonial-role">Arabic Language Student</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-inner reveal">
    <div class="cta-verse">اقْرَأْ بِاسْمِ رَبِّكَ الَّذِي خَلَقَ</div>
    <div class="cta-verse-ref">Quran 96:1 — "Read in the name of your Lord who created"</div>
    <h2 class="cta-title">Begin Your Journey of Sacred Knowledge</h2>
    <p class="cta-text">Seats are limited for the upcoming batch. Join hundreds of students who have transformed their lives through Islamic education at Dar-ul-Falah.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="{{ route('admission') }}" class="btn-primary">Apply for Admission</a>
      <a href="{{ route('contact') }}" class="btn-secondary">Contact Us</a>
    </div>
  </div>
</section>
@endsection


