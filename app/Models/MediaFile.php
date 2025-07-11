<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path', 'mime_type', 'size', 'user_id'];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_media');
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}

