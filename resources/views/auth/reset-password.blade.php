@extends('layouts.public')
@section('title', 'Reset Password — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero" style="padding: 140px 2rem 80px; min-height: 100vh; display:flex; align-items:center; justify-content:center;">
  <div class="hero-pattern"></div>
  <div class="section-inner" style="position:relative; z-index:2; width: 100%; max-width: 450px;">
    
    <div style="background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); overflow: hidden;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 2rem; text-align: center; color: var(--white);">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; color: var(--white); box-shadow: 0 4px 15px rgba(201,168,76,0.4);">
          <i class="bi bi-shield-lock"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">Create New Password</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">Enter your new password below</p>
      </div>

      <!-- Form -->
      <div style="padding: 2.5rem 2rem;">
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Email Address</label>
                <div style="position: relative;">
                    <i class="bi bi-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('email')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">New Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('password')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 2rem;">
                <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Confirm New Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-shield-check" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('password_confirmation')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Submit -->
            <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(201,168,76,0.3);">
                Reset Password <i class="bi bi-check-circle" style="margin-left:5px"></i>
            </button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
