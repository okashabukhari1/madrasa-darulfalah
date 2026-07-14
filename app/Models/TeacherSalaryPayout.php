<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalaryPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'year',
        'month',
        'present_days',
        'late_days',
        'absent_days',
        'base_salary',
        'attendance_amount',
        'advance_deduction',
        'other_deduction',
        'bonus',
        'net_pay',
        'status',
        'paid_date',
        'note',
    ];

    protected $casts = [
        'base_salary' => 'decimal:2',
        'attendance_amount' => 'decimal:2',
        'advance_deduction' => 'decimal:2',
        'other_deduction' => 'decimal:2',
        'bonus' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'paid_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

