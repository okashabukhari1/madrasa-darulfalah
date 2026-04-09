@extends('layouts.public')

@section('title', $event->title . ' — Madrasa Dar-ul-Falah')

@section('content')

{{-- Page Hero --}}
<div class="event-detail-hero">
    <div class="event-hero-pattern"></div>
    <div class="event-hero-inner">
        <span class="event-detail-badge">
            <i class="bi bi-calendar-event-fill"></i> Upcoming Event
        </span>
        <h1 class="event-detail-title">{{ $event->title }}</h1>
        <div class="event-detail-meta">
            <span class="event-meta-pill">
                <i class="bi bi-calendar3"></i>
                {{ $event->event_date->format('l, d F Y') }}
            </span>
            <span class="event-meta-pill">
                <i class="bi bi-clock-fill"></i>
                {{ $event->event_date->format('h:i A') }}
            </span>
            @if($event->location)
            <span class="event-meta-pill">
                <i class="bi bi-geo-alt-fill"></i>
                {{ $event->location }}
            </span>
            @endif
        </div>
    </div>
</div>

{{-- Main Content --}}
<section class="event-detail-body">
    <div class="event-detail-container">
        <div class="event-detail-grid">

            {{-- Main Card --}}
            <div class="event-main-card">
                <div class="event-card-header">
                    <span class="event-section-label">Event Details</span>
                    <div class="event-card-ornament">✦</div>
                </div>
                @php
                    $isUrdu = preg_match('/[\x{0600}-\x{06FF}]/u', $event->description ?? '');
                @endphp
                <div class="event-description {{ $isUrdu ? 'urdu-text' : '' }}">
                    {!! nl2br(e($event->description)) !!}
                </div>

                <div class="event-card-divider"></div>

                {{-- Info Row --}}
                <div class="event-info-row">
                    <div class="event-info-box">
                        <div class="event-info-icon"><i class="bi bi-calendar-check"></i></div>
                        <div>
                            <div class="event-info-label">Date</div>
                            <div class="event-info-value">{{ $event->event_date->format('d F Y') }}</div>
                        </div>
                    </div>
                    <div class="event-info-box">
                        <div class="event-info-icon"><i class="bi bi-clock"></i></div>
                        <div>
                            <div class="event-info-label">Time</div>
                            <div class="event-info-value">{{ $event->event_date->format('h:i A') }}</div>
                        </div>
                    </div>
                    @if($event->location)
                    <div class="event-info-box">
                        <div class="event-info-icon"><i class="bi bi-geo-alt"></i></div>
                        <div>
                            <div class="event-info-label">Venue</div>
                            <div class="event-info-value">{{ $event->location }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="event-detail-sidebar">
                {{-- Share Box --}}
                <div class="event-sidebar-card">
                    <h4 class="event-sidebar-title"><i class="bi bi-share-fill"></i> Share This Event</h4>
                    <div class="event-share-btns">
                        <a href="https://wa.me/?text={{ urlencode($event->title . ' - ' . url()->current()) }}" target="_blank" class="share-btn whatsapp">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn facebook">
                            <i class="bi bi-facebook"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn twitter">
                            <i class="bi bi-twitter-x"></i> Twitter
                        </a>
                    </div>
                </div>

                {{-- Contact Box --}}
                <div class="event-sidebar-card event-contact-box">
                    <div class="event-contact-icon">🕌</div>
                    <h4>Need More Info?</h4>
                    <p>Contact the administration office for any queries regarding this event.</p>
                    <a href="{{ route('contact') }}" class="event-contact-btn">
                        <i class="bi bi-envelope-fill"></i> Contact Us
                    </a>
                </div>

                {{-- Back Btn --}}
                <a href="{{ route('home') }}" class="event-back-btn">
                    <i class="bi bi-arrow-left-circle-fill"></i> Back to Homepage
                </a>
            </div>

        </div>
    </div>
</section>

<style>
/* ===== Event Detail Hero ===== */
.event-detail-hero {
    position: relative;
    background: linear-gradient(135deg, #0a2818 0%, #0f4a28 45%, #1a6b3c 100%);
    padding: 120px 2rem 80px;
    text-align: center;
    overflow: hidden;
}
.event-hero-pattern {
    position: absolute; inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23c9a84c' fill-opacity='0.05'%3E%3Cpath d='M30 0l8.66 5v10L30 20l-8.66-5V5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.event-hero-inner {
    position: relative; z-index: 1;
    max-width: 800px; margin: 0 auto;
}
.event-detail-badge {
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
.event-detail-title {
    font-family: var(--font-heading), 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
    font-size: clamp(2rem, 5vw, 3.5rem);
    color: #fff; margin-bottom: 2rem;
    line-height: 1.3;
    animation: fadeInUp 0.6s ease 0.2s both;
    text-shadow: 0 4px 20px rgba(0,0,0,0.4);
}
.event-detail-meta {
    display: flex; flex-wrap: wrap; gap: 0.75rem;
    justify-content: center;
    animation: fadeInUp 0.6s ease 0.4s both;
}
.event-meta-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.9);
    padding: 0.5rem 1.1rem; border-radius: 25px;
    font-size: 0.88rem; backdrop-filter: blur(10px);
}
.event-meta-pill i { color: var(--gold); }

/* ===== Event Detail Body ===== */
.event-detail-body {
    background: var(--beige);
    padding: 3rem 2rem 5rem;
}
.event-detail-container {
    max-width: 1200px; margin: 0 auto;
}
.event-detail-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 2.5rem;
    margin-top: -3rem;
}

/* ===== Main Card ===== */
.event-main-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    padding: 3rem;
    animation: fadeInUp 0.5s ease 0.3s both;
}
.event-card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 2rem;
}
.event-section-label {
    font-size: 0.75rem; letter-spacing: 3px;
    text-transform: uppercase; font-weight: 700;
    color: var(--gold-dark);
}
.event-section-label::before, .event-section-label::after { content: ' ✦ '; }
.event-card-ornament {
    color: var(--gold); font-size: 1.5rem; opacity: 0.4;
}
.event-description {
    font-size: 1.15rem; line-height: 2;
    color: var(--text-medium);
    font-family: var(--font-body);
}
.event-description.urdu-text {
    direction: rtl; text-align: right;
    font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
    font-size: 1.3rem; line-height: 2.4;
}
.event-card-divider {
    height: 1px; background: var(--beige-dark);
    margin: 2.5rem 0;
}
.event-info-row {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 1.5rem;
}
.event-info-box {
    display: flex; align-items: flex-start; gap: 1rem;
    padding: 1.2rem; border-radius: 12px;
    background: var(--beige);
    border: 1px solid var(--beige-dark);
    transition: var(--transition);
}
.event-info-box:hover { background: rgba(26,107,60,0.06); border-color: rgba(26,107,60,0.15); }
.event-info-icon {
    width: 42px; height: 42px; min-width: 42px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.1rem;
}
.event-info-label {
    font-size: 0.72rem; text-transform: uppercase;
    letter-spacing: 1.5px; color: var(--text-light);
    font-weight: 700; margin-bottom: 0.2rem;
}
.event-info-value {
    font-size: 0.92rem; font-weight: 600; color: var(--text-dark);
}

/* ===== Sidebar ===== */
.event-detail-sidebar {
    display: flex; flex-direction: column; gap: 1.5rem;
}
.event-sidebar-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    padding: 1.75rem;
    animation: fadeInRight 0.5s ease 0.4s both;
}
.event-sidebar-title {
    font-size: 0.95rem; font-weight: 700;
    color: var(--text-dark); margin-bottom: 1.2rem;
    display: flex; align-items: center; gap: 0.5rem;
}
.event-sidebar-title i { color: var(--primary); }
.event-share-btns {
    display: flex; flex-direction: column; gap: 0.75rem;
}
.share-btn {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.75rem 1.2rem; border-radius: 10px;
    font-size: 0.88rem; font-weight: 600;
    text-decoration: none; transition: var(--transition);
}
.share-btn.whatsapp {
    background: rgba(37,211,102,0.1); color: #25D366;
    border: 1px solid rgba(37,211,102,0.25);
}
.share-btn.whatsapp:hover { background: #25D366; color: #fff; }
.share-btn.facebook {
    background: rgba(24,119,242,0.1); color: #1877F2;
    border: 1px solid rgba(24,119,242,0.25);
}
.share-btn.facebook:hover { background: #1877F2; color: #fff; }
.share-btn.twitter {
    background: rgba(0,0,0,0.05); color: #000;
    border: 1px solid rgba(0,0,0,0.12);
}
.share-btn.twitter:hover { background: #000; color: #fff; }

.event-contact-box {
    text-align: center;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    color: #fff; animation-delay: 0.5s;
}
.event-contact-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.event-contact-box h4 { color: var(--gold-light); font-size: 1.1rem; margin-bottom: 0.5rem; }
.event-contact-box p { color: rgba(255,255,255,0.75); font-size: 0.85rem; line-height: 1.7; margin-bottom: 1.5rem; }
.event-contact-btn {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--gold); color: var(--primary-dark);
    padding: 0.7rem 1.5rem; border-radius: 25px;
    font-weight: 700; font-size: 0.85rem; text-decoration: none;
    transition: var(--transition);
}
.event-contact-btn:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: var(--shadow-gold); }

.event-back-btn {
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    background: #fff; color: var(--primary);
    border: 2px solid var(--primary);
    padding: 0.85rem 1.5rem; border-radius: 12px;
    font-weight: 700; font-size: 0.9rem; text-decoration: none;
    transition: var(--transition); animation: fadeInUp 0.5s ease 0.6s both;
}
.event-back-btn:hover { background: var(--primary); color: #fff; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(26,107,60,0.3); }
.event-back-btn i { font-size: 1.2rem; }

/* Responsive */
@media (max-width: 900px) {
    .event-detail-grid { grid-template-columns: 1fr; }
    .event-detail-sidebar { order: -1; }
    .event-main-card { padding: 2rem; }
    .event-detail-hero { padding: 100px 1.5rem 60px; }
}
@media (max-width: 600px) {
    .event-detail-meta { flex-direction: column; align-items: center; }
    .event-info-row { grid-template-columns: 1fr; }
}
</style>

@endsection


