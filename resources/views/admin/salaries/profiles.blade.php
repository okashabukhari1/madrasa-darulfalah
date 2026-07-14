@extends('admin.layouts.app')
@section('title', 'Salary Profiles')
@section('page_title', 'Teacher Salary Profiles')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-sliders"></i> Salary Profiles</h2>
        <a href="{{ route('admin.salaries.dashboard') }}" class="btn btn-outline btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Teacher</th>
                    <th style="text-align:right;">Base Salary</th>
                    <th style="text-align:right;">Present/day</th>
                    <th style="text-align:right;">Late/day</th>
                    <th style="text-align:right;">Absent/day</th>
                    <th>Status</th>
                    <th>Save</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    @php $p = $teacher->salaryProfile; @endphp
                    <tr>
                        <td style="font-weight:700;">{{ $teacher->teacher_id }} — {{ $teacher->name }}</td>
                        <td colspan="6">
                            <form method="POST" action="{{ route('admin.salaries.profiles.save', $teacher->id) }}" style="display:grid; grid-template-columns: repeat(12, 1fr); gap:10px; align-items:center;">
                                @csrf
                                <div style="grid-column: span 2;">
                                    <input type="number" step="0.01" min="0" name="base_salary" value="{{ old('base_salary', (float)($p->base_salary ?? 0)) }}" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                                </div>
                                <div style="grid-column: span 2;">
                                    <input type="number" step="0.01" min="0" name="per_present_day" value="{{ old('per_present_day', (float)($p->per_present_day ?? 0)) }}" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                                </div>
                                <div style="grid-column: span 2;">
                                    <input type="number" step="0.01" min="0" name="per_late_day" value="{{ old('per_late_day', (float)($p->per_late_day ?? 0)) }}" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                                </div>
                                <div style="grid-column: span 2;">
                                    <input type="number" step="0.01" min="0" name="per_absent_day" value="{{ old('per_absent_day', (float)($p->per_absent_day ?? 0)) }}" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(0,0,0,.08);">
                                </div>
                                <div style="grid-column: span 2; display:flex; align-items:center; gap:8px;">
                                    <input type="checkbox" name="is_active" @checked(old('is_active', $p?->is_active ?? false))>
                                    <span class="badge {{ ($p?->is_active ?? false) ? 'badge-green' : 'badge-gray' }}">{{ ($p?->is_active ?? false) ? 'Active' : 'Disabled' }}</span>
                                </div>
                                <div style="grid-column: span 2; text-align:right;">
                                    <button class="btn btn-gold btn-xs" type="submit"><i class="bi bi-save"></i> Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

