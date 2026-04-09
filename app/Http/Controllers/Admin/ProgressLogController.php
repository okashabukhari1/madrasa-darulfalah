<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressLog;
use Illuminate\Http\Request;

class ProgressLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgressLog::with(['student.user', 'teacher']);

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        
        if ($request->filled('program')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('program', $request->program);
            });
        }

        $logs = $query->latest('date')->paginate(20);

        return view('admin.progress_logs.index', compact('logs'));
    }
}
