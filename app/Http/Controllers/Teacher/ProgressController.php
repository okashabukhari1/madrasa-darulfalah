<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\ProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyProgressNotification;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $teacher = Auth::user()->teacher;
        abort_if(!$teacher, 403, 'No teacher profile found.');

        $date = $request->input('date', date('Y-m-d'));
        
        $students = $teacher->assignedStudents()->with('user')->get();

        $attendances = Attendance::where('teacher_id', $teacher->id)
            ->whereDate('date', $date)
            ->get()->keyBy('student_id');

        $progressLogs = ProgressLog::where('teacher_id', $teacher->id)
            ->whereDate('date', $date)
            ->get()->keyBy('student_id');

        return view('teacher.progress.index', compact('students', 'date', 'attendances', 'progressLogs'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Progress form submitted', $request->all());

        $teacher = Auth::user()->teacher;
        abort_if(!$teacher, 403);

        $request->validate([
            'date' => 'required|date',
            'students' => 'required|array',
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');

        foreach ($request->students as $studentId => $data) {
            $student = Student::where('id', $studentId)->where('teacher_id', $teacher->id)->first();
            if (!$student) continue;

            $status = $data['status'] ?? 'present';
            $attendanceLog = Attendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $date
                ],
                [
                    'teacher_id' => $teacher->id,
                    'status' => $status,
                    'course_id' => null, 
                ]
            );

            $progLog = null;
            if ($status === 'present' || $status === 'late') {
                $para = $data['para'] ?? null;
                $surah = $data['surah'] ?? null;
                $ayah_from = $data['ayah_from'] ?? null;
                $ayah_to = $data['ayah_to'] ?? null;
                $lesson_type = $data['lesson_type'] ?? null;
                $remarks = $data['remarks'] ?? null;

                if ($para || $surah || $lesson_type || $remarks) {
                    $progLog = ProgressLog::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'date' => $date
                        ],
                        [
                            'teacher_id' => $teacher->id,
                            'para' => $para,
                            'surah' => $surah,
                            'ayah_from' => $ayah_from,
                            'ayah_to' => $ayah_to,
                            'lesson_type' => $lesson_type,
                            'remarks' => $remarks
                        ]
                    );
                } else {
                    ProgressLog::where('student_id', $student->id)->whereDate('date', $date)->delete();
                }
            } else {
                ProgressLog::where('student_id', $student->id)->whereDate('date', $date)->delete();
            }

            // Dispatch Email Notification
            if ($student->user && $student->user->email) {
                try {
                    Mail::to($student->user->email)->send(new DailyProgressNotification($student, $attendanceLog, $progLog, $date));
                } catch (\Exception $e) {
                    // Log the error but don't break the submission
                    \Illuminate\Support\Facades\Log::error('Mail failed for student ' . $student->id . ': ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('teacher.progress.index', ['date' => $date])
            ->with('success', 'Progress and Attendance saved successfully! Notifications were sent to students.');
    }

    public function history(Request $request)
    {
        $teacher = Auth::user()->teacher;
        $progressLogs = ProgressLog::where('teacher_id', $teacher->id)
            ->with('student.user')
            ->orderBy('date', 'desc')
            ->paginate(15);
            
        return view('teacher.progress.history', compact('progressLogs'));
    }
}
