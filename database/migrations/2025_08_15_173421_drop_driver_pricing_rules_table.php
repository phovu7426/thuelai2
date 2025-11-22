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
        Schema::dropIfExists('driver_pricing_rules');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('driver_pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('time_slot');
            $table->string('time_icon');
            $table->string('time_color');
            $table->decimal('base_price', 10, 2);
            $table->decimal('price_6_10km', 10, 2);
            $table->decimal('price_over_10km', 10, 2);
            $table->string('price_over_30km');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }
};
