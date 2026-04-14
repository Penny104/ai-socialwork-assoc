<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = DB::table('users')->where('email', 'admin@socialwork.org.tw')->value('id');

        DB::table('news')->insert([
            [
                'user_id'      => $adminId,
                'title'        => '114年度社工師繼續教育課程報名開始',
                'excerpt'      => '本公會114年度繼續教育課程系列報名正式開跑，歡迎會員踴躍參加。',
                'content'      => '<p>本公會114年度繼續教育課程系列報名正式開跑！課程涵蓋個案管理、社區工作、家庭暴力防治等主題，符合社工師換照積分需求。</p><p>報名日期：即日起至額滿為止<br>上課地點：本公會會議室（台北市中正區）</p><p>請登入會員系統完成報名，名額有限，請提早報名！</p>',
                'thumbnail'    => null,
                'category'     => 'announcement',
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'view_count'   => 128,
                'created_at'   => now()->subDays(3),
                'updated_at'   => now()->subDays(3),
                'deleted_at'   => null,
            ],
            [
                'user_id'      => $adminId,
                'title'        => '【活動】世界社工日公益論壇報名',
                'excerpt'      => '3月18日世界社工日，本公會舉辦公益論壇，探討高齡社會下的社工角色。',
                'content'      => '<p>每年3月第三個星期二為世界社工日。今年本公會特別舉辦「高齡社會中的社工角色」公益論壇。</p><p>主題：高齡照顧、失智友善社區、長照2.0政策解析<br>時間：2026年3月18日 09:00–17:00<br>地點：國立台灣大學社會科學院（免費入場）</p>',
                'thumbnail'    => null,
                'category'     => 'activity',
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'view_count'   => 256,
                'created_at'   => now()->subDays(7),
                'updated_at'   => now()->subDays(7),
                'deleted_at'   => null,
            ],
            [
                'user_id'      => $adminId,
                'title'        => '會員福利｜職業責任險團體投保方案更新',
                'excerpt'      => '本公會協助辦理職業責任保險，114年方案費率調整，請會員留意。',
                'content'      => '<p>為保障社工師執業安全，本公會持續協助辦理職業責任保險。114年度方案已更新，保費略有調整，詳情請見附件說明文件。</p><p>投保截止日：2026年4月30日<br>洽詢信箱：insurance@socialwork.org.tw</p>',
                'thumbnail'    => null,
                'category'     => 'welfare',
                'is_published' => false,
                'published_at' => null,
                'view_count'   => 0,
                'created_at'   => now(),
                'updated_at'   => now(),
                'deleted_at'   => null,
            ],
        ]);
    }
}
