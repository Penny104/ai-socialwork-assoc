<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('發布者');
            $table->string('title')->comment('標題');
            $table->string('excerpt')->nullable()->comment('摘要');
            $table->longText('content')->comment('內容');
            $table->string('thumbnail')->nullable()->comment('封面圖片路徑');
            $table->enum('category', ['announcement', 'activity', 'welfare', 'other'])
                  ->default('announcement')
                  ->comment('分類：公告/活動/福利/其他');
            $table->boolean('is_published')->default(false)->comment('是否發布');
            $table->timestamp('published_at')->nullable()->comment('發布時間');
            $table->integer('view_count')->default(0)->comment('瀏覽次數');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'published_at']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
