@extends('layouts.public')
@section('title', 'Admissions — Madrasa Dar-ul-Falah')

@section('content')
<section class="page-hero">
  <div class="page-hero-inner">
    <div class="page-hero-badge"><i class="bi bi-clipboard-data"></i> Join Our Family</div>
    <h1>Apply for Admission</h1>
    <p>New batch starting April 2025. Limited seats available. Begin your journey of Islamic knowledge today.</p>
    <div class="breadcrumb"><a href="{{ route('home') }}">Home</a><span>/</span><span>Admissions</span></div>
  </div>
</section>

<section class="section pattern-bg">
  <div class="section-inner">
    <div class="admission-grid">

      <!-- Info Sidebar -->
      <div class="admission-info">
        <div class="admission-highlight reveal-left">
          <h3><i class="bi bi-star"></i> Why Choose Dar-ul-Falah?</h3>
          <p>Join an institution with 28 years of excellence in Islamic education and over 1,200 graduates serving around the world.</p>
          <div class="req-list">
            <div class="req-item">Qualified and experienced Islamic scholars</div>
            <div class="req-item">Authentic Dars-e-Nizami curriculum</div>
            <div class="req-item">Individual attention for every student</div>
            <div class="req-item">Safe and nurturing Islamic environment</div>
            <div class="req-item">Modern facilities including library and labs</div>
            <div class="req-item">Boarding facilities for out-of-city students</div>
          </div>
        </div>

        <div style="background:var(--white);border-radius:var(--border-radius);padding:2rem;box-shadow:var(--shadow-sm);margin-bottom:1.5rem" class="reveal-left">
          <h3 style="font-size:1.1rem;color:var(--text-dark);margin-bottom:1.2rem;padding-bottom:.75rem;border-bottom:2px solid var(--beige-dark)"><i class="bi bi-calendar"></i> Important Dates</h3>
          <div style="display:flex;flex-direction:column;gap:1rem">
            <div style="display:flex;gap:1rem;align-items:center">
              <div style="background:var(--primary);color:var(--white);padding:.5rem;border-radius:8px;font-size:.75rem;font-weight:700;text-align:center;min-width:50px">MAR<br>01</div>
              <div><div style="font-weight:700;font-size:.9rem">Applications Open</div><div style="font-size:.8rem;color:var(--text-light)">Spring 2025 Batch</div></div>
            </div>
            <div style="display:flex;gap:1rem;align-items:center">
              <div style="background:var(--gold);color:var(--white);padding:.5rem;border-radius:8px;font-size:.75rem;font-weight:700;text-align:center;min-width:50px">MAR<br>31</div>
              <div><div style="font-weight:700;font-size:.9rem">Application Deadline</div><div style="font-size:.8rem;color:var(--text-light)">Submit by end of March</div></div>
            </div>
            <div style="display:flex;gap:1rem;align-items:center">
              <div style="background:var(--primary-dark);color:var(--white);padding:.5rem;border-radius:8px;font-size:.75rem;font-weight:700;text-align:center;min-width:50px">APR<br>05</div>
              <div><div style="font-weight:700;font-size:.9rem">Entry Test</div><div style="font-size:.8rem;color:var(--text-light)">Written + Recitation</div></div>
            </div>
            <div style="display:flex;gap:1rem;align-items:center">
              <div style="background:var(--primary);color:var(--white);padding:.5rem;border-radius:8px;font-size:.75rem;font-weight:700;text-align:center;min-width:50px">APR<br>15</div>
              <div><div style="font-weight:700;font-size:.9rem">Classes Begin</div><div style="font-size:.8rem;color:var(--text-light)">Spring 2025 Semester</div></div>
            </div>
          </div>
        </div>

        <div style="background:var(--beige);border-radius:var(--border-radius);padding:2rem;" class="reveal-left">
          <h3 style="font-size:1rem;color:var(--text-dark);margin-bottom:1rem"><i class="bi bi-telephone"></i> Need Help?</h3>
          <p style="font-size:.88rem;color:var(--text-medium);margin-bottom:1rem">Our admissions team is available to answer any questions:</p>
          <div style="font-size:.9rem;color:var(--primary);font-weight:700">+92 42 3571 0000</div>
          <div style="font-size:.85rem;color:var(--text-medium);margin-top:.3rem">admissions@darulfalah.edu.pk</div>
        </div>
      </div>

      <!-- Form -->
      <div class="admission-form-wrap reveal-right">
        <div class="form-header">
          <h2>Online Admission Form</h2>
          <p>Fill in the details below and our admissions team will contact you within 2 working days.</p>
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

        <form action="{{ route('admission.store', [], false) ?? '#' }}" method="POST" id="admission-form" novalidate>
          @csrf
          <div class="form-row">
            <div class="form-group">
              <label for="first-name">First Name *</label>
              <input type="text" id="first-name" name="firstName" placeholder="e.g. Muhammad" required>
              <div class="error"></div>
            </div>
            <div class="form-group">
              <label for="last-name">Last Name *</label>
              <input type="text" id="last-name" name="lastName" placeholder="e.g. Ahmad" required>
              <div class="error"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="email">Email Address *</label>
              <input type="email" id="email" name="email" placeholder="your@email.com" required>
              <div class="error"></div>
            </div>
            <div class="form-group">
              <label for="phone">Phone Number *</label>
              <input type="tel" id="phone" name="phone" placeholder="+92 300 0000000" required>
              <div class="error"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="dob">Date of Birth *</label>
              <input type="date" id="dob" name="dob" required>
              <div class="error"></div>
            </div>
            <div class="form-group">
              <label for="gender">Gender *</label>
              <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
              <div class="error"></div>
            </div>
          </div>
          <div class="form-group">
            <label for="course">Course Selection *</label>
            <select id="course" name="course_id" required>
              <option value="">-- Select a Course --</option>
              @if(isset($courses))
                  @foreach($courses as $course)
                      <option value="{{ $course->id }}">{{ $course->title }}</option>
                  @endforeach
              @else
                  <option value="1">Hifz-ul-Quran</option>
                  <option value="2">Tajweed ul Quran</option>
                  <option value="3">Alim Course (Dars-e-Nizami)</option>
                  <option value="4">Arabic Language</option>
                  <option value="5">Islamic Studies (Foundation)</option>
                  <option value="6">Tafseer Course</option>
                  <option value="7">Hadith Sciences</option>
                  <option value="8">Quran Nazira (Reading)</option>
              @endif
            </select>
            <div class="error"></div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="education">Previous Education *</label>
              <select id="education" name="previous_education" required>
                <option value="">-- Highest Level --</option>
                <option value="primary">Primary School</option>
                <option value="middle">Middle School</option>
                <option value="matric">Matriculation</option>
                <option value="intermediate">Intermediate</option>
                <option value="graduate">Graduate</option>
                <option value="religious">Religious Education</option>
              </select>
              <div class="error"></div>
            </div>
            <div class="form-group">
              <label for="boarding">Boarding Required?</label>
              <select id="boarding" name="boarding_required">
                <option value="0">No – Day Student</option>
                <option value="1">Yes – Need Boarding</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="guardian">Parent/Guardian Name *</label>
            <input type="text" id="guardian" name="guardian_name" placeholder="Full name of parent or guardian" required>
            <div class="error"></div>
          </div>
          <div class="form-group">
            <label for="address">Home Address *</label>
            <input type="text" id="address" name="address" placeholder="Street, City, Province" required>
            <div class="error"></div>
          </div>
          <div class="form-group">
            <label for="message">Additional Information / Message</label>
            <textarea id="message" name="message" placeholder="Any special requirements, questions, or relevant background information..."></textarea>
          </div>
          <div class="form-group" style="display:flex;align-items:flex-start;gap:.75rem">
            <input type="checkbox" id="agree" name="agree" required style="width:auto;margin-top:.25rem">
            <label for="agree" style="font-size:.85rem;color:var(--text-medium);cursor:pointer">I agree to the <strong>terms and conditions</strong> of Madrasa Dar-ul-Falah and confirm that the information provided is accurate. *</label>
          </div>
          <div class="error" id="agree-error" style="margin-top:-.5rem;margin-bottom:1rem"></div>
          <button type="submit" class="form-submit">Submit Admission Application ➤</button>
        </form>
      </div>

    </div>
  </div>
</section>
@endsection
