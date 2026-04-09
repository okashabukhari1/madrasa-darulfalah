@extends('layouts.public')

@section('title', $announcement->title . ' — Madrasa Dar-ul-Falah')

@section('content')

{{-- Page Hero --}}
<div class="ann-detail-hero">
    <div class="ann-hero-pattern"></div>
    <div class="ann-hero-inner">
        <span class="ann-detail-badge">
            <i class="bi bi-megaphone-fill"></i>
            {{ ucfirst($announcement->type) }} Announcement
        </span>
        <h1 class="ann-detail-title">{{ $announcement->title }}</h1>
        <div class="ann-detail-meta">
            <span class="ann-meta-pill">
                <i class="bi bi-calendar3"></i>
                {{ $announcement->created_at->format('l, d F Y') }}
            </span>
            <span class="ann-meta-pill">
                <i class="bi bi-people-fill"></i>
                For: {{ ucfirst($announcement->type) }}s
            </span>
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="ann-detail-body">
    <div class="ann-detail-container">
        <div class="ann-detail-grid">

            {{-- Main Card --}}
            <div class="ann-main-card">
                <div class="ann-card-header">
                    <span class="ann-section-label">Full Content</span>
                    <div class="ann-card-ornament">✦</div>
                </div>

                @php
                    $isUrdu = preg_match('/[\x{0600}-\x{06FF}]/u', $announcement->content ?? '');
                @endphp
                <div class="ann-content {{ $isUrdu ? 'urdu-text' : '' }}">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                <div class="ann-card-divider"></div>

                {{-- Official Notice Strip --}}
                <div class="ann-notice-strip">
                    <div class="ann-notice-icon"><i class="bi bi-shield-fill-check"></i></div>
                    <div>
                        <div class="ann-notice-title">Official Announcement</div>
                        <div class="ann-notice-sub">Issued by Madrasa Dar-ul-Falah Administration · {{ $announcement->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="ann-detail-sidebar">

                {{-- Announcement Info --}}
                <div class="ann-sidebar-card ann-info-box">
                    <h4 class="ann-sidebar-title"><i class="bi bi-info-circle-fill"></i> Details</h4>
                    <div class="ann-detail-row">
                        <span class="ann-detail-key">Type</span>
                        <span class="ann-type-tag">{{ ucfirst($announcement->type) }}</span>
                    </div>
                    <div class="ann-detail-row">
                        <span class="ann-detail-key">Published</span>
                        <span class="ann-detail-val">{{ $announcement->created_at->format('d M Y') }}</span>
                    </div>
                    @if($announcement->expires_at)
                    <div class="ann-detail-row">
                        <span class="ann-detail-key">Expires</span>
                        <span class="ann-detail-val">{{ $announcement->expires_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>

                {{-- Share --}}
                <div class="ann-sidebar-card">
                    <h4 class="ann-sidebar-title"><i class="bi bi-share-fill"></i> Share</h4>
                    <div class="ann-share-btns">
                        <a href="https://wa.me/?text={{ urlencode($announcement->title . ' - ' . url()->current()) }}" target="_blank" class="ann-share-btn whatsapp">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="ann-share-btn facebook">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                    </div>
                </div>

                {{-- Contact Box --}}
                <div class="ann-sidebar-card ann-contact-box">
                    <div class="ann-contact-icon">🕌</div>
                    <h4>Have Questions?</h4>
                    <p>Reach out to our administration for clarifications on this announcement.</p>
                    <a href="{{ route('contact') }}" class="ann-contact-btn">
                        <i class="bi bi-envelope-fill"></i> Contact Us
                    </a>
                </div>

                {{-- Back --}}
                <a href="{{ route('home') }}" class="ann-back-btn">
                    <i class="bi bi-arrow-left-circle-fill"></i> Back to Homepage
                </a>

            </div>
        </div>
    </div>
</section>

<style>
/* ===== Announcement Detail Hero ===== */
.ann-detail-hero {
    position: relative;
    background: linear-gradient(135deg, #1A202C 0%, #2D3748 50%, #1A202C 100%);
    padding: 120px 2rem 80px;
    text-align: center;
    overflow: hidden;
}
.ann-hero-pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23c9a84c' fill-opacity='0.06'%3E%3Cpath d='M30 0l8.66 5v10L30 20l-8.66-5V5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.ann-hero-inner {
    position: relative; z-index: 1;
    max-width: 800px; margin: 0 auto;
}
.ann-detail-badge {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(201,168,76,0.2);
    border: 1px solid rgba(201,168,76,0.5);
    color: var(--gold-light);
    padding: 0.45rem 1.2rem;
    border-radius: 25px; font-size: 0.8rem;
    letter-spacing: 2px; text-transform: uppercase;
    font-weight: 700; margin-bottom: 1.5rem;
    animation: fadeInDown 0.6s ease both;
}
.ann-detail-title {
    font-family: var(--font-heading), 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
    font-size: clamp(1.8rem, 4vw, 3rem);
    color: #fff; margin-bottom: 2rem;
    line-height: 1.35;
    animation: fadeInUp 0.6s ease 0.2s both;
    text-shadow: 0 4px 20px rgba(0,0,0,0.4);
}
.ann-detail-meta {
    display: flex; flex-wrap: wrap; gap: 0.75rem;
    justify-content: center;
    animation: fadeInUp 0.6s ease 0.4s both;
}
.ann-meta-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.85);
    padding: 0.5rem 1.1rem; border-radius: 25px;
    font-size: 0.88rem;
}
.ann-meta-pill i { color: var(--gold); }

/* ===== Body ===== */
.ann-detail-body {
    background: #f0ede8;
    padding: 3rem 2rem 5rem;
}
.ann-detail-container { max-width: 1200px; margin: 0 auto; }
.ann-detail-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 2.5rem;
    margin-top: -3rem;
}

/* ===== Main Card ===== */
.ann-main-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.1);
    padding: 3rem;
    animation: fadeInUp 0.5s ease 0.3s both;
}
.ann-card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 2rem;
}
.ann-section-label {
    font-size: 0.75rem; letter-spacing: 3px;
    text-transform: uppercase; font-weight: 700;
    color: var(--gold-dark);
}
.ann-section-label::before, .ann-section-label::after { content: ' ✦ '; }
.ann-card-ornament { color: var(--gold); font-size: 1.5rem; opacity: 0.4; }
.ann-content {
    font-size: 1.1rem; line-height: 2.1;
    color: var(--text-medium);
}
.ann-content.urdu-text {
    direction: rtl; text-align: right;
    font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
    font-size: 1.3rem; line-height: 2.5;
}
.ann-card-divider { height: 1px; background: var(--beige-dark); margin: 2.5rem 0; }

.ann-notice-strip {
    display: flex; align-items: center; gap: 1rem;
    padding: 1.25rem 1.5rem; border-radius: 12px;
    background: rgba(26,107,60,0.07);
    border-left: 4px solid var(--primary);
}
.ann-notice-icon {
    width: 44px; height: 44px; min-width: 44px;
    background: var(--primary); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem;
}
.ann-notice-title { font-weight: 700; color: var(--primary); font-size: 0.92rem; }
.ann-notice-sub { font-size: 0.78rem; color: var(--text-light); margin-top: 0.2rem; }

/* ===== Sidebar ===== */
.ann-detail-sidebar { display: flex; flex-direction: column; gap: 1.5rem; }
.ann-sidebar-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.07);
    padding: 1.75rem;
    animation: fadeInRight 0.5s ease 0.4s both;
}
.ann-sidebar-title {
    font-size: 0.92rem; font-weight: 700;
    color: var(--text-dark); margin-bottom: 1.25rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.ann-sidebar-title i { color: var(--primary); }
.ann-detail-row {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; padding: 0.7rem 0;
    border-bottom: 1px solid var(--beige);
    font-size: 0.88rem;
}
.ann-detail-row:last-child { border-bottom: none; }
.ann-detail-key { color: var(--text-light); font-weight: 600; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 1px; }
.ann-detail-val { color: var(--text-dark); font-weight: 600; }
.ann-type-tag {
    background: rgba(26,107,60,0.1); color: var(--primary);
    padding: 0.25rem 0.75rem; border-radius: 20px;
    font-size: 0.78rem; font-weight: 700;
    text-transform: capitalize;
}

.ann-share-btns { display: flex; flex-direction: column; gap: 0.75rem; }
.ann-share-btn {
    display: flex; align-items: center; gap: 0.7rem;
    padding: 0.7rem 1.2rem; border-radius: 10px;
    font-size: 0.88rem; font-weight: 600;
    text-decoration: none; transition: var(--transition);
}
.ann-share-btn.whatsapp { background: rgba(37,211,102,0.1); color: #25D366; border: 1px solid rgba(37,211,102,0.25); }
.ann-share-btn.whatsapp:hover { background: #25D366; color: #fff; }
.ann-share-btn.facebook { background: rgba(24,119,242,0.1); color: #1877F2; border: 1px solid rgba(24,119,242,0.25); }
.ann-share-btn.facebook:hover { background: #1877F2; color: #fff; }

.ann-contact-box {
    text-align: center;
    background: linear-gradient(135deg, #2D3748, #1A202C);
    color: #fff;
}
.ann-contact-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.ann-contact-box h4 { color: var(--gold-light); font-size: 1.05rem; margin-bottom: 0.5rem; }
.ann-contact-box p { color: rgba(255,255,255,0.7); font-size: 0.85rem; line-height: 1.7; margin-bottom: 1.5rem; }
.ann-contact-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--gold); color: var(--primary-dark);
    padding: 0.65rem 1.4rem; border-radius: 25px;
    font-weight: 700; font-size: 0.85rem; text-decoration: none;
    transition: var(--transition);
}
.ann-contact-btn:hover { background: var(--gold-light); transform: translateY(-2px); }

.ann-back-btn {
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    background: #fff; color: var(--text-dark);
    border: 2px solid var(--beige-dark);
    padding: 0.85rem 1.5rem; border-radius: 12px;
    font-weight: 700; font-size: 0.9rem; text-decoration: none;
    transition: var(--transition);
}
.ann-back-btn:hover { border-color: var(--primary); color: var(--primary); transform: translateY(-2px); }
.ann-back-btn i { font-size: 1.2rem; }

/* Responsive */
@media (max-width: 900px) {
    .ann-detail-grid { grid-template-columns: 1fr; }
    .ann-detail-sidebar { order: -1; }
    .ann-main-card { padding: 2rem; }
    .ann-detail-hero { padding: 100px 1.5rem 60px; }
}
@media (max-width: 600px) {
    .ann-detail-meta { flex-direction: column; align-items: center; }
}
</style>

@endsection


