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
        Schema::table('driver_pricing_tiers', function (Blueprint $table) {
            // Thay đổi cột price từ decimal thành string để hỗ trợ cả số và text
            $table->string('price', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_pricing_tiers', function (Blueprint $table) {
            // Khôi phục lại cột price thành decimal
            $table->decimal('price', 10, 2)->change();
        });
    }
};
