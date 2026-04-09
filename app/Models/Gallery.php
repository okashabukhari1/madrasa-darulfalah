<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'category', 'description', 'status', 'order'];
    protected $casts = ['status' => 'boolean'];
}
