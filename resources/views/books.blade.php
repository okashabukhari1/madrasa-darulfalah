@extends('layouts.public')
@section('title', 'Maktaba (Library) — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-book"></i> Digital Library</div>
    <h1>Maktaba Dar-ul-Falah</h1>
    <p>Access our collection of Islamic literature, course materials, and reference books.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Library</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Collection</span>
      <h2 class="section-title">Islamic <span>Literature</span></h2>
      <div class="divider"></div>
    </div>
    
    <div class="courses-grid">
        @forelse($books as $book)
        <div class="course-card reveal">
            <div class="course-card-top" style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); height:220px;">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width:100%;height:100%;object-fit:cover;opacity:0.9;">
                @else
                    <span class="course-icon"><i class="bi bi-book-half"></i></span>
                @endif
                <span class="course-card-badge">{{ $book->bookCategory->name ?? $book->category ?? 'General' }}</span>
            </div>
            <div class="course-card-body">
                <h3>{{ $book->title }}</h3>
                <p style="font-size:0.85rem;color:var(--primary);font-weight:600;margin-top:-0.5rem;margin-bottom:1rem;">By {{ $book->author ?? 'Dar-ul-Falah' }}</p>
                <p>{{ Str::limit($book->description, 100) }}</p>
                
                <a href="{{ $book->file_path ? asset('storage/' . $book->file_path) : '#' }}" target="_blank" class="enroll-btn" style="text-align:center;display:block;margin-top:1.5rem;text-decoration:none;">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 4rem; background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-sm);">
            <div style="font-size: 3rem; color: var(--gold); margin-bottom: 1rem;"><i class="bi bi-journal-x"></i></div>
            <h3>No Books Available Yet</h3>
            <p style="color: var(--text-medium);">We are currently updating our digital library. Please check back later.</p>
        </div>
        @endforelse
    </div>
  </div>
</section>
@endsection
