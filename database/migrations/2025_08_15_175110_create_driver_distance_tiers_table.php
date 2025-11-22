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
        Schema::create('driver_distance_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên hiển thị: "5km đầu", "6-10km", ">10km", ">30km"
            $table->string('description')->nullable(); // Mô tả chi tiết
            $table->decimal('from_distance', 8, 2)->default(0); // Từ km
            $table->decimal('to_distance', 8, 2)->nullable(); // Đến km (null = không giới hạn)
            $table->string('display_text'); // Text hiển thị: "5km đầu", "6-10km", ">10km", ">30km"
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_distance_tiers');
    }
};
