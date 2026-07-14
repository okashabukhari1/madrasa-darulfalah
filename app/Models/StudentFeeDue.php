<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFeeDue extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'fee_plan_id',
        'year',
        'month',
        'amount',
        'status',
        'due_date',
        'generated_at',
        'fee_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'generated_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feePlan()
    {
        return $this->belongsTo(FeePlan::class);
    }
}

