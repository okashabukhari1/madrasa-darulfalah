<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'urdu_name', 'slug', 'designation', 'specialization', 'qualification', 'experience', 'email', 'phone',
        'photo', 'bio', 'status', 'order',
    ];

    protected $casts = ['status' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($teacher) {
            if (empty($teacher->slug)) {
                $teacher->slug = Str::slug($teacher->name ?? $teacher->urdu_name ?? 'teacher-' . uniqid());
            }
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function courses() { return $this->hasMany(Course::class); }
    public function attendances() { return $this->hasMany(Attendance::class); }
    public function assignedStudents() { return $this->hasMany(Student::class, 'teacher_id'); }
    public function progressLogs() { return $this->hasMany(ProgressLog::class); }
    public function exams() { return $this->hasMany(Exam::class); }

    public function getRouteKeyName(): string { return 'slug'; }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        if ($this->user) {
            return $this->user->avatar_url;
        }
        $name = urlencode($this->name ?? $this->urdu_name ?? 'Teacher');
        return "https://ui-avatars.com/api/?name={$name}&color=2d6a4f&background=d4af37&size=128";
    }
}
