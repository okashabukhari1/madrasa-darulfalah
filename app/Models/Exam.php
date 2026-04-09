<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'program',
        'exam_type',
        'date',
        'para',
        'surah',
        'ayah_from',
        'ayah_to',
        'mistakes',
        'fluency',
        'tajweed',
        'grade',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
