<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'user_id', 'name', 'urdu_name', 'category_id', 'teacher_id', 'program', 'father_name', 'guardian_name', 'guardian_phone', 'cnic', 'dob', 'gender',
        'address', 'city', 'class', 'batch', 'enrollment_date', 'status', 'notes',
    ];

    protected $casts = [
        'dob'             => 'date',
        'enrollment_date' => 'date',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function courses() { return $this->belongsToMany(Course::class, 'course_student')->withPivot('status', 'enrolled_at')->withTimestamps(); }
    public function materials() { return $this->hasManyThrough(Material::class, Course::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function progressLogs() { return $this->hasMany(ProgressLog::class); }
    public function exams() { return $this->hasMany(Exam::class); }

    public static function generateStudentId(): string
    {
        $last = self::latest('id')->first();
        $nextNum = $last ? (intval(substr($last->student_id, 3)) + 1) : 1;
        return 'STD' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
    }
}
