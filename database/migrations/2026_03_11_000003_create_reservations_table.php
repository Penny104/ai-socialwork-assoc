<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 預約狀態機：
     *
     *   pending ──→ confirmed ──→ attended
     *      │             │           (出席)
     *      │             ├──→ no_show
     *      │             │    (缺席)
     *      ↓             ↓
     *   cancelled ←── cancelled
     *
     * 合法轉換：
     *   pending    → confirmed  (管理員確認)
     *   pending    → cancelled  (使用者或管理員取消)
     *   confirmed  → attended   (管理員標記出席)
     *   confirmed  → no_show    (管理員標記缺席)
     *   confirmed  → cancelled  (確認後取消，需記錄原因)
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('報名者');
            $table->foreignId('course_id')->constrained()->comment('報名課程');

            // 狀態機核心欄位
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'attended', 'no_show'])
                  ->default('pending')
                  ->comment('報名狀態');

            // 各狀態的時間戳記（防呆：可驗證轉換是否合法）
            $table->timestamp('confirmed_at')->nullable()->comment('確認時間');
            $table->timestamp('cancelled_at')->nullable()->comment('取消時間');
            $table->timestamp('attended_at')->nullable()->comment('出席時間');
            $table->timestamp('no_show_at')->nullable()->comment('缺席標記時間');

            // 操作人與備註
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->comment('確認者（管理員）');
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->comment('取消者');
            $table->string('cancel_reason')->nullable()->comment('取消原因');
            $table->text('notes')->nullable()->comment('備註（報名者填寫）');

            // 付款相關（選填，未來擴充）
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded', 'exempt'])
                  ->default('unpaid')
                  ->comment('付款狀態');
            $table->timestamp('paid_at')->nullable()->comment('付款時間');

            $table->timestamps();

            // 防止同一使用者重複報名同一課程（僅限非取消狀態由應用層控制，DB層確保唯一）
            $table->unique(['user_id', 'course_id'], 'unique_user_course');
            $table->index(['course_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
