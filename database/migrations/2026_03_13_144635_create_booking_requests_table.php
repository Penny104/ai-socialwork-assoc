<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->string('institution_name');
            $table->date('requested_date');
            $table->string('teaching_hours', 100)->nullable();
            $table->string('location', 200)->nullable();
            $table->text('expectations')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_email', 150);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_requests');
    }
};
