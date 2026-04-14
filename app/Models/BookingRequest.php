<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'institution_name',
        'requested_date',
        'teaching_hours',
        'location',
        'expectations',
        'contact_phone',
        'contact_email',
        'status',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'requested_date' => 'date',
        ];
    }

    public static function statusLabel(string $status): string
    {
        return match($status) {
            'pending'   => '待確認',
            'confirmed' => '已確認',
            'cancelled' => '已取消',
            default     => $status,
        };
    }
}
