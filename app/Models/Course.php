<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'teacher_id', 'title', 'urdu_title', 'slug', 'description', 'urdu_description',
        'content', 'level', 'image', 'duration', 'fee', 'is_featured', 'status', 'order',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'is_featured' => 'boolean',
        'fee'         => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    public function teacher()   { return $this->belongsTo(Teacher::class); }
    public function category()  { return $this->belongsTo(Category::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function students()  { return $this->belongsToMany(Student::class, 'course_student')->withPivot('status', 'enrolled_at')->withTimestamps(); }
    public function admissions(){ return $this->hasMany(Admission::class); }
    public function materials() { return $this->hasMany(Material::class); }

    public function getRouteKeyName(): string { return 'slug'; }
}
