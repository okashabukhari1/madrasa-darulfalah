<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'status'            => 'boolean',
    ];

    // Role helpers
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isTeacher(): bool  { return $this->role === 'teacher'; }
    public function isStudent(): bool  { return $this->role === 'student'; }
    public function isUser(): bool     { return $this->role === 'user'; }

    public function getRedirectRoute(): string
    {
        return match($this->role) {
            'admin'   => '/admin/dashboard',
            'teacher' => '/teacher/dashboard',
            'student' => '/student/dashboard',
            default   => '/profile',
        };
    }

    // Relationships
    public function teacher()    { return $this->hasOne(Teacher::class); }
    public function student()    { return $this->hasOne(Student::class); }
    public function admissions() { return $this->hasMany(Admission::class); }
    public function messages()   { return $this->hasMany(Message::class, 'email', 'email'); }
    public function activityLogs() { return $this->hasMany(ActivityLog::class); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&color=2d6a4f&background=d4af37&size=128";
    }
}
