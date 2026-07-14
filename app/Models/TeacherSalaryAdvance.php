<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalaryAdvance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'amount',
        'advance_date',
        'reason',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'advance_date' => 'date',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

