@extends('teacher.layouts.app')
@section('title', 'Announcements')
@section('page_title', 'Announcements')

@section('content')
<div style="max-width:900px;">
    @forelse($announcements as $ann)
    <div class="db-card" style="margin-bottom:1.5rem; {{ $loop->first ? 'border-left:4px solid var(--gold);' : '' }}">
        <div class="db-card-body" style="padding:2rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem; margin-bottom:1rem;">
                <span style="font-size:0.8rem; color:var(--gold-dark); font-weight:700; text-transform:uppercase; letter-spacing:1px;">
                    <i class="bi bi-calendar3"></i> {{ $ann->created_at->format('M d, Y') }}
                </span>
                <span class="badge badge-gold">{{ ucfirst($ann->type ?? 'Announcement') }}</span>
            </div>
            <h3 style="font-size:1.3rem; margin-bottom:0.75rem; color:var(--text-dark); font-family:'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">
                {{ $ann->title }}
            </h3>
            <div style="line-height:1.7; color:var(--text-light); font-size:1rem; font-family:'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif; margin-bottom:1.25rem;">
                {{ str($ann->content)->limit(180) }}
            </div>
            <a href="{{ route('teacher.announcements.show', $ann->id) }}"
               style="display:inline-flex; align-items:center; gap:0.4rem; background:var(--primary); color:#fff; padding:0.55rem 1.25rem; border-radius:8px; font-size:0.88rem; font-weight:600; text-decoration:none; transition:all 0.3s;"
               onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                <i class="bi bi-eye-fill"></i> Read Full Announcement
            </a>
        </div>
    </div>
    @empty
    <div class="db-card">
        <div class="db-card-body" style="text-align:center; padding:5rem;">
            <i class="bi bi-megaphone" style="font-size:4rem; color:var(--gold); opacity:0.3; display:block; margin-bottom:1.5rem;"></i>
            <h2 style="color:var(--text-dark);">No Announcements</h2>
            <p style="color:var(--text-light);">There are no active announcements for teachers at this time.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection

