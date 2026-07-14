<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalaryProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'base_salary',
        'per_present_day',
        'per_late_day',
        'per_absent_day',
        'is_active',
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'per_present_day' => 'decimal:2',
        'per_late_day' => 'decimal:2',
        'per_absent_day' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

