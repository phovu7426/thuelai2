<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DriverService;
use App\Models\ContactInfo;

class UpdateServiceImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:update-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update service images and pricing background image';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating service images...');

        // Cập nhật ảnh cho các dịch vụ hiện có
        $services = [
            'lai-xe-theo-gio' => [
                'image' => 'https://images.unsplash.com/photo-1550355291-bbee04a92027?q=80&w=1600&auto=format&fit=crop',
                'icon' => 'fas fa-clock'
            ],
            'lai-xe-theo-chuyen' => [
                'image' => 'https://images.unsplash.com/photo-1493238792000-8113da705763?q=80&w=1600&auto=format&fit=crop',
                'icon' => 'fas fa-route'
            ],
            'lai-xe-du-lich' => [
                'image' => 'https://images.unsplash.com/photo-1517673132405-a56a62b18caf?q=80&w=1600&auto=format&fit=crop',
                'icon' => 'fas fa-mountain'
            ],
            'lai-xe-dua-don-san-bay' => [
                'image' => 'https://images.unsplash.com/photo-1508921912186-1d1a45ebb3c1?q=80&w=1600&auto=format&fit=crop',
                'icon' => 'fas fa-plane'
            ]
        ];

        foreach ($services as $slug => $data) {
            $service = DriverService::where('slug', $slug)->first();
            if ($service) {
                $service->update([
                    'image' => $data['image'],
                    'icon' => $data['icon']
                ]);
                $this->info("✅ Updated images for service: {$service->name}");
            } else {
                $this->warn("⚠️  Service not found: {$slug}");
            }
        }

        $this->info('🎉 Service images updated successfully!');
        
        // Cập nhật ảnh nền bảng giá
        $this->updatePricingBackgroundImage();
        
        $this->info('Hoàn thành cập nhật tất cả ảnh!');
    }
    
    private function updatePricingBackgroundImage()
    {
        $contactInfo = ContactInfo::first();
        
        if ($contactInfo) {
            // Ảnh nền bảng giá phù hợp - xe hơi, đường xá, hoặc thiết kế hiện đại
            $pricingBackgroundImage = 'https://images.unsplash.com/photo-1549924231-f129b911e442?q=80&w=1600&auto=format&fit=crop';
            
            $contactInfo->update([
                'pricing_background_image' => $pricingBackgroundImage
            ]);
            
            $this->info("✅ Đã cập nhật ảnh nền bảng giá: {$pricingBackgroundImage}");
        } else {
            $this->warn('⚠️  Không tìm thấy thông tin liên hệ để cập nhật ảnh nền bảng giá');
        }
    }
}
