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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('parent_id')->nullable(); // Cho phép danh mục con
            $table->text('description')->nullable();
//            $table->boolean('status')->default(1); // Mặc định là hiển thị
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            // Khóa ngoại cho parent_id để xử lý danh mục con
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
