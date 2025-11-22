<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        PostCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::first() ?? User::factory()->create(['name' => 'Admin', 'email' => 'admin@example.com']);

        $categories = [
            ['name' => 'Mẹo lái xe', 'slug' => 'meo-lai-xe', 'description' => 'Các mẹo và kỹ năng lái xe an toàn', 'status' => 'active'],
            ['name' => 'Quy định giao thông', 'slug' => 'quy-dinh-giao-thong', 'description' => 'Cập nhật các quy định giao thông mới nhất', 'status' => 'active'],
            ['name' => 'Dịch vụ thuê tài xế', 'slug' => 'dich-vu-thue-tai-xe', 'description' => 'Thông tin về dịch vụ thuê tài xế', 'status' => 'active'],
            ['name' => 'Bảo dưỡng xe', 'slug' => 'bao-duong-xe', 'description' => 'Hướng dẫn bảo dưỡng và chăm sóc xe', 'status' => 'active'],
            ['name' => 'Tin tức ngành', 'slug' => 'tin-tuc-nganh', 'description' => 'Tin tức và xu hướng trong ngành vận tải', 'status' => 'active'],
        ];

        $createdCategories = [];
        foreach ($categories as $cat) {
            $createdCategories[$cat['slug']] = PostCategory::create($cat);
        }
        $this->command->info('Đã tạo ' . count($categories) . ' danh mục bài viết.');

        $posts = [
            // Mẹo lái xe
            ['title' => '10 Mẹo Lái Xe An Toàn Trong Thành Phố', 'excerpt' => 'Hướng dẫn chi tiết 10 mẹo lái xe an toàn...', 'content' => 'Nội dung chi tiết về 10 mẹo lái xe an toàn...', 'category_slug' => 'meo-lai-xe', 'image' => 'images/posts/safe-driving-tips.jpg', 'featured' => true],
            ['title' => 'Kỹ Năng Lái Xe Trong Điều Kiện Thời Tiết Xấu', 'excerpt' => 'Hướng dẫn kỹ năng lái xe an toàn trong các điều kiện...', 'content' => 'Nội dung chi tiết về lái xe thời tiết xấu...', 'category_slug' => 'meo-lai-xe', 'image' => 'images/posts/bad-weather-driving.jpg', 'featured' => true],
            ['title' => 'Cách Xử Lý Tình Huống Khẩn Cấp Khi Lái Xe', 'excerpt' => 'Hướng dẫn chi tiết cách xử lý các tình huống khẩn cấp...', 'content' => 'Nội dung chi tiết về xử lý tình huống khẩn cấp...', 'category_slug' => 'meo-lai-xe', 'image' => 'images/posts/emergency-situations.jpg', 'featured' => false],
            ['title' => 'Kinh Nghiệm Lái Xe Đường Dài Cho Người Mới', 'excerpt' => 'Những điều cần chuẩn bị và lưu ý khi lái xe đường dài...', 'content' => 'Nội dung chi tiết về kinh nghiệm lái xe đường dài...', 'category_slug' => 'meo-lai-xe', 'image' => 'images/posts/long-distance-driving.jpg', 'featured' => true],
            ['title' => 'Mẹo Tiết Kiệm Xăng Hiệu Quả Cho Tài Xế', 'excerpt' => 'Áp dụng những thói quen đơn giản để giảm chi phí nhiên liệu...', 'content' => 'Nội dung chi tiết về mẹo tiết kiệm xăng...', 'category_slug' => 'meo-lai-xe', 'image' => 'images/posts/fuel-saving-tips.jpg', 'featured' => false],

            // Quy định giao thông
            ['title' => 'Quy Định Giao Thông Mới Nhất 2024', 'excerpt' => 'Tổng hợp các quy định giao thông mới nhất năm 2024...', 'content' => 'Nội dung chi tiết về quy định giao thông 2024...', 'category_slug' => 'quy-dinh-giao-thong', 'image' => 'images/posts/traffic-regulations-2024.jpg', 'featured' => true],
            ['title' => 'Các Lỗi Vi Phạm Giao Thông Thường Gặp Và Mức Phạt', 'excerpt' => 'Danh sách các lỗi vi phạm phổ biến và mức phạt tương ứng...', 'content' => 'Nội dung chi tiết về các lỗi vi phạm và mức phạt...', 'category_slug' => 'quy-dinh-giao-thong', 'image' => 'images/posts/traffic-fines.jpg', 'featured' => false],
            ['title' => 'Tìm Hiểu Về Biển Báo Giao Thông Đường Bộ Việt Nam', 'excerpt' => 'Ý nghĩa của các loại biển báo giao thông quan trọng...', 'content' => 'Nội dung chi tiết về các loại biển báo giao thông...', 'category_slug' => 'quy-dinh-giao-thong', 'image' => 'images/posts/traffic-signs.jpg', 'featured' => false],

            // Dịch vụ thuê tài xế
            ['title' => 'Lợi Ích Của Việc Thuê Tài Xế Riêng', 'excerpt' => 'Khám phá những lợi ích tuyệt vời khi sử dụng dịch vụ...', 'content' => 'Nội dung chi tiết về lợi ích thuê tài xế...', 'category_slug' => 'dich-vu-thue-tai-xe', 'image' => 'images/posts/private-driver-benefits.jpg', 'featured' => true],
            ['title' => 'Cách Chọn Tài Xế Thuê Lái Uy Tín', 'excerpt' => 'Hướng dẫn chi tiết cách chọn tài xế thuê lái uy tín...', 'content' => 'Nội dung chi tiết về cách chọn tài xế...', 'category_slug' => 'dich-vu-thue-tai-xe', 'image' => 'images/posts/choose-reliable-driver.jpg', 'featured' => false],
            ['title' => 'Bảng Giá Dịch Vụ Thuê Tài Xế Theo Giờ và Theo Ngày', 'excerpt' => 'Tham khảo bảng giá dịch vụ thuê tài xế mới nhất...', 'content' => 'Nội dung chi tiết về bảng giá dịch vụ...', 'category_slug' => 'dich-vu-thue-tai-xe', 'image' => 'images/posts/driver-pricing.jpg', 'featured' => true],

            // Bảo dưỡng xe
            ['title' => 'Bảo Dưỡng Xe Định Kỳ - Điều Cần Biết', 'excerpt' => 'Hướng dẫn toàn diện về bảo dưỡng xe định kỳ...', 'content' => 'Nội dung chi tiết về bảo dưỡng xe...', 'category_slug' => 'bao-duong-xe', 'image' => 'images/posts/car-maintenance.jpg', 'featured' => true],
            ['title' => '5 Hạng Mục Cần Kiểm Tra Trước Mỗi Chuyến Đi Xa', 'excerpt' => 'Đảm bảo an toàn cho chuyến đi của bạn với 5 bước kiểm tra...', 'content' => 'Nội dung chi tiết về kiểm tra xe trước chuyến đi...', 'category_slug' => 'bao-duong-xe', 'image' => 'images/posts/pre-trip-check.jpg', 'featured' => false],
            ['title' => 'Khi Nào Cần Thay Lốp Xe Ô Tô?', 'excerpt' => 'Dấu hiệu nhận biết lốp xe đã mòn và cần được thay thế...', 'content' => 'Nội dung chi tiết về thời điểm thay lốp xe...', 'category_slug' => 'bao-duong-xe', 'image' => 'images/posts/tire-replacement.jpg', 'featured' => false],

            // Tin tức ngành
            ['title' => 'Xu Hướng Dịch Vụ Thuê Tài Xế 2024', 'excerpt' => 'Phân tích xu hướng phát triển của thị trường dịch vụ...', 'content' => 'Nội dung chi tiết về xu hướng ngành...', 'category_slug' => 'tin-tuc-nganh', 'image' => 'images/posts/driver-service-trends.jpg', 'featured' => true],
            ['title' => 'Top 5 Ứng Dụng Hữu Ích Cho Tài Xế Việt', 'excerpt' => 'Những ứng dụng không thể thiếu trên điện thoại của mỗi tài xế...', 'content' => 'Nội dung chi tiết về các ứng dụng hữu ích...', 'category_slug' => 'tin-tuc-nganh', 'image' => 'images/posts/driver-apps.jpg', 'featured' => false],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'image' => $postData['image'],
                'category_id' => $createdCategories[$postData['category_slug']]->id,
                'author_id' => $user->id,
                'status' => 'published',
                'featured' => $postData['featured'],
                'views' => rand(100, 1000),
                'published_at' => now()->subDays(rand(1, 365)),
            ]);
        }

        $this->command->info('Đã tạo ' . count($posts) . ' bài viết mẫu.');
    }
}
