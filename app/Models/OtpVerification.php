<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'expires_at', 'attempts', 'is_used', 'resend_count'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used'    => 'boolean',
    ];

    public function isExpired(): bool    { return now()->isAfter($this->expires_at); }
    public function isValid(): bool      { return !$this->is_used && !$this->isExpired() && $this->attempts < 3; }
}
