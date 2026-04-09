@extends('teacher.layouts.app')
@section('title', $announcement->title)
@section('page_title', 'Announcement Details')

@section('content')
<div style="max-width:860px;">
    {{-- Back button --}}
    <a href="{{ route('teacher.announcements') }}"
       style="display:inline-flex; align-items:center; gap:0.5rem; color:var(--primary); font-weight:600; font-size:0.9rem; text-decoration:none; margin-bottom:2rem;">
        <i class="bi bi-arrow-left-circle-fill"></i> Back to Announcements
    </a>

    <div class="db-card" style="border-left:4px solid var(--gold);">
        <div class="db-card-body" style="padding:2.5rem;">

            {{-- Header row --}}
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem; margin-bottom:1.5rem;">
                <span style="font-size:0.8rem; color:var(--gold-dark); font-weight:700; text-transform:uppercase; letter-spacing:1px;">
                    <i class="bi bi-calendar3"></i> {{ $announcement->created_at->format('l, d F Y') }}
                </span>
                <span class="badge badge-gold">{{ ucfirst($announcement->type ?? 'Announcement') }}</span>
            </div>

            {{-- Title --}}
            @php $isUrdu = preg_match('/[\x{0600}-\x{06FF}]/u', $announcement->title ?? ''); @endphp
            <h2 style="font-size:1.7rem; margin-bottom:1.5rem; color:var(--text-dark);
                       font-family:'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
                       {{ $isUrdu ? 'text-align:right; direction:rtl;' : '' }}">
                {{ $announcement->title }}
            </h2>

            <hr style="border:none; border-top:2px solid var(--beige-dark); margin-bottom:1.5rem;">

            {{-- Content --}}
            @php $contentUrdu = preg_match('/[\x{0600}-\x{06FF}]/u', $announcement->content ?? ''); @endphp
            <div style="font-size:1.1rem; line-height:2.1; color:var(--text-medium);
                        font-family:'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;
                        {{ $contentUrdu ? 'text-align:right; direction:rtl;' : '' }}">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            <hr style="border:none; border-top:1px solid var(--beige-dark); margin:2rem 0;">

            {{-- Official Footer strip --}}
            <div style="display:flex; align-items:center; gap:1rem; padding:1rem 1.25rem; border-radius:10px; background:rgba(26,107,60,0.06); border-left:3px solid var(--primary);">
                <div style="width:40px; height:40px; min-width:40px; background:var(--primary); border-radius:9px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem;">
                    <i class="bi bi-shield-fill-check"></i>
                </div>
                <div>
                    <div style="font-weight:700; color:var(--primary); font-size:0.88rem;">Official Madrasa Dar-ul-Falah Notice</div>
                    <div style="font-size:0.78rem; color:var(--text-light);">Issued to: {{ ucfirst($announcement->type) }}s · {{ $announcement->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


