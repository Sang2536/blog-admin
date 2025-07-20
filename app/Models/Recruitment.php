<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruitment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'position',
        'location',
        'type',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Danh sách ứng viên đã nộp đơn vào đợt tuyển dụng này
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
