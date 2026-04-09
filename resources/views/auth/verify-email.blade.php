@extends('layouts.public')
@section('title', 'Verify Email — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero" style="padding: 140px 2rem 80px; min-height: 100vh; display:flex; align-items:center; justify-content:center;">
  <div class="hero-pattern"></div>
  <div class="section-inner" style="position:relative; z-index:2; width: 100%; max-width: 450px;">
    
    <div style="background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); overflow: hidden;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 2rem; text-align: center; color: var(--white);">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; color: var(--white); box-shadow: 0 4px 15px rgba(201,168,76,0.4);">
          <i class="bi bi-envelope-check"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">Verify Your Email</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">We need to confirm your email before you proceed.</p>
      </div>

      <!-- Content -->
      <div style="padding: 2.5rem 2rem;">
        <div style="font-size: 0.95rem; color: var(--text-medium); line-height: 1.7; margin-bottom: 1.5rem; text-align: center;">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div style="background: rgba(26,107,60,0.1); color: var(--primary); padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; font-weight: 600; text-align:center;">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(201,168,76,0.3);">
                    Resend Verification Email <i class="bi bi-send" style="margin-left:5px"></i>
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" style="text-align: center;">
                @csrf
                <button type="submit" style="background: none; border: none; color: var(--text-light); font-size: 0.9rem; font-weight: 600; cursor: pointer; text-decoration: underline;">
                    Log Out
                </button>
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
