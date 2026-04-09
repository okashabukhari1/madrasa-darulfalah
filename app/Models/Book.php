<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'author', 'category', 'book_category_id', 'description', 'cover_image',
        'file_path', 'file_type', 'external_link', 'downloads', 'status',
        'is_featured', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            if (empty($book->slug)) {
                $book->slug = Str::slug($book->title);
            }
        });
    }

    public function getRouteKeyName(): string { return 'slug'; }

    public function getDownloadUrlAttribute(): string
    {
        if ($this->external_link) return $this->external_link;
        if ($this->file_path)    return asset('storage/' . $this->file_path);
        return '#';
    }

    public function bookCategory()
    {
        return $this->belongsTo(BookCategory::class);
    }
}
