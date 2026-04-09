@extends('layouts.public')
@section('title', 'Teachers — Madrasa Dar-ul-Falah')

@push('styles')
<style>
/* Section */
.teachers-section {
  padding: 60px 0;
  text-align: center;
}

.section-title-custom {
  font-size: 32px;
  color: #1b5e20;
  margin-bottom: 40px;
  font-family: var(--font-heading);
}

/* Grid */
.teacher-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

/* Card */
.teacher-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0,0,0,0.06);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
  border: 1px solid rgba(0,0,0,0.03);
  text-align: left;
}

.teacher-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 40px rgba(27, 94, 32, 0.12);
  border-color: var(--gold-light);
}

/* Image */
.card-image-wrap {
  width: 100%;
  height: 250px;
  overflow: hidden;
  position: relative;
}

.card-image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.teacher-card:hover .card-image-wrap img {
  transform: scale(1.1);
}

/* Body */
.card-body {
  padding: 25px;
}

.card-body h3 {
  color: #1b5e20;
  margin: 0 0 5px;
  font-size: 1.4rem;
  font-family: var(--font-heading);
}

.urdu-name-custom {
  font-size: 1.2rem;
  color: var(--gold-dark);
  margin-bottom: 12px;
  font-family: 'Jameel Noori Nastaleeq', serif;
  display: block;
}

/* Tags */
.designation-badge {
  display: inline-block;
  background: #e8f5e9;
  color: #2e7d32;
  padding: 6px 14px;
  border-radius: 50px;
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 15px;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.specialization-text {
  color: var(--gold-dark);
  font-weight: 600;
  margin-bottom: 15px;
  font-size: 0.95rem;
}

/* Info */
.info-list {
  font-size: 13.5px;
  color: #555;
  margin-bottom: 15px;
  padding-top: 15px;
  border-top: 1px dashed #eee;
}

.info-list p {
  margin: 5px 0;
  display: flex;
  align-items: center;
  gap: 8px;
}

.info-list i {
  color: var(--gold);
}

/* Bio */
.bio-text {
  font-size: 14px;
  color: #666;
  line-height: 1.6;
  font-style: italic;
}
</style>
@endpush

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-mortarboard"></i> Our Scholars</div>
    <h1>Meet Our Dedicated Teachers</h1>
    <p>Experienced Islamic scholars and educators dedicated to guiding students on their path of knowledge.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Teachers</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Faculty</span>
      <h2 class="section-title">Distinguished <span>Scholars</span></h2>
      <div class="divider"></div>
      <p class="section-desc">Our 42+ faculty members bring decades of expertise across all Islamic disciplines.</p>
    </div>
    <div class="teacher-grid">
      @forelse($teachers as $teacher)
      <a href="{{ route('public.teachers.show', $teacher->slug) }}" class="teacher-card reveal stagger-{{ $loop->iteration }}" style="text-decoration: none; color: inherit; display: block;">
        <div class="card-image-wrap">
          <img src="{{ $teacher->avatar_url }}" alt="{{ $teacher->name }}">
        </div>

        <div class="card-body">
          <h3>{{ $teacher->name ?? ($teacher->urdu_name ? 'Scholar' : 'Faculty Member') }}</h3>
          @if($teacher->urdu_name)
            <span class="urdu-name-custom" dir="rtl">{{ $teacher->urdu_name }}</span>
          @endif

          <span class="designation-badge">{{ $teacher->designation }}</span>

          <p class="specialization-text">
            @foreach(explode(',', $teacher->specialization) as $spec)
                {{ trim($spec) }}{{ !$loop->last ? ', ' : '' }}
            @endforeach
          </p>

          <div class="info-list">
            <p><i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $teacher->email }}</p>
            <p><i class="bi bi-telephone"></i> <strong>Phone:</strong> {{ $teacher->phone }}</p>
            <p><i class="bi bi-award"></i> <strong>Experience:</strong> {{ $teacher->experience }} Years</p>
          </div>

          <p class="bio-text">
            {{ $teacher->bio ?? 'A dedicated faculty member committed to Islamic excellence and academic growth.' }}
          </p>
        </div>
      </a>
      @empty
      <div style="grid-column:1/-1; text-align:center; padding:5rem; background:var(--white); border-radius:20px; box-shadow: var(--shadow-sm);">
          <h3 style="color:var(--primary)">Faculty Details Coming Soon</h3>
          <p>We are currently updating our faculty profiles. Please check back later.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Join the team -->
<section class="section" style="background:var(--beige)">
  <div class="section-inner" style="text-align:center;max-width:700px;margin:0 auto">
    <div class="reveal">
      <span class="section-label">Join Our Team</span>
      <h2 class="section-title">Are You a <span>Qualified Scholar?</span></h2>
      <div class="divider"></div>
      <p style="color:var(--text-medium);font-size:1.05rem;margin:1.5rem 0 2rem;line-height:1.9">We are always looking for dedicated, qualified Islamic scholars to join our faculty. If you have a passion for teaching and a commitment to Islamic education, we'd love to hear from you.</p>
      <a href="{{ route('contact') }}" class="btn-primary">Get in Touch</a>
    </div>
  </div>
</section>

<section class="cta-section">
  <div class="cta-inner reveal">
    <h2 class="cta-title">Learn From the Best Scholars</h2>
    <p class="cta-text">Our teachers are not just educators — they are guides, mentors, and role models for every student.</p>
    <a href="{{ route('admission') }}" class="btn-primary">Apply for Admission</a>
  </div>
</section>
@endsection


