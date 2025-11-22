<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DriverService;

class DriverServiceImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cập nhật ảnh cho các dịch vụ hiện có
        $services = [
            'lai-xe-theo-gio' => [
                'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&h=600&fit=crop&crop=face',
                'icon' => 'https://cdn-icons-png.flaticon.com/128/2089/2089676.png'
            ],
            'lai-xe-theo-chuyen' => [
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&h=600&fit=crop',
                'icon' => 'https://cdn-icons-png.flaticon.com/128/2089/2089676.png'
            ],
            'lai-xe-du-lich' => [
                'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800&h=600&fit=crop',
                'icon' => 'https://cdn-icons-png.flaticon.com/128/2089/2089676.png'
            ],
            'lai-xe-dua-don-san-bay' => [
                'image' => 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800&h=600&fit=crop',
                'icon' => 'https://cdn-icons-png.flaticon.com/128/2089/2089676.png'
            ]
        ];

        foreach ($services as $slug => $data) {
            $service = DriverService::where('slug', $slug)->first();
            if ($service) {
                $service->update([
                    'image' => $data['image'],
                    'icon' => $data['icon']
                ]);
                $this->command->info("Updated images for service: {$service->name}");
            }
        }
    }
}
