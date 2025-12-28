<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // First drop foreign key constraints if they exist
            if (Schema::hasColumn('posts', 'user_id')) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
            }
            
            // Drop existing columns if they exist
            $columnsToDrop = [];
            if (Schema::hasColumn('posts', 'user_id')) $columnsToDrop[] = 'user_id';
            if (Schema::hasColumn('posts', 'name')) $columnsToDrop[] = 'name';
            if (Schema::hasColumn('posts', 'require_login')) $columnsToDrop[] = 'require_login';
            if (Schema::hasColumn('posts', 'description')) $columnsToDrop[] = 'description';
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
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
            
            // Add indexes - check if column exists first
            if (Schema::hasColumn('posts', 'status') && Schema::hasColumn('posts', 'published_at')) {
                try {
                    $table->index(['status', 'published_at'], 'posts_status_published_at_index');
                } catch (\Exception $e) {
                    // Index might already exist, ignore
                }
            }
            
            if (Schema::hasColumn('posts', 'featured') && Schema::hasColumn('posts', 'published_at')) {
                try {
                    $table->index(['featured', 'published_at'], 'posts_featured_published_at_index');
                } catch (\Exception $e) {
                    // Index might already exist, ignore
                }
            }
            
            if (Schema::hasColumn('posts', 'views')) {
                try {
                    $table->index('views', 'posts_views_index');
                } catch (\Exception $e) {
                    // Index might already exist, ignore
                }
            }
        });
    }

    public function down(): void
    {
        // Helper function to safely drop foreign key
        $dropForeignKey = function($column) {
            try {
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'posts' 
                    AND COLUMN_NAME = ? 
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ", [$column]);
                
                if (!empty($foreignKeys)) {
                    DB::statement("ALTER TABLE `posts` DROP FOREIGN KEY `{$foreignKeys[0]->CONSTRAINT_NAME}`");
                }
            } catch (\Exception $e) {
                // Ignore if doesn't exist
            }
        };
        
        // Helper function to safely drop index
        $dropIndex = function($indexName) {
            try {
                $indexes = DB::select("
                    SELECT INDEX_NAME 
                    FROM information_schema.STATISTICS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'posts' 
                    AND INDEX_NAME = ?
                ", [$indexName]);
                
                if (!empty($indexes)) {
                    DB::statement("ALTER TABLE `posts` DROP INDEX `{$indexName}`");
                }
            } catch (\Exception $e) {
                // Ignore if doesn't exist
            }
        };
        
        // Drop foreign keys
        $dropForeignKey('category_id');
        $dropForeignKey('author_id');
        
        // Drop indexes
        $dropIndex('posts_status_published_at_index');
        $dropIndex('posts_featured_published_at_index');
        $dropIndex('posts_views_index');
        
        Schema::table('posts', function (Blueprint $table) {
            // Drop soft deletes column if exists
            if (Schema::hasColumn('posts', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            
            // Drop columns if they exist
            $columnsToDrop = [];
            $columns = ['title', 'slug', 'excerpt', 'category_id', 'author_id', 
                'published_at', 'meta_title', 'meta_description', 'meta_keywords',
                'featured', 'views', 'reading_time'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('posts', $column)) {
                    $columnsToDrop[] = $column;
                }
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Restore old columns only if they don't exist
            if (!Schema::hasColumn('posts', 'user_id')) {
                $table->foreignId('user_id')->constrained()->after('id');
            }
            if (!Schema::hasColumn('posts', 'name')) {
                $table->string('name')->after('user_id');
            }
            if (!Schema::hasColumn('posts', 'description')) {
                $table->text('description')->nullable()->after('content');
            }
            if (!Schema::hasColumn('posts', 'require_login')) {
                $table->boolean('require_login')->default(false)->after('description');
            }
        });
    }
};
