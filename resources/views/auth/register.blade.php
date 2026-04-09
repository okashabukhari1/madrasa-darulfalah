@extends('layouts.public')
@section('title', 'Register — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero" style="padding: 140px 2rem 80px; min-height: 100vh; display:flex; align-items:center; justify-content:center;">
  <div class="hero-pattern"></div>
  <div class="section-inner" style="position:relative; z-index:2; width: 100%; max-width: 500px;">
    
    <div style="background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); overflow: hidden;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--gold-dark), var(--gold)); padding: 2rem; text-align: center; color: var(--white);">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; color: var(--white); box-shadow: 0 4px 15px rgba(26,107,60,0.4);">
          <i class="bi bi-person-plus"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">Create Account</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.9);">Join the Madrasa Dar-ul-Falah digital portal</p>
      </div>

      <!-- Form -->
      <div style="padding: 2.5rem 2rem;">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div style="margin-bottom: 1.2rem;">
                <label for="name" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Full Name</label>
                <div style="position: relative;">
                    <i class="bi bi-person" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('name')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Email Address -->
            <div style="margin-bottom: 1.2rem;">
                <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Email Address</label>
                <div style="position: relative;">
                    <i class="bi bi-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('email')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1.2rem;">
                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-shield-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password" type="password" name="password" required autocomplete="new-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                    <button type="button" class="password-toggle" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-light); cursor: pointer; padding: 0;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Confirm Password -->
            <div style="margin-bottom: 2rem;">
                <label for="password_confirmation" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Confirm Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-shield-check" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                    <button type="button" class="password-toggle" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-light); cursor: pointer; padding: 0;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Submit -->
            <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(26,107,60,0.3);">
                Create Account <i class="bi bi-arrow-right" style="margin-left:5px"></i>
            </button>
            
            <div style="text-align:center;margin-top:20px;">
                <a href="{{ route('login') }}" style="color: var(--primary); font-size: 0.85rem; font-weight: 600;">Already have an account? Log in here.</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
