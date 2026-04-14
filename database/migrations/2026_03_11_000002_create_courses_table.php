<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('建立者/主辦人');
            $table->string('title')->comment('課程名稱');
            $table->text('description')->nullable()->comment('課程說明');
            $table->string('instructor')->nullable()->comment('講師姓名');
            $table->string('location')->nullable()->comment('上課地點');
            $table->timestamp('start_at')->comment('開始時間');
            $table->timestamp('end_at')->comment('結束時間');
            $table->unsignedInteger('max_participants')->default(30)->comment('招收人數上限');
            $table->unsignedInteger('registered_count')->default(0)->comment('已報名人數（快取）');
            $table->decimal('price', 10, 2)->default(0)->comment('費用（0為免費）');
            $table->unsignedTinyInteger('credit_hours')->default(0)->comment('繼續教育時數');
            $table->enum('status', ['draft', 'open', 'closed', 'cancelled'])
                  ->default('draft')
                  ->comment('狀態：草稿/開放報名/截止/取消');
            $table->text('cancel_reason')->nullable()->comment('取消原因');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
