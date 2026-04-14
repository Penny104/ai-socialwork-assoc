<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,        // 先建使用者
            NewsSeeder::class,        // 公告（依賴 users.id）
            CourseSeeder::class,      // 課程（依賴 users.id）
            ReservationSeeder::class, // 預約（依賴 users.id + courses.id）
        ]);
    }
}
