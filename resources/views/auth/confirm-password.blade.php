@extends('layouts.public')
@section('title', 'Confirm Password — Madrasa Dar-ul-Falah')

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
        <h2 style="font-size: 1.5rem; margin-bottom: 0.5rem; color: var(--white);">Confirm Password</h2>
        <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7);">Secure area. Please authenticate.</p>
      </div>

      <!-- Form -->
      <div style="padding: 2.5rem 2rem;">
        <div style="font-size: 0.9rem; color: var(--text-medium); margin-bottom: 1.5rem; text-align: center;">
            This is a secure area of the application. Please confirm your password before continuing.
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div style="margin-bottom: 2rem;">
                <label for="password" style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--text-dark); margin-bottom: 0.5rem;">Password</label>
                <div class="password-input-wrapper" style="position: relative;">
                    <i class="bi bi-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-light);"></i>
                    <input id="password" type="password" name="password" required autocomplete="current-password" style="width: 100%; padding: 0.85rem 3.5rem 0.85rem 2.8rem; border: 2px solid var(--beige-dark); border-radius: 10px; font-family: var(--font-body); font-size: 0.9rem; background: var(--beige); transition: var(--transition); color: var(--text-dark);">
                </div>
                @error('password')<div style="color: #e53e3e; font-size: 0.78rem; margin-top: 0.35rem;">{{ $message }}</div>@enderror
            </div>

            <!-- Submit -->
            <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); border: none; border-radius: 10px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: var(--transition); letter-spacing: 0.5px; box-shadow: 0 8px 20px rgba(201,168,76,0.3);">
                Confirm <i class="bi bi-shield-check" style="margin-left:5px"></i>
            </button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
