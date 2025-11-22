<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // First drop foreign key constraints
            $table->dropForeign(['user_id']);
            
            // Drop existing columns
            $table->dropColumn(['user_id', 'name', 'require_login', 'description']);
            
            // Add new columns
            $table->string('title')->after('id');
            $table->string('slug')->unique()->after('title');
            $table->text('excerpt')->nullable()->after('slug');
            $table->longText('content')->change();
            $table->foreignId('category_id')->constrained('post_categories')->onDelete('cascade')->after('image');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade')->after('category_id');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
            $table->timestamp('published_at')->nullable()->after('status');
            $table->string('meta_title')->nullable()->after('published_at');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->text('meta_keywords')->nullable()->after('meta_description');
            $table->boolean('featured')->default(false)->after('meta_keywords');
            $table->integer('views')->default(0)->after('featured');
            $table->integer('reading_time')->nullable()->after('views');
            $table->softDeletes();
            
            // Add indexes
            $table->index(['status', 'published_at']);
            $table->index(['featured', 'published_at']);
            $table->index('views');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Remove new columns
            $table->dropForeign(['category_id', 'author_id']);
            $table->dropIndex(['status', 'published_at']);
            $table->dropIndex(['featured', 'published_at']);
            $table->dropIndex('views');
            $table->dropSoftDeletes();
            
            $table->dropColumn([
                'title', 'slug', 'excerpt', 'category_id', 'author_id', 
                'published_at', 'meta_title', 'meta_description', 'meta_keywords',
                'featured', 'views', 'reading_time'
            ]);
            
            // Restore old columns
            $table->foreignId('user_id')->constrained()->after('id');
            $table->string('name')->after('user_id');
            $table->text('description')->nullable()->after('content');
            $table->boolean('require_login')->default(false)->after('description');
        });
    }
};
