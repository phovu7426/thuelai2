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
        Schema::create('driver_pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('time_slot'); // Trước 22h, 22h-24h, Sau 24h
            $table->string('time_icon'); // Icon cho time slot
            $table->string('time_color'); // Màu sắc cho time slot
            $table->decimal('from_distance', 8, 2); // Khoảng cách bắt đầu (km)
            $table->decimal('to_distance', 8, 2)->nullable(); // Khoảng cách kết thúc (km), null = không giới hạn
            $table->decimal('price', 10, 2); // Giá cho khoảng cách này
            $table->enum('price_type', ['fixed', 'per_km']); // Loại giá: cố định hoặc theo km
            $table->string('description')->nullable(); // Mô tả khoảng cách
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
        Schema::dropIfExists('driver_pricing_tiers');
    }
};
