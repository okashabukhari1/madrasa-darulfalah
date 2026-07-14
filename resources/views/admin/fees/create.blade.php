@extends('admin.layouts.app')
@section('title', 'Record Fee')
@section('page_title', 'Record Fee / Donation')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-plus-circle"></i> Record New Payment</h2>
        <div style="display:flex; gap:0.5rem;">
            <a href="{{ route('admin.fees.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-list-check"></i> Records</a>
            <a href="{{ route('admin.fees.dashboard') }}" class="btn btn-outline btn-sm"><i class="bi bi-speedometer2"></i> Dashboard</a>
        </div>
    </div>

    <div style="padding: 1.5rem;">
        <form method="POST" action="{{ route('admin.fees.store') }}" style="display:grid; grid-template-columns: repeat(12, 1fr); gap: 14px;">
            @csrf

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Student ID (required)</label>
                <input id="student_id" name="student_id" value="{{ old('student_id') }}" placeholder="STD000001" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);" required>
                <small id="studentLookupMsg" style="display:block; margin-top:6px; color:var(--text-light);"></small>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Assigned Teacher (auto)</label>
                <input id="teacher_display" value="—" readonly style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08); background: rgba(0,0,0,0.03);">
                <small style="color:var(--text-light); display:block; margin-top:6px;">Teacher is fetched from the student profile.</small>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Payment Date</label>
                <input type="date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);" required>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Amount (PKR)</label>
                <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount') }}" placeholder="5000" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);" required>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Payment Type (Mode)</label>
                <select name="payment_type" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);" required>
                    @foreach($paymentTypes as $type)
                        <option value="{{ $type }}" @selected(old('payment_type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Status</label>
                <select name="status" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                    <option value="paid" @selected(old('status', 'paid') === 'paid')>Paid</option>
                    <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                </select>
                <small style="color:var(--text-light); display:block; margin-top:6px;">Default is paid; admin can set pending manually.</small>
            </div>

            <div style="grid-column: span 6;">
                <label style="font-size:12px; color:var(--text-light);">Name (optional override)</label>
                <input id="name" name="name" value="{{ old('name') }}" placeholder="Auto from student if blank" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 6;">
                <label style="font-size:12px; color:var(--text-light);">Phone (optional override)</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" placeholder="Auto from student if blank" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 12; display:flex; align-items:center; gap:10px; margin-top:6px;">
                <input type="checkbox" id="toggleCheque" style="transform: translateY(-1px);">
                <label for="toggleCheque" style="margin:0; cursor:pointer;">Payment via cheque/bank (show bank fields)</label>
            </div>

            <div id="bankFields" style="grid-column: span 12; display:none; grid-template-columns: repeat(12, 1fr); gap:14px;">
                <div style="grid-column: span 6;">
                    <label style="font-size:12px; color:var(--text-light);">Bank</label>
                    <input name="bank" value="{{ old('bank') }}" placeholder="Bank name" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                </div>
                <div style="grid-column: span 6;">
                    <label style="font-size:12px; color:var(--text-light);">Cheque / Check No</label>
                    <input name="check_no" value="{{ old('check_no') }}" placeholder="Cheque number" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                </div>
            </div>

            <div style="grid-column: span 12; display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                <button type="submit" class="btn btn-gold btn-sm"><i class="bi bi-check2-circle"></i> Save</button>
                <a href="{{ route('admin.fees.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-x-circle"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(() => {
    const studentIdEl = document.getElementById('student_id');
    const teacherDisplay = document.getElementById('teacher_display');
    const msg = document.getElementById('studentLookupMsg');
    const nameEl = document.getElementById('name');
    const phoneEl = document.getElementById('phone');

    const toggle = document.getElementById('toggleCheque');
    const bankFields = document.getElementById('bankFields');
    if (!toggle || !bankFields) return;

    const hasOld = {!! (old('bank') || old('check_no') ? 'true' : 'false') !!};
    if (hasOld) toggle.checked = true;

    const sync = () => {
        bankFields.style.display = toggle.checked ? 'grid' : 'none';
    };
    toggle.addEventListener('change', sync);
    sync();

    async function lookup() {
        const studentId = (studentIdEl?.value || '').trim();
        if (!studentId) {
            if (msg) msg.textContent = '';
            if (teacherDisplay) teacherDisplay.value = '—';
            return;
        }

        if (msg) msg.textContent = 'Fetching student...';
        try {
            const res = await fetch(`{{ url('/admin/fees/lookup-student') }}/${encodeURIComponent(studentId)}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (!res.ok || !data.ok) throw new Error(data.message || 'Lookup failed');

            const teacherText = data.teacher
                ? `${data.teacher.teacher_id} — ${data.teacher.name}`
                : 'Unassigned';
            if (teacherDisplay) teacherDisplay.value = teacherText;
            if (msg) msg.textContent = `Student: ${data.student.name || studentId}`;

            // Only auto-fill if admin didn't type overrides
            if (nameEl && !nameEl.value) nameEl.value = data.student.name || '';
            if (phoneEl && !phoneEl.value) phoneEl.value = data.student.phone || '';
        } catch (e) {
            if (teacherDisplay) teacherDisplay.value = '—';
            if (msg) msg.textContent = 'Student not found or lookup failed.';
        }
    }

    if (studentIdEl) {
        studentIdEl.addEventListener('blur', lookup);
        studentIdEl.addEventListener('change', lookup);
    }
    // Auto lookup if old value exists
    if (studentIdEl && studentIdEl.value) lookup();
})();
</script>
@endpush

