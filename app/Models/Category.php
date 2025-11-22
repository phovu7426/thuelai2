<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    // Tên bảng trong database
    protected $table = 'categories';

    // Các trường có thể gán dữ liệu hàng loạt
    protected $fillable = [
        'name',
        'code',
        'description',
        'slug',
        'parent_id',
        'status'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id')
            ->withDefault(['name' => 'N/A']);
    }

    // Định nghĩa mối quan hệ nếu cần
//    public function books()
//    {
//        return $this->hasMany(Books::class);
//    }
}
