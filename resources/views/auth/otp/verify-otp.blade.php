@extends('layouts.public')
@section('title', 'Verify OTP — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero" style="padding: 140px 2rem 80px; min-height: 100vh; display:flex; align-items:center; justify-content:center;">
  <div class="hero-pattern"></div>
  <div class="section-inner" style="position:relative; z-index:2; width: 100%; max-width: 450px;">
    
    <div style="background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); overflow: hidden;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 2rem; text-align: center; color: var(--white);">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; color: var(--white); box-shadow: 0 4px 15px rgba(201,168,76,0.4);">
          <i class="bi bi-123"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">OTP Verification</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">Enter the 6-digit code sent to your email.</p>
      </div>

      <!-- Form -->
      <div style="padding: 2.5rem 2rem;">
        <!-- Session Status -->
        @if (session('status'))
            <div style="background: rgba(26,107,60,0.1); color: var(--primary); padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; font-weight: 600; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        <div style="text-align: center; font-size: 0.9rem; color: var(--text-medium); margin-bottom: 1.5rem;">
            Please enter the 6-digit OTP sent to <strong>{{ $email }}</strong>
        </div>

        <form method="POST" action="{{ route('password.otp.verify.submit') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- OTP Input -->
            <div style="margin-bottom: 2rem;">
                <input id="otp" type="text" name="otp" required autofocus maxlength="6" pattern="\d{6}" placeholder="------" style="width: 100%; padding: 1rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: monospace; font-size: 2rem; text-align: center; letter-spacing: 0.5em; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                @error('otp')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem; text-align: center;">{{ $message }}</div>@enderror
            </div>

            <!-- Submit -->
            <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(201,168,76,0.3); margin-bottom: 1.5rem;">
                Verify OTP <i class="bi bi-shield-check" style="margin-left:5px"></i>
            </button>
            <div style="text-align:center;">
                <a href="{{ route('password.otp.request') }}" style="color: var(--primary); font-size: 0.85rem; font-weight: 600;">Did not receive email? Resend.</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
