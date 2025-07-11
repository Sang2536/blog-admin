<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt',
        'content', 'status', 'is_featured', 'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(MediaFile::class, 'post_media');
    }

    // Accessor: Short content preview
    public function getExcerptShortAttribute(): string
    {
        return Str::limit(strip_tags($this->excerpt ?? $this->content), 100);
    }

    //  scope filter
    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['category'])) {
            $query->whereHas('category', fn ($q) =>
            $q->where('slug', $filters['category'])
            );
        }

        if (!empty($filters['tags'])) {
            $tags = explode(',', $filters['tags']);
            $query->whereHas('tags', fn ($q) =>
            $q->whereIn('slug', $tags)
            );
        }

        return $query;
    }
}

