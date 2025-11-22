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
        Schema::create('driver_pricing_rule_distances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pricing_rule_id')->constrained('driver_pricing_rules')->onDelete('cascade');
            $table->foreignId('distance_tier_id')->constrained('driver_distance_tiers')->onDelete('cascade');
            $table->decimal('price', 10, 2)->nullable(); // Giá số
            $table->string('price_text')->nullable(); // Giá text (như "Thỏa thuận")
            $table->timestamps();
            
            // Đảm bảo mỗi quy tắc chỉ có 1 giá cho mỗi khoảng cách
            $table->unique(['pricing_rule_id', 'distance_tier_id'], 'pricing_rule_distance_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_pricing_rule_distances');
    }
};

