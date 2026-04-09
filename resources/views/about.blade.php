@extends('layouts.public')
@section('title', 'About — Madrasa Dar-ul-Falah')

@section('content')
<!-- Page Hero -->
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-bank"></i> Our Story</div>
    <h1>About Madrasa Dar-ul-Falah</h1>
    <p>Discover our history, mission, values, and the people who make Dar-ul-Falah a place of genuine Islamic learning.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>About</span></div>
  </div>
</section>

<!-- History -->
<section class="section pattern-bg">
  <div class="section-inner intro-grid">
    <div class="intro-text reveal-left">
      <span class="section-label">Our History</span>
      <h2>28 Years of <span>Sacred Education</span></h2>
      <div class="divider"></div>
      <p>Madrasa Dar-ul-Falah was founded in 1995 by Sheikh Abdul Fattah, a renowned Islamic scholar who envisioned an institution that would produce authentic Islamic scholars capable of serving the Muslim Ummah in the modern world.</p>
      <p>What began as a small Quran school with 12 students in a modest mosque in Model Town, Lahore, has grown into a full-fledged Islamic university offering programs from basic Quran reading to advanced Islamic sciences.</p>
      <p>Over the past 28 years, we have graduated over 1,200 scholars, Huffaz, and Islamic educators who are serving in mosques, schools, and communities across Pakistan and around the world.</p>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:2rem">
        <div style="text-align:center;background:var(--primary);color:var(--white);padding:1.5rem;border-radius:12px">
          <div style="font-size:2rem;font-family:var(--font-heading);font-weight:800;color:var(--gold-light)" data-count="1200" data-suffix="+">0+</div>
          <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;margin-top:.3rem;opacity:.8">Graduates</div>
        </div>
        <div style="text-align:center;background:var(--gold);color:var(--white);padding:1.5rem;border-radius:12px">
          <div style="font-size:2rem;font-family:var(--font-heading);font-weight:800" data-count="42">0</div>
          <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;margin-top:.3rem;opacity:.8">Teachers</div>
        </div>
        <div style="text-align:center;background:var(--primary-dark);color:var(--white);padding:1.5rem;border-radius:12px">
          <div style="font-size:2rem;font-family:var(--font-heading);font-weight:800;color:var(--gold-light)" data-count="15">0</div>
          <div style="font-size:.75rem;text-transform:uppercase;letter-spacing:1px;margin-top:.3rem;opacity:.8">Courses</div>
        </div>
      </div>
    </div>
    <div class="intro-img-wrap reveal-right">
      <div class="intro-img-main" style="min-height:380px">
        <span class="placeholder-art"><i class="bi bi-bank"></i></span>
      </div>
    </div>
  </div>
</section>

<!-- Mission & Vision -->
<section class="section" style="background:var(--beige)">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Our Purpose</span>
      <h2 class="section-title">Mission & <span>Vision</span></h2>
      <div class="divider"></div>
    </div>
    <div class="mv-grid reveal">
      <div class="mv-card mission">
        <div class="mv-icon"><i class="bi bi-bullseye"></i></div>
        <h3>Our Mission</h3>
        <p>To provide authentic, accessible, and comprehensive Islamic education that equips students with Quranic knowledge, prophetic wisdom, and strong moral character — preparing them to be positive contributors to society while remaining deeply rooted in their faith.</p>
        <p style="margin-top:1rem">We are committed to producing scholars who carry the light of Islam into every sphere of life, maintaining the highest standards of academic and spiritual excellence.</p>
      </div>
      <div class="mv-card vision">
        <div class="mv-icon"><i class="bi bi-star"></i></div>
        <h3>Our Vision</h3>
        <p>To become the leading center of Islamic learning in South Asia — an institution recognized globally for the quality of its graduates, the depth of its curriculum, and its contribution to the preservation and propagation of Islamic sciences.</p>
        <p style="margin-top:1rem">We envision a world where every Muslim has access to quality Islamic education, and Dar-ul-Falah will be at the forefront of making that vision a reality.</p>
      </div>
    </div>
  </div>
</section>

<!-- Values -->
<section class="section">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">What We Stand For</span>
      <h2 class="section-title">Our Core <span>Values</span></h2>
      <div class="divider"></div>
    </div>
    <div class="values-grid">
      <div class="value-card reveal stagger-1">
        <div class="value-icon"><i class="bi bi-book-half"></i></div>
        <h4>Quran First</h4>
        <p>The Holy Quran is the foundation of all our learning and the center of our curriculum.</p>
      </div>
      <div class="value-card reveal stagger-2">
        <div class="value-icon"><i class="bi bi-heart"></i></div>
        <h4>Sincerity (Ikhlas)</h4>
        <p>We seek knowledge purely for the pleasure of Allah and the benefit of the Ummah.</p>
      </div>
      <div class="value-card reveal stagger-3">
        <div class="value-icon"><i class="bi bi-scales"></i></div>
        <h4>Excellence (Ihsan)</h4>
        <p>We strive for the highest standards in everything we do — worship, learning, and service.</p>
      </div>
      <div class="value-card reveal stagger-4">
        <div class="value-icon"><i class="bi bi-people"></i></div>
        <h4>Brotherhood (Ukhuwwah)</h4>
        <p>A supportive community where every student is valued, respected, and cared for.</p>
      </div>
      <div class="value-card reveal stagger-5">
        <div class="value-icon"><i class="bi bi-globe-americas"></i></div>
        <h4>Service (Khidmah)</h4>
        <p>Education is not an end in itself — we train scholars to serve their communities.</p>
      </div>
      <div class="value-card reveal stagger-1">
        <div class="value-icon"><i class="bi bi-lightbulb"></i></div>
        <h4>Innovation</h4>
        <p>Combining traditional scholarship with modern methods for effective learning.</p>
      </div>
    </div>
  </div>
</section>

<!-- Principal Message -->
<section class="section principal-section">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Leadership</span>
      <h2 class="section-title">Message from the <span>Principal</span></h2>
      <div class="divider"></div>
    </div>
    <div class="principal-grid">
      <div class="principal-portrait reveal-left">
        <div class="principal-img"><i class="bi bi-person-workspace"></i></div>
        <div class="principal-name">Mufti Abdul Fattah Qureshi</div>
        <div class="principal-title">Principal & Founder</div>
        <div style="margin-top:1rem;display:flex;gap:.5rem;flex-wrap:wrap;justify-content:center">
          <span style="background:rgba(26,107,60,.1);color:var(--primary);padding:.3rem .8rem;border-radius:12px;font-size:.75rem;font-weight:600">PhD Islamic Sciences</span>
          <span style="background:rgba(26,107,60,.1);color:var(--primary);padding:.3rem .8rem;border-radius:12px;font-size:.75rem;font-weight:600">30+ Years</span>
        </div>
      </div>
      <div class="principal-message reveal-right">
        <blockquote>طَلَبُ الْعِلْمِ فَرِيضَةٌ عَلَى كُلِّ مُسْلِمٍ</blockquote>
        <p>"Seeking knowledge is an obligation upon every Muslim." — This hadith has been the guiding star of Dar-ul-Falah since the day we opened our doors in 1995.</p>
        <p>When I founded this institution 28 years ago, I had one dream: to create a place where every Muslim child — regardless of their background or means — could access the knowledge of the Quran and Sunnah in a nurturing, loving, and intellectually rigorous environment.</p>
        <p>Alhamdulillah, today that dream has become a reality. Our graduates are serving Islam across the globe — as Imams, teachers, scholars, and community leaders. Every time I hear of a student benefiting from their time at Dar-ul-Falah, I am reminded of the immense blessing of this work.</p>
        <p>To our students, I say: the knowledge you gain here is an Amanah — a trust. Carry it with humility, share it with generosity, and always remember that the purpose of all knowledge is to draw closer to Allah.</p>
        <p>May Allah bless this institution, its students, its teachers, and all those who support the cause of Islamic education. Ameen.</p>
        <div class="signature">— Mufti Abdul Fattah Qureshi</div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-inner reveal">
    <h2 class="cta-title">Become Part of Our Family</h2>
    <p class="cta-text">Join thousands of students who have found purpose, knowledge, and community at Dar-ul-Falah.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
      <a href="{{ route('admission') }}" class="btn-primary">Apply Now</a>
      <a href="{{ route('contact') }}" class="btn-secondary">Get in Touch</a>
    </div>
  </div>
</section>
@endsection
