@extends('layouts.public')
@section('title', 'My Profile — Madrasa Dar-ul-Falah')

@section('content')
<!-- Page Hero -->
<section class="page-hero">
    <div class="page-hero-inner">
        <div class="page-hero-badge">Member Since {{ $user->created_at->format('M Y') }}</div>
        <h1 style="font-family: var(--font-heading);">Welcome, {{ explode(' ', $user->name)[0] }}</h1>
        @if($user->student && $user->student->urdu_name)
            <div class="urdu-text" style="font-size: 2.2rem; color: var(--gold-light); margin-bottom: 1rem;">{{ $user->student->urdu_name }}</div>
        @endif
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <i class="bi bi-chevron-right" style="font-size: 0.7rem;"></i>
            <span>My Profile</span>
        </div>
    </div>
</section>

<section class="profile-section" style="padding: 60px 0; background: var(--gray-50);">
    <div class="container" style="max-width: 1100px; margin: 0 auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px;">
            
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
                    <div style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid var(--gold); margin: 0 auto 20px; overflow: hidden; background: #eee;">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <h3 style="margin-bottom: 5px; color: var(--primary-dark); font-family: var(--font-heading);">{{ $user->name }}</h3>
                    @if($user->student && $user->student->urdu_name)
                        <div class="urdu-text" style="font-size: 1.2rem; color: var(--gold); margin-bottom: 10px;">{{ $user->student->urdu_name }}</div>
                    @endif
                    <p style="color: var(--text-light); margin-bottom: 20px; font-size: 0.9rem;">Administrator / Member</p>
                    
                    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
                    
                    <ul style="list-style: none; padding: 0; text-align: left;">
                        <li style="padding: 10px 0; display: flex; align-items: center; gap: 10px; color: var(--primary); font-weight: 600;">
                            <i class="bi bi-person-circle"></i> Personal Info
                        </li>
                        @if($admissions->count() > 0)
                        <li style="padding: 10px 0; display: flex; align-items: center; gap: 10px; color: var(--text-light);">
                            <i class="bi bi-journal-check"></i> Admission Status
                        </li>
                        @endif
                        <li style="padding: 10px 0; display: flex; align-items: center; gap: 10px; color: var(--text-light);">
                            <i class="bi bi-shield-lock"></i> Security
                        </li>
                        <li style="padding: 15px 0 0; margin-top: 10px; border-top: 1px solid #eee;">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();" style="display: flex; align-items: center; gap: 10px; color: var(--red); font-weight: 600;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content -->
            <div class="profile-content">
                @if(session('status') === 'profile-updated')
                    <div style="padding: 1rem; background: #ecfdf5; color: #059669; border-radius: 12px; margin-bottom: 25px; border: 1px solid #10b981;">
                        <i class="bi bi-check-circle-fill"></i> Your profile information has been updated successfully.
                    </div>
                @endif

                <!-- Admission History Section -->
                @if($admissions->count() > 0)
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 1.8rem; color: var(--primary-dark); margin-bottom: 25px;">Admission Applications</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        @foreach($admissions as $admission)
                            <div style="border: 1px solid #eee; padding: 20px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary-light)';this.style.background='#fcfdfc'" onmouseout="this.style.borderColor='#eee';this.style.background='white'">
                                <div>
                                    <div style="font-weight: 700; color: var(--text-dark); font-size: 1.1rem; margin-bottom: 5px;">{{ $admission->course->title ?? 'General Admission' }}</div>
                                    <div style="font-size: 0.85rem; color: var(--text-light);">Applied on {{ $admission->created_at->format('M d, Y') }}</div>
                                </div>
                                <div style="text-align: right;">
                                    @php
                                        $statusColors = [
                                            'pending'  => ['bg' => 'rgba(255,193,7,0.1)', 'color' => '#856404', 'label' => 'Pending'],
                                            'approved' => ['bg' => 'rgba(40,167,69,0.1)', 'color' => '#155724', 'label' => 'Approved'],
                                            'rejected' => ['bg' => 'rgba(220,53,69,0.1)', 'color' => '#721c24', 'label' => 'Rejected'],
                                        ];
                                        $s = $statusColors[$admission->status] ?? $statusColors['pending'];
                                    @endphp
                                    <span style="display: inline-block; padding: 6px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; background: {{ $s['bg'] }}; color: {{ $s['color'] }}; text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ $s['label'] }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Personal Information -->
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); margin-bottom: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 1.8rem; color: var(--primary-dark); margin-bottom: 25px;">Account Information</h2>
                    
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
                            @error('name')<span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
                            @error('email')<span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
                            @error('phone')<span style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>@enderror
                        </div>

                        <div style="text-align: right; margin-top: 30px;">
                            <button type="submit" class="btn btn-gold" style="padding: 12px 30px; border-radius: 10px; font-weight: 700;">Update Profile</button>
                        </div>
                    </form>
                </div>

                <!-- Password Update -->
                <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h2 style="font-family: var(--font-heading); font-size: 1.8rem; color: var(--primary-dark); margin-bottom: 25px;">Change Password</h2>
                    
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Current Password</label>
                            <input type="password" name="current_password" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">New Password</label>
                            <input type="password" name="password" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #444;">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px 15px; border: 1px solid #ddd; border-radius: 10px;">
                        </div>

                        <div style="text-align: right; margin-top: 30px;">
                            <button type="submit" class="btn btn-gold" style="padding: 12px 30px; border-radius: 10px; font-weight: 700;">Reset Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection


