<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeePlan;
use App\Models\Course;
use Illuminate\Http\Request;

class FeePlanController extends Controller
{
    public function index()
    {
        $plans = FeePlan::query()->latest()->paginate(15);
        return view('admin.fees.plans.index', compact('plans'));
    }

    public function create()
    {
        $courses = Course::query()->orderBy('title')->get();
        return view('admin.fees.plans.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'program' => ['nullable', 'in:hifz,nazra,qaida'],
            'class' => ['nullable', 'string', 'max:255'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'monthly_amount' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->has('is_active');
        FeePlan::create($data);

        return redirect()->route('admin.fees.plans.index')->with('success', 'Fee plan created.');
    }

    public function edit(FeePlan $plan)
    {
        $courses = Course::query()->orderBy('title')->get();
        return view('admin.fees.plans.edit', compact('plan', 'courses'));
    }

    public function update(Request $request, FeePlan $plan)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'program' => ['nullable', 'in:hifz,nazra,qaida'],
            'class' => ['nullable', 'string', 'max:255'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'monthly_amount' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable'],
        ]);

        $data['is_active'] = $request->has('is_active');
        $plan->update($data);

        return redirect()->route('admin.fees.plans.index')->with('success', 'Fee plan updated.');
    }

    public function destroy(FeePlan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.fees.plans.index')->with('success', 'Fee plan deleted.');
    }
}

