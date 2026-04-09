@extends('layouts.public')
@section('title', 'Login to Portal — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero" style="padding: 140px 2rem 80px; min-height: 100vh; display:flex; align-items:center; justify-content:center;">
  <div class="hero-pattern"></div>
  <div class="section-inner" style="position:relative; z-index:2; width: 100%; max-width: 450px;">
    
    <div style="background: var(--white); border-radius: var(--border-radius); box-shadow: var(--shadow-lg); overflow: hidden;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 2rem; text-align: center; color: var(--white);">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 1rem; color: var(--white); box-shadow: 0 4px 15px rgba(201,168,76,0.4);">
          <i class="bi bi-person-lock"></i>
        </div>
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">Welcome Back</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">Enter your credentials to access your portal</p>
      </div>

      <!-- Form -->
      <div style="padding: 2.5rem 2rem;">
        <!-- Session Status -->
        @if (session('status'))
            <div style="background: rgba(26,107,60,0.1); color: var(--primary); padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.5rem; font-weight: 600; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email Address -->
            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Email Address</label>
                <div style="position: relative;">
                    <i class="bi bi-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('email')
                    <div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-shield-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                    <button type="button" class="password-toggle" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-light); cursor: pointer; padding: 0; outline: none;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
                <!-- Remember Me -->
                <label for="remember_me" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-medium); cursor: pointer;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: auto;">
                    <span>Remember me</span>
                </label>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.8rem; color: var(--primary); font-weight: 600; text-decoration: none;">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(201,168,76,0.3);">
                Sign In <i class="bi bi-arrow-right" style="margin-left:5px"></i>
            </button>
            <div style="text-align:center;margin-top:20px;">
                <a href="{{ route('register') }}" style="color: var(--primary); font-size: 0.85rem; font-weight: 600;">Doesn't have an account? Register here.</a>
            </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
