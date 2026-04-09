@extends('layouts.public')
@section('title', 'Gallery — Madrasa Dar-ul-Falah')

@push('styles')
<style>
.gallery-placeholder { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); }
.gallery-placeholder.g2 { background: linear-gradient(135deg, #0a3a5a, #0d5a8a); }
.gallery-placeholder.g3 { background: linear-gradient(135deg, #3a2a0a, #6a4a1a); }
.gallery-placeholder.g4 { background: linear-gradient(135deg, #1a0a3a, #3a1a6a); }
.gallery-placeholder.g5 { background: linear-gradient(135deg, #3a0a1a, #6a1a2d); }
.gallery-placeholder.g6 { background: linear-gradient(135deg, #0a3a2a, #1a6a4a); }
.gallery-placeholder.g7 { background: linear-gradient(135deg, #2a3a0a, #4a6a1a); }
.gallery-placeholder.g8 { background: linear-gradient(135deg, #3a1a0a, #6a3a1a); }
.gallery-placeholder.g9 { background: linear-gradient(135deg, #0a2a3a, #1a4a6a); }
</style>
@endpush

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-camera"></i> Our Moments</div>
    <h1>Gallery</h1>
    <p>Glimpses of life at Madrasa Dar-ul-Falah — learning, ceremonies, activities and more.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Gallery</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Moments</span>
      <h2 class="section-title">Life at <span>Dar-ul-Falah</span></h2>
      <div class="divider"></div>
    </div>

    <!-- Gallery Filter -->
    <div class="filters" style="margin-bottom:2rem">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="events">Events</button>
      <button class="filter-btn" data-filter="classes">Classes</button>
      <button class="filter-btn" data-filter="campus">Campus</button>
      <button class="filter-btn" data-filter="graduation">Graduation</button>
    </div>

    <div class="gallery-grid">
      @forelse($images as $img)
      <div class="gallery-item reveal {{ $loop->index > 3 ? 'stagger-' . ($loop->index % 4) : '' }}" 
           data-category="{{ Str::slug($img->category ?? 'campus') }}"
           data-src="{{ asset('storage/' . $img->image) }}">
        <div class="gallery-img-container" style="height:{{ 200 + ($loop->index % 3) * 40 }}px; background:var(--beige); border-radius:12px; overflow:hidden">
            <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $img->title }}" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <div class="gallery-overlay"><div class="gallery-zoom"><i class="bi bi-search"></i></div></div>
        <div class="gallery-item-caption">{{ $img->title }}</div>
      </div>
      @empty
      <div style="grid-column:1/-1; text-align:center; padding:5rem; background:var(--beige); border-radius:15px;">
          <h3 style="color:var(--primary)">No Gallery Items</h3>
          <p>We are currently uploading new memories. Please check back soon.</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox">
  <button id="lightbox-close" class="lightbox-close">✕</button>
  <div class="lightbox-content">
    <div id="lightbox-img" class="lightbox-img-container">
        <img src="" id="lightbox-main-img" style="max-width:90%; max-height:80vh; border-radius:12px; border:4px solid white;">
        <div class="lb-caption" style="color:white; margin-top:1.5rem; font-size:1.2rem; font-weight:600; text-align:center"></div>
    </div>
    <button id="lightbox-prev" class="lightbox-nav lightbox-prev">‹</button>
    <button id="lightbox-next" class="lightbox-nav lightbox-next">›</button>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Lightbox logic
const lb = document.getElementById('lightbox');
const lbImg = document.getElementById('lightbox-main-img');
const lbCap = lb.querySelector('.lb-caption');
let currentIndex = 0;
const items = Array.from(document.querySelectorAll('.gallery-item'));

items.forEach((item, index) => {
  item.addEventListener('click', () => {
    currentIndex = index;
    showLightbox(item);
  });
});

function showLightbox(item) {
  lbImg.src = item.dataset.src;
  lbCap.textContent = item.querySelector('.gallery-item-caption').textContent;
  lb.classList.add('active');
}

document.getElementById('lightbox-close').addEventListener('click', () => lb.classList.remove('active'));

document.getElementById('lightbox-next').addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % items.length;
  showLightbox(items[currentIndex]);
});

document.getElementById('lightbox-prev').addEventListener('click', () => {
  currentIndex = (currentIndex - 1 + items.length) % items.length;
  showLightbox(items[currentIndex]);
});

// Gallery category filter
document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const f = btn.dataset.filter;
    items.forEach(item => {
      if (f === 'all' || item.dataset.category === f) {
        item.style.display = '';
        setTimeout(() => item.style.opacity = '1', 50);
      } else {
        item.style.opacity = '0';
        setTimeout(() => item.style.display = 'none', 300);
      }
    });
  });
});
</script>
@endpush
