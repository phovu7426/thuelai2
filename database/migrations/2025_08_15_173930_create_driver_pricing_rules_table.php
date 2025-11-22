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
        Schema::create('driver_pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('time_slot'); // Trước 22h, 22h-24h, Sau 24h
            $table->string('time_icon'); // Icon cho time slot
            $table->string('time_color'); // Màu sắc cho time slot
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
        Schema::dropIfExists('driver_pricing_rules');
    }
};
