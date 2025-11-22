<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\DriverService;
use Illuminate\Support\Str;

class DriverServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Xóa dữ liệu cũ
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DriverService::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $services = [
            [
                'name' => 'Lái xe theo giờ',
                'slug' => Str::slug('Lái xe theo giờ'),
                'description' => 'Dịch vụ cung cấp tài xế theo giờ, phù hợp cho các chuyến đi ngắn hoặc khi bạn cần tài xế trong một khoảng thời gian nhất định.',
                'short_description' => 'Tài xế chuyên nghiệp, phục vụ theo giờ.',
                'image' => null,
                'icon' => null,
                'price_per_hour' => 150000,
                'price_per_trip' => null,
                'is_featured' => true,
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Lái xe theo chuyến',
                'slug' => Str::slug('Lái xe theo chuyến'),
                'description' => 'Dịch vụ cung cấp tài xế cho cả chuyến đi, không giới hạn thời gian. Giá cả được thỏa thuận trước.',
                'short_description' => 'Tài xế cho cả chuyến đi, giá cố định.',
                'image' => null,
                'icon' => null,
                'price_per_hour' => null,
                'price_per_trip' => 500000,
                'is_featured' => true,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Lái xe du lịch',
                'slug' => Str::slug('Lái xe du lịch'),
                'description' => 'Tài xế có kinh nghiệm lái xe đường dài, am hiểu các tuyến điểm du lịch. Phù hợp cho các gia đình hoặc nhóm bạn đi du lịch.',
                'short_description' => 'Tài xế du lịch, am hiểu các tuyến điểm.',
                'image' => null,
                'icon' => null,
                'price_per_hour' => null,
                'price_per_trip' => 1200000,
                'is_featured' => false,
                'status' => true,
                'sort_order' => 3,
            ],
             [
                'name' => 'Lái xe đưa đón sân bay',
                'slug' => Str::slug('Lái xe đưa đón sân bay'),
                'description' => 'Dịch vụ đưa đón sân bay chuyên nghiệp, đúng giờ và an toàn.',
                'short_description' => 'Đưa đón sân bay chuyên nghiệp.',
                'image' => null,
                'icon' => null,
                'price_per_hour' => null,
                'price_per_trip' => 300000,
                'is_featured' => true,
                'status' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            DriverService::create($service);
        }
    }
}

