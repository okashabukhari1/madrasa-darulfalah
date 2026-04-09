@extends('student.layouts.app')
@section('title', 'My Dashboard')
@section('page_title', 'Student Dashboard')

@section('content')
<!-- Welcome banner -->
<div class="welcome-banner" id="welcomeBanner">
    <div>
        <h2 id="welcomeMsg">As-salamu Alaykum, {{ explode(' ', \Illuminate\Support\Facades\Auth::user()->name)[0] }}!</h2>
        <p id="welcomeSub">
            @if($student)
                Program: <strong style="color:var(--gold);">{{ ucfirst($student->program) }}</strong>
                @if($student->teacher)
                    | Teacher: {{ $student->teacher->name }}
                @endif
            @else
                Welcome to your student portal
            @endif
        </p>
    </div>
    <div class="wb-actions">
        <!-- Add actions if needed -->
    </div>
</div>

<!-- Stats -->
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card {{ ($todayAttendance && $todayAttendance->status == 'present') ? 'green' : (($todayAttendance && $todayAttendance->status == 'absent') ? 'blue' : 'gold') }}">
        <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
        <div class="stat-info">
            <h3>{{ $todayAttendance ? ucfirst($todayAttendance->status) : 'Pending' }}</h3>
            <p>Today's Attendance</p>
        </div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon"><i class="bi bi-person-video3"></i></div>
        <div class="stat-info">
            <h3>{{ $student->teacher->name ?? 'Unassigned' }}</h3>
            <p>Assigned Teacher</p>
        </div>
    </div>
    <div class="stat-card gold">
        <div class="stat-icon"><i class="bi bi-megaphone"></i></div>
        <div class="stat-info"><h3 data-count="{{ $stats['announcements'] ?? 0 }}">0</h3><p>Announcements</p></div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
        <div class="stat-info"><h3 data-count="{{ $stats['study_materials'] ?? 0 }}">0</h3><p>Study Materials</p></div>
    </div>
</div>

<div class="grid-2" style="align-items: start;">
    <!-- LEFT COLUMN -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Learning Progress / Hifz Tracker -->
        <div class="db-card">
            <div class="db-card-header">
                <h2><i class="bi bi-journal-check"></i> My Learning Progress</h2>
            </div>
            <div class="db-card-body">
                @if($student && $student->program === 'hifz')
                    <div class="course-card-db" style="border:none;box-shadow:none;padding:0;">
                        <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
                            <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--primary-dark),var(--primary-light));border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:26px;"><i class="bi bi-book-half" style="color:var(--white)"></i></div>
                            <div>
                                <div style="font-family:'Playfair Display',serif;font-size:16px;color:var(--gray-800);">Hifz-ul-Quran Tracker</div>
                                <div style="font-size:12px;color:var(--gray-500);">Keep pushing forward, Insha'Allah.</div>
                            </div>
                        </div>
                        
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px;">
                            <div style="background:var(--gray-50);border-radius:8px;padding:10px;text-align:center;">
                                <div style="font-size:20px;font-weight:700;color:var(--primary);">Para {{ $hifzData['max_para'] ?? 0 }}</div>
                                <div style="font-size:11px;color:var(--gray-500);">Reached Currently</div>
                            </div>
                            <div style="background:var(--gray-50);border-radius:8px;padding:10px;text-align:center;">
                                <div style="font-size:20px;font-weight:700;color:var(--gold);">30 Para</div>
                                <div style="font-size:11px;color:var(--gray-500);">Goal</div>
                            </div>
                        </div>
                        
                        <div class="course-progress">
                            <div class="progress-label"><span>Overall Hifz Completion</span><span>{{ $hifzData['percentage'] ?? 0 }}%</span></div>
                            <div class="progress-track"><div class="progress-fill" style="width:{{ $hifzData['percentage'] ?? 0 }}%"></div></div>
                        </div>
                    </div>
                @elseif($student && ($student->program === 'nazra' || $student->program === 'qaida'))
                    <div style="padding: 2rem; text-align: center;">
                        <i class="bi bi-book" style="font-size: 3rem; color: var(--gold); margin-bottom: 1rem; display: block;"></i>
                        <h3 style="color: var(--primary);">{{ ucfirst($student->program) }} Program</h3>
                        <p style="color: var(--gray-500);">May Allah bless your learning journey.</p>
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; color: var(--text-light);">
                        You are not assigned to any program yet.
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Attendance Logs -->
        <div class="db-card">
            <div class="db-card-header"><h2><i class="bi bi-calendar3"></i> Attendance History</h2></div>
            <div class="item-list" style="padding: 12px;">
                @forelse($recentAttendances as $att)
                    <div class="material-item" style="display:flex;align-items:center;gap:12px;padding:12px;background:var(--white);border:1px solid var(--beige-dark);border-radius:10px;margin-bottom:10px;">
                        <div style="width:40px;height:40px;border-radius:8px; display:flex;align-items:center;justify-content:center;font-size:18px; flex-shrink:0; background: {{ $att->status === 'present' ? '#d1e7dd' : ($att->status === 'absent' ? '#f8d7da' : '#fff3cd') }}; color: {{ $att->status === 'present' ? '#0f5132' : ($att->status === 'absent' ? '#842029' : '#664d03') }};">
                            <i class="bi bi-{{ $att->status === 'present' ? 'check-circle' : ($att->status === 'absent' ? 'x-circle' : 'exclamation-circle') }}"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:600;font-size:14px;color:var(--gray-800);">{{ $att->date->format('l, M d, Y') }}</div>
                            <div style="font-size:12px;color:var(--gray-500);">Marked by Teacher</div>
                        </div>
                        <div>
                            <span class="badge badge-{{ $att->status === 'present' ? 'green' : ($att->status === 'absent' ? 'red' : 'gold') }}" style="text-transform: uppercase;">{{ $att->status }}</span>
                        </div>
                    </div>
                @empty
                    <div style="padding: 1rem; text-align: center; color: var(--text-light);">No attendance marked yet.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="db-card">
            <div class="db-card-header"><h2><i class="bi bi-megaphone"></i> Announcements</h2></div>
            <div class="item-list" id="annList">
                @if(isset($recentAnnouncements) && count($recentAnnouncements) > 0)
                    @foreach($recentAnnouncements as $ann)
                    <div class="list-item">
                        <div class="list-item-icon" style="background:var(--blue-light,var(--gray-100))"><i class="bi bi-bell"></i></div>
                        <div class="list-item-content">
                            <div class="list-item-title">{{ $ann->title }}</div>
                            <div class="list-item-meta">{{ $ann->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="padding: 1rem; text-align: center; color: var(--text-light);">No recent announcements</div>
                @endif
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN -->
    <div style="display: flex; flex-direction: column; gap: 24px;">

        <!-- Recent Daily Logs -->
        <div class="db-card">
            <div class="db-card-header"><h2><i class="bi bi-card-checklist"></i> Recent Daily Logs</h2></div>
            <div class="item-list" style="padding: 12px;">
                @forelse($recentProgress as $log)
                    <div class="material-item" style="display:flex;align-items:flex-start;gap:12px;padding:14px;background:var(--white);border:1px solid var(--beige-dark);border-radius:10px;margin-bottom:12px;">
                        <div style="width:40px;height:40px;border-radius:8px;background:var(--beige);display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--gold-dark);flex-shrink:0;">
                            @if($log->lesson_type == 'sabaq')
                                <i class="bi bi-book-half"></i>
                            @elseif($log->lesson_type == 'sabqi')
                                <i class="bi bi-arrow-repeat"></i>
                            @else
                                <i class="bi bi-journal-text"></i>
                            @endif
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:4px;">
                                <div style="font-weight:600;font-size:14px;color:var(--primary-dark);">{{ $log->date->format('l, M d') }} &mdash; <span style="color:var(--gold-dark);">{{ ucfirst($log->lesson_type ?? 'Lesson') }}</span></div>
                            </div>
                            <div style="font-size:13px;color:var(--gray-800);margin-bottom:4px;">
                                @if($log->para) <strong>Para:</strong> {{ $log->para }} @endif
                                @if($log->surah) | <strong>Surah:</strong> {{ $log->surah }} @endif
                                @if($log->ayah_from) | <strong>Ayah:</strong> {{ $log->ayah_from }} - {{ $log->ayah_to }} @endif
                            </div>
                            @if($log->remarks)
                                <div style="font-size:12px;color:var(--gray-500);font-style:italic;">"{{ $log->remarks }}"</div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="padding: 1rem; text-align: center; color: var(--text-light);">No recent daily logs available.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Materials -->
        <div class="db-card">
            <div class="db-card-header"><h2><i class="bi bi-file-earmark-text"></i> Recent Materials</h2></div>
            <div id="matList" style="padding:12px;">
                @if(isset($recentMaterials) && count($recentMaterials) > 0)
                    @foreach($recentMaterials as $mat)
                    <div class="material-item" style="display:flex;align-items:center;gap:12px;padding:12px;background:var(--white);border:1px solid var(--gray-200);border-radius:12px;margin-bottom:10px;">
                        <div class="mat-icon" style="width:40px;height:40px;border-radius:8px;background:var(--beige);display:flex;align-items:center;justify-content:center;font-size:20px;"><i class="bi bi-file-pdf"></i></div>
                        <div class="mat-info" style="flex:1;">
                            <div class="mat-title" style="font-weight:600;font-size:14px;color:var(--gray-800);margin-bottom:4px;">{{ $mat->title }}</div>
                            <div class="mat-meta" style="font-size:12px;color:var(--gray-500);">PDF</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div style="padding: 1rem; text-align: center; color: var(--text-light);">No materials available</div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
