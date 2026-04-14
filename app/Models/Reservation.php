<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'status',
        'confirmed_at', 'cancelled_at', 'attended_at', 'no_show_at',
        'confirmed_by', 'cancelled_by', 'cancel_reason', 'notes',
        'payment_status', 'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'attended_at'  => 'datetime',
            'no_show_at'   => 'datetime',
            'paid_at'      => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pending'   => '待確認',
            'confirmed' => '已確認',
            'cancelled' => '已取消',
            'attended'  => '已出席',
            'no_show'   => '缺席',
            default     => $status,
        };
    }
}
