<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'file_path', 'file_type', 'file_size', 'course_id', 'type', 'status'];
    protected $casts = ['status' => 'boolean'];

    public function course() { return $this->belongsTo(Course::class); }
}
