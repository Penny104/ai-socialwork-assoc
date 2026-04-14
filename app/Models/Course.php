<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'description', 'instructor', 'location',
        'start_at', 'end_at', 'max_participants', 'registered_count',
        'price', 'credit_hours', 'status', 'cancel_reason',
    ];

    protected function casts(): array
    {
        return [
            'start_at'   => 'datetime',
            'end_at'     => 'datetime',
            'price'      => 'decimal:2',
            'is_free'    => 'boolean',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')->orderBy('start_at');
    }

    public function isFree(): bool
    {
        return (float) $this->price === 0.0;
    }

    public function isFull(): bool
    {
        return $this->registered_count >= $this->max_participants;
    }

    public function remainingSeats(): int
    {
        return max(0, $this->max_participants - $this->registered_count);
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'draft'     => '草稿',
            'open'      => '開放報名',
            'closed'    => '截止報名',
            'cancelled' => '已取消',
            default     => $status,
        };
    }
}
