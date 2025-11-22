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
        Schema::table('post_categories', function (Blueprint $table) {
            // Thêm cột parent_id
            $table->unsignedBigInteger('parent_id')->nullable()->after('description');
            $table->foreign('parent_id')->references('id')->on('post_categories')->onDelete('set null');
            
            // Thêm cột status
            $table->enum('status', ['active', 'inactive'])->default('active')->after('parent_id');
            
            // Xóa các cột không cần thiết
            $table->dropColumn(['image', 'color', 'sort_order', 'is_active', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_categories', function (Blueprint $table) {
            // Xóa foreign key và cột mới
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'status']);
            
            // Thêm lại các cột cũ
            $table->string('image')->nullable();
            $table->string('color')->default('#007bff');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
        });
    }
};
