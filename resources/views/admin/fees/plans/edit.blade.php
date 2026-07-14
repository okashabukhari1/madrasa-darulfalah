@extends('admin.layouts.app')
@section('title', 'Edit Fee Plan')
@section('page_title', 'Edit Fee Plan')

@section('content')
<div class="db-card" style="max-width: 900px; margin: 0 auto;">
    <div class="db-card-header">
        <h2><i class="bi bi-pencil"></i> Edit Plan</h2>
        <a href="{{ route('admin.fees.plans.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div style="padding: 1.5rem;">
        <form method="POST" action="{{ route('admin.fees.plans.update', $plan->id) }}" style="display:grid; grid-template-columns: repeat(12, 1fr); gap: 14px;">
            @csrf
            @method('PUT')

            <div style="grid-column: span 12;">
                <label style="font-size:12px; color:var(--text-light);">Plan Name</label>
                <input name="name" value="{{ old('name', $plan->name) }}" required style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Program (optional)</label>
                <select name="program" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                    <option value="">Any</option>
                    <option value="hifz" @selected(old('program', $plan->program)==='hifz')>Hifz</option>
                    <option value="nazra" @selected(old('program', $plan->program)==='nazra')>Nazra</option>
                    <option value="qaida" @selected(old('program', $plan->program)==='qaida')>Qaida</option>
                </select>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Class (optional)</label>
                <input name="class" value="{{ old('class', $plan->class) }}" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Course (optional)</label>
                <select name="course_id" style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                    <option value="">Any</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id', $plan->course_id)==$course->id)>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>

            <div style="grid-column: span 4;">
                <label style="font-size:12px; color:var(--text-light);">Monthly Amount (PKR)</label>
                <input type="number" step="0.01" min="0" name="monthly_amount" value="{{ old('monthly_amount', (float) $plan->monthly_amount) }}" required style="width:100%; padding:12px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
            </div>

            <div style="grid-column: span 8; display:flex; align-items:center; gap:10px; margin-top:22px;">
                <input type="checkbox" name="is_active" id="is_active" @checked(old('is_active', $plan->is_active))>
                <label for="is_active" style="margin:0; cursor:pointer;">Active</label>
            </div>

            <div style="grid-column: span 12; display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                <button type="submit" class="btn btn-gold btn-sm"><i class="bi bi-check2-circle"></i> Update Plan</button>
                <a href="{{ route('admin.fees.plans.index') }}" class="btn btn-outline btn-sm"><i class="bi bi-x-circle"></i> Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

