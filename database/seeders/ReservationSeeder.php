<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $adminId  = DB::table('users')->where('email', 'admin@socialwork.org.tw')->value('id');
        $memberId = DB::table('users')->where('email', 'yating.chen@example.com')->value('id');
        $guestId  = DB::table('users')->where('email', 'chiaming.lin@example.com')->value('id');

        $course1Id = DB::table('courses')->where('title', 'like', '家庭暴力%')->value('id');
        $course2Id = DB::table('courses')->where('title', 'like', '社區工作%')->value('id');

        DB::table('reservations')->insert([
            // 陳雅婷報名課程1，已確認
            [
                'user_id'        => $memberId,
                'course_id'      => $course1Id,
                'status'         => 'confirmed',
                'confirmed_at'   => now()->subDays(2),
                'cancelled_at'   => null,
                'attended_at'    => null,
                'no_show_at'     => null,
                'confirmed_by'   => $adminId,
                'cancelled_by'   => null,
                'cancel_reason'  => null,
                'notes'          => '希望安排前排座位，本人視力不佳',
                'payment_status' => 'paid',
                'paid_at'        => now()->subDays(3),
                'created_at'     => now()->subDays(5),
                'updated_at'     => now()->subDays(2),
            ],
            // 陳雅婷報名課程2，待確認
            [
                'user_id'        => $memberId,
                'course_id'      => $course2Id,
                'status'         => 'pending',
                'confirmed_at'   => null,
                'cancelled_at'   => null,
                'attended_at'    => null,
                'no_show_at'     => null,
                'confirmed_by'   => null,
                'cancelled_by'   => null,
                'cancel_reason'  => null,
                'notes'          => null,
                'payment_status' => 'unpaid',
                'paid_at'        => null,
                'created_at'     => now()->subDay(),
                'updated_at'     => now()->subDay(),
            ],
            // 林志明報名課程1，已取消
            [
                'user_id'        => $guestId,
                'course_id'      => $course1Id,
                'status'         => 'cancelled',
                'confirmed_at'   => null,
                'cancelled_at'   => now()->subDays(1),
                'attended_at'    => null,
                'no_show_at'     => null,
                'confirmed_by'   => null,
                'cancelled_by'   => $guestId,
                'cancel_reason'  => '臨時有事無法出席',
                'notes'          => null,
                'payment_status' => 'unpaid',
                'paid_at'        => null,
                'created_at'     => now()->subDays(4),
                'updated_at'     => now()->subDays(1),
            ],
        ]);
    }
}
