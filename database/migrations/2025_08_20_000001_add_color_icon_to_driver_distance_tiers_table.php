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
        Schema::table('driver_distance_tiers', function (Blueprint $table) {
            $table->string('color', 7)->nullable()->after('sort_order'); // Màu sắc hex
            $table->string('icon')->nullable()->after('color'); // Icon class
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_distance_tiers', function (Blueprint $table) {
            $table->dropColumn(['color', 'icon']);
        });
    }
};
