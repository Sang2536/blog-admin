<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recruitment_id',
        'user_id',
        'full_name',
        'email',
        'phone',
        'cv_path',
        'cover_letter',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Đợt tuyển dụng mà đơn này thuộc về
     */
    public function recruitment(): BelongsTo
    {
        return $this->belongsTo(Recruitment::class);
    }

    /**
     * Người dùng đã nộp đơn (nếu có login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCvUrlAttribute()
    {
        return $this->cv_path ? asset('storage/' . $this->cv_path) : null;
    }
}
