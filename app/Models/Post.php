<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured',
        'views',
        'reading_time'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'views' => 'integer',
        'reading_time' => 'integer'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class, 'post_tag', 'post_id', 'tag_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-post.jpg');
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 160);
    }

    public function getReadingTimeAttribute($value)
    {
        if ($value) {
            return $value;
        }
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // 200 words per minute
    }

    // Mutators
    public function setSlugAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['slug'] = Str::slug($this->title);
        } else {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'draft' => 'secondary',
            'published' => 'success',
            'archived' => 'warning'
        ];

        $badge = $statuses[$this->status] ?? 'secondary';
        $labels = [
            'draft' => 'Bản nháp',
            'published' => 'Đã xuất bản',
            'archived' => 'Đã lưu trữ'
        ];

        return '<span class="badge bg-' . $badge . '">' . ($labels[$this->status] ?? $this->status) . '</span>';
    }
}
