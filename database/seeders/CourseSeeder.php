<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('users')->where('email', 'admin@socialwork.org.tw')->value('id');

        DB::table('courses')->insert([
            [
                'user_id'            => $adminId,
                'title'              => '家庭暴力防治與社工實務工作坊',
                'description'        => '本課程針對家庭暴力防治工作進行深度探討，包含法規解析、跨專業合作模式及實際案例演練，適合直接服務社工師參與。',
                'instructor'         => '王美玲 社工師',
                'location'           => '台北市中正區公會會議室A',
                'start_at'           => now()->addDays(14)->setTime(9, 0),
                'end_at'             => now()->addDays(14)->setTime(17, 0),
                'max_participants'   => 30,
                'registered_count'   => 12,
                'price'              => 500.00,
                'credit_hours'       => 6,
                'status'             => 'open',
                'cancel_reason'      => null,
                'created_at'         => now(),
                'updated_at'         => now(),
                'deleted_at'         => null,
            ],
            [
                'user_id'            => $adminId,
                'title'              => '社區工作與倡議策略進階研習',
                'description'        => '探討社區組織、資源整合與政策倡議策略，適合從事社區工作的社工師進修。',
                'instructor'         => '張建國 教授',
                'location'           => '線上課程（Zoom）',
                'start_at'           => now()->addDays(30)->setTime(13, 0),
                'end_at'             => now()->addDays(30)->setTime(17, 0),
                'max_participants'   => 50,
                'registered_count'   => 3,
                'price'              => 0.00,
                'credit_hours'       => 3,
                'status'             => 'open',
                'cancel_reason'      => null,
                'created_at'         => now(),
                'updated_at'         => now(),
                'deleted_at'         => null,
            ],
            [
                'user_id'            => $adminId,
                'title'              => '老人保護個案評估與處遇（草稿）',
                'description'        => '課程規劃中，尚未對外開放報名。',
                'instructor'         => null,
                'location'           => '待定',
                'start_at'           => now()->addDays(60)->setTime(9, 0),
                'end_at'             => now()->addDays(60)->setTime(16, 0),
                'max_participants'   => 25,
                'registered_count'   => 0,
                'price'              => 800.00,
                'credit_hours'       => 6,
                'status'             => 'draft',
                'cancel_reason'      => null,
                'created_at'         => now(),
                'updated_at'         => now(),
                'deleted_at'         => null,
            ],
        ]);
    }
}
