<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'program',
        'class',
        'course_id',
        'monthly_amount',
        'is_active',
    ];

    protected $casts = [
        'monthly_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}

