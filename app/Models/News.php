<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'excerpt', 'content',
        'thumbnail', 'category', 'is_published', 'published_at', 'view_count',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->orderByDesc('published_at');
    }

    public static function categoryLabel(string $category): string
    {
        return match ($category) {
            'announcement' => '公告',
            'activity'     => '活動',
            'welfare'      => '會員福利',
            default        => '其他',
        };
    }
}
