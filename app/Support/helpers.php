<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('isActive')) {
    function isActive(array|string $patterns, string $output = 'active'): string
    {
        foreach ((array) $patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return $output;
            }
        }
        return '';
    }
}

if (!function_exists('get_image_url')) {
    /**
     * Lấy URL của ảnh, nếu không tồn tại thì trả về ảnh mặc định
     * 
     * @param string|null $path Đường dẫn của ảnh trong storage
     * @param string $default Đường dẫn của ảnh mặc định
     * @return string URL của ảnh
     */
    function get_image_url($path = null, $default = 'images/default/default_image.png')
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }
        
        return asset($default);
    }
}
