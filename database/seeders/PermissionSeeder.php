<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Danh sách quyền theo menu admin
        $permissions = [
            // Dashboard
            'access_dashboard' => 'Truy cập tổng quan',
            
            // Quản lý tài khoản
            'access_users' => 'Quản lý tài khoản',
            
            // Quản lý vai trò
            'access_roles' => 'Quản lý vai trò',
            
            // Quản lý quyền
            'access_permissions' => 'Quản lý quyền',
            
            // Quản lý slide
            'access_slides' => 'Quản lý slide',
            
            // Quản lý danh mục tin tức
            'access_post-categories' => 'Quản lý danh mục tin tức',
            
            // Quản lý tin tức
            'access_posts' => 'Quản lý tin tức',
            
            // Quản lý tags
            'access_post-tags' => 'Quản lý tags',
            
            // Driver Services
            'access_driver_services' => 'Quản lý dịch vụ lái xe',
            'access_driver_testimonials' => 'Quản lý đánh giá khách hàng',
            'access_driver_contacts' => 'Quản lý liên hệ lái xe',
            
            // Cấu hình hệ thống
    
        ];

        foreach ($permissions as $permissionName => $permissionTitle) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web'],
                [
                    'title' => $permissionTitle,
                    'is_default' => true,
                    'status' => 'active'
                ]
            );
        }
    }
}
