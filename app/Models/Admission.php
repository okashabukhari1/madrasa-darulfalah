<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'course_id', 'name', 'email', 'phone', 'dob', 'gender',
        'father_name', 'address', 'city', 'qualification', 'boarding_required', 'message', 'status',
        'reviewed_by', 'reviewed_at', 'admin_notes',
    ];

    protected $casts = [
        'dob'         => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()       { return $this->belongsTo(User::class); }
    public function course()     { return $this->belongsTo(Course::class); }
    public function reviewer()   { return $this->belongsTo(User::class, 'reviewed_by'); }
}
