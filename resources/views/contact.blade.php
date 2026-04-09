@extends('layouts.public')
@section('title', 'Contact — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-mailbox"></i> Get in Touch</div>
    <h1>Contact Us</h1>
    <p>We're here to help. Reach out with any questions about admissions, courses, or general inquiries.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Contact</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="contact-grid">

      <!-- Contact Info -->
      <div class="contact-info">
        <div class="contact-block reveal-left">
          <h3><i class="bi bi-geo-alt"></i> Visit Us</h3>
          <div class="contact-detail">
            <div class="contact-ico"><i class="bi bi-geo-alt"></i></div>
            <div class="contact-detail-text">
              <div class="label">Address</div>
              <div class="value">Street Number 11, Haji Mureed Goth Firdous Colony, Karachi, 74600, Pakistan<br></div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-ico"><i class="bi bi-telephone"></i></div>
            <div class="contact-detail-text">
              <div class="label">Phone</div>
              <div class="value">+92 42 3571 0000<br>+92 300 123 4567</div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-ico"><i class="bi bi-envelope"></i></div>
            <div class="contact-detail-text">
              <div class="label">Email</div>
              <div class="value">info@darulfalah.edu.pk<br>admissions@darulfalah.edu.pk</div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-ico"><i class="bi bi-clock"></i></div>
            <div class="contact-detail-text">
              <div class="label">Office Hours</div>
              <div class="value">Monday – Saturday<br>7:00 AM – 6:00 PM (PKT)</div>
            </div>
          </div>
        </div>

        <div class="contact-block reveal-left">
          <h3><i class="bi bi-map"></i> Find Us on Map</h3>
          <div class="map-embed">
            <div class="map-placeholder">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.0538862004473!2d67.03420489999999!3d24.8961435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f3498b16f67%3A0x3025a396a6afdb95!2zSmFtYSBNYXNqaWQgQWwtSGFtZWVkINmF2LPYrNivINin2YTYrdmF24zYryDZiNmF2K_Ysdiz24Eg2K_Yp9ix2KfZhNmB2YTYp9it!5e0!3m2!1sen!2s!4v1773962768136!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
        </div>

        <div class="contact-block reveal-left">
          <h3><i class="bi bi-link-45deg"></i> Follow Us</h3>
          <div style="display:flex;gap:.75rem;flex-wrap:wrap">
            <a href="#" style="display:flex;align-items:center;gap:.5rem;background:var(--beige);padding:.75rem 1.2rem;border-radius:10px;font-size:.85rem;font-weight:600;color:var(--text-dark);transition:all .3s" onmouseover="this.style.background='var(--primary)';this.style.color='white'" onmouseout="this.style.background='var(--beige)';this.style.color='var(--text-dark)'">f Facebook</a>
            <a href="#" style="display:flex;align-items:center;gap:.5rem;background:var(--beige);padding:.75rem 1.2rem;border-radius:10px;font-size:.85rem;font-weight:600;color:var(--text-dark);transition:all .3s" onmouseover="this.style.background='var(--primary)';this.style.color='white'" onmouseout="this.style.background='var(--beige)';this.style.color='var(--text-dark)'"><i class="bi bi-play"></i> YouTube</a>
            <a href="#" style="display:flex;align-items:center;gap:.5rem;background:var(--beige);padding:.75rem 1.2rem;border-radius:10px;font-size:.85rem;font-weight:600;color:var(--text-dark);transition:all .3s" onmouseover="this.style.background='var(--primary)';this.style.color='white'" onmouseout="this.style.background='var(--beige)';this.style.color='var(--text-dark)'"><i class="bi bi-camera"></i> Instagram</a>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="admission-form-wrap reveal-right">
        <div class="form-header">
          <h2>Send Us a Message</h2>
          <p>Fill in the form below and we'll get back to you as soon as possible, InshAllah.</p>
        </div>
        @if(session('success'))
          <div class="success-msg" style="display:block;margin-bottom:1.5rem;background:rgba(45,106,79,0.1);color:var(--primary);padding:1rem;border-radius:10px;border:1px solid var(--primary-light)">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div class="error-msg" style="display:block;margin-bottom:1.5rem;background:rgba(220,53,69,0.1);color:#dc3545;padding:1rem;border-radius:10px;border:1px solid rgba(220,53,69,0.2)">
            <ul style="margin:0;padding-left:1.5rem">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" id="contact-form" novalidate>
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="c-name">Your Name *</label>
              <input type="text" id="c-name" name="name" placeholder="Your full name" required>
              <div class="error"></div>
            </div>
            <div class="form-group">
              <label for="c-email">Email Address *</label>
              <input type="email" id="c-email" name="email" placeholder="your@email.com" required>
              <div class="error"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="c-phone">Phone Number</label>
              <input type="tel" id="c-phone" name="phone" placeholder="+92 300 0000000">
            </div>
            <div class="form-group">
              <label for="c-subject">Subject *</label>
              <select id="c-subject" name="subject" required>
                <option value="">-- Select Subject --</option>
                <option value="admissions">Admissions Inquiry</option>
                <option value="courses">Course Information</option>
                <option value="fees">Fee Structure</option>
                <option value="boarding">Boarding Facilities</option>
                <option value="general">General Inquiry</option>
                <option value="other">Other</option>
              </select>
              <div class="error"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="c-message">Your Message *</label>
            <textarea id="c-message" name="message" placeholder="Write your message here..." style="min-height:160px" required></textarea>
            <div class="error"></div>
          </div>
          <button type="submit" class="form-submit">Send Message ➤</button>
          <div class="success-msg" id="contact-success"><i class="bi bi-check-circle-fill"></i> JazakAllah Khair! Your message has been received. We will respond within 24-48 hours, InshAllah.</div>
        </form>
      </div>

    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" style="background:var(--beige)">
  <div class="section-inner">
    <div class="section-header reveal">
      <span class="section-label">Common Questions</span>
      <h2 class="section-title">Frequently Asked <span>Questions</span></h2>
      <div class="divider"></div>
    </div>
    <div style="max-width:800px;margin:0 auto;display:flex;flex-direction:column;gap:1rem">
      <div class="reveal stagger-1" style="background:var(--white);border-radius:12px;padding:1.5rem;box-shadow:var(--shadow-sm)">
        <div style="font-weight:700;color:var(--primary);margin-bottom:.5rem">Q: What are the admission requirements?</div>
        <p style="font-size:.9rem;color:var(--text-medium)">Requirements vary by course. For Hifz, basic Quran reading ability is needed. For the Alim Course, a basic Islamic education background is preferred. For Arabic and Islamic Studies, there are no prerequisites.</p>
      </div>
      <div class="reveal stagger-2" style="background:var(--white);border-radius:12px;padding:1.5rem;box-shadow:var(--shadow-sm)">
        <div style="font-weight:700;color:var(--primary);margin-bottom:.5rem">Q: Are there scholarships available?</div>
        <p style="font-size:.9rem;color:var(--text-medium)">Yes, Dar-ul-Falah offers need-based scholarships for deserving students. Merit scholarships are also available for exceptional students. Please contact our admissions office for details.</p>
      </div>
      <div class="reveal stagger-3" style="background:var(--white);border-radius:12px;padding:1.5rem;box-shadow:var(--shadow-sm)">
        <div style="font-weight:700;color:var(--primary);margin-bottom:.5rem">Q: Is boarding available for female students?</div>
        <p style="font-size:.9rem;color:var(--text-medium)">Yes, we have separate, fully supervised boarding facilities for both male and female students. The ladies' section maintains complete purdah and is supervised by experienced female staff.</p>
      </div>
      <div class="reveal stagger-4" style="background:var(--white);border-radius:12px;padding:1.5rem;box-shadow:var(--shadow-sm)">
        <div style="font-weight:700;color:var(--primary);margin-bottom:.5rem">Q: What is the fee structure?</div>
        <p style="font-size:.9rem;color:var(--text-medium)">Fees vary by program. Day students pay a monthly tuition fee, while boarding students pay a combined fee that includes accommodation and meals. Please contact our office for the current fee schedule.</p>
      </div>
    </div>
  </div>
</section>
@endsection
