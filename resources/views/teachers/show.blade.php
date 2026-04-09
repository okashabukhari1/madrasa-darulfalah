@extends('layouts.public')
@section('title', ($teacher->name ?? 'Teacher Profile') . ' — Madrasa Dar-ul-Falah')

@push('styles')
<style>
.profile-hero {
    background: linear-gradient(135deg, var(--primary-dark), #1b5e20);
    padding: 80px 0 120px;
    color: var(--white);
    position: relative;
    overflow: hidden;
}

.profile-hero::after {
    content: "";
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 30L0 0h60L30 30z' fill='%23ffffff' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
    opacity: 0.5;
}

.profile-container {
    max-width: 1100px;
    margin: -80px auto 80px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 40px;
    padding: 0 20px;
}

/* Sidebar */
.profile-sidebar {
    background: var(--white);
    border-radius: 25px;
    padding: 35px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    height: fit-content;
}

.profile-img-wrap {
    width: 100%;
    height: 300px;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 25px;
    border: 5px solid var(--beige-light);
}

.profile-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.contact-info {
    border-top: 1px solid #eee;
    padding-top: 25px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.contact-item i {
    width: 40px;
    height: 40px;
    background: var(--beige-light);
    color: var(--gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 1.1rem;
}

.contact-item div span {
    display: block;
    font-size: 0.8rem;
    color: #888;
    text-transform: uppercase;
}

.contact-item div p {
    margin: 0;
    font-weight: 600;
    color: var(--text-dark);
}

/* Main Content */
.profile-body {
    background: var(--white);
    border-radius: 25px;
    padding: 50px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.06);
}

.profile-header {
    margin-bottom: 40px;
    border-bottom: 1px solid #eee;
    padding-bottom: 30px;
}

.profile-header h1 {
    font-size: 2.8rem;
    color: var(--primary-dark);
    margin-bottom: 10px;
}

.profile-header .urdu-name {
    font-size: 2rem;
    color: var(--gold-dark);
    font-family: 'Jameel Noori Nastaleeq', serif;
    margin-bottom: 15px;
    display: block;
}

.designation-pill {
    display: inline-block;
    background: #e8f5e9;
    color: #2e7d32;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
}

.section-h {
    font-size: 1.5rem;
    color: var(--primary);
    margin: 40px 0 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.section-h::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
}

.bio-content {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
    white-space: pre-line;
}

.spec-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.spec-tag {
    background: var(--beige-light);
    color: var(--gold-dark);
    padding: 8px 16px;
    border-radius: 10px;
    font-weight: 600;
}

@media (max-width: 900px) {
    .profile-container {
        grid-template-columns: 1fr;
    }
    .profile-body {
        padding: 30px;
    }
}
</style>
@endpush

@section('content')
<section class="profile-hero">
    <div class="container" style="text-align: center;">
        <div class="breadcrumb" style="color: rgba(255,255,255,0.7); margin-bottom: 20px;">
            <a href="{{ route('home') }}" style="color: inherit;">Home</a> / 
            <a href="{{ route('teachers') }}" style="color: inherit;">Teachers</a> / 
            <span>{{ $teacher->name ?? 'Profile' }}</span>
        </div>
    </div>
</section>

<div class="profile-container">
    <!-- Left Sidebar -->
    <aside class="profile-sidebar reveal">
        <div class="profile-img-wrap">
            <img src="{{ $teacher->avatar_url }}" alt="{{ $teacher->name }}">
        </div>

        <div class="contact-info">
            <div class="contact-item">
                <i class="bi bi-award"></i>
                <div>
                    <span>Experience</span>
                    <p>{{ $teacher->experience }} Years</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="bi bi-mortarboard"></i>
                <div>
                    <span>Qualification</span>
                    <p>{{ $teacher->qualification ?? 'MA Islamic Studies' }}</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="bi bi-envelope"></i>
                <div>
                    <span>Email Address</span>
                    <p>{{ $teacher->email }}</p>
                </div>
            </div>
            <div class="contact-item">
                <i class="bi bi-telephone"></i>
                <div>
                    <span>Phone Number</span>
                    <p>{{ $teacher->phone }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="profile-body reveal stagger-1">
        <div class="profile-header">
            <h1>{{ $teacher->name ?? 'Faculty Member' }}</h1>
            @if($teacher->urdu_name)
                <span class="urdu-name" dir="rtl">{{ $teacher->urdu_name }}</span>
            @endif
            <span class="designation-pill">{{ $teacher->designation }}</span>
        </div>

        <h2 class="section-h"><i class="bi bi-person-lines-fill"></i> Biography</h2>
        <div class="bio-content">
            {{ $teacher->bio ?? 'This scholar has been a cornerstone of Madrasa Dar-ul-Falah, dedicated to imparting traditional Islamic values and academic excellence. With a focus on character building and rigorous intellectual development, they continue to inspire the next generation of Muslims.' }}
        </div>

        <h2 class="section-h"><i class="bi bi-patch-check"></i> Specializations</h2>
        <div class="spec-tags">
            @foreach(explode(',', $teacher->specialization) as $spec)
                <span class="spec-tag">{{ trim($spec) }}</span>
            @endforeach
        </div>

        <div style="margin-top: 60px; padding: 30px; border-radius: 20px; background: var(--beige-light); border-left: 5px solid var(--gold);">
            <h4 style="color: var(--primary-dark); margin-bottom: 10px;"><i class="bi bi-quote"></i> Educational Philosophy</h4>
            <p style="color: #666; font-style: italic; font-size: 1.05rem;">"True knowledge is that which benefits the soul and the community. My goal is to foster a deep love for the Quran and Sunnah in every student's heart."</p>
        </div>
    </main>
</div>

<section class="section" style="background:var(--white)">
  <div class="section-inner" style="text-align:center;">
    <h2 class="section-title">Other <span>Distinguished Scholars</span></h2>
    <div class="divider"></div>
    <a href="{{ route('teachers') }}" class="btn-outline">View Faculty Directory</a>
  </div>
</section>
@endsection
