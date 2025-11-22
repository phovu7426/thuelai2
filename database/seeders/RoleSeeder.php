<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'admin',
            'editor',
            'user',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(
                ['name' => $roleName, 'guard_name' => 'web'],
                ['title' => ucfirst($roleName), 'status' => 'active']
            );

            // Assign permissions based on role
            if ($roleName === 'admin') {
                // Admin có tất cả quyền
                $allPermissionNames = Permission::where('name', 'like', 'access_%')->pluck('name')->all();
                $role->syncPermissions($allPermissionNames);
            } elseif ($roleName === 'editor') {
                // Editor có quyền quản lý nội dung và một số quyền khác
                $editorPermissionNames = Permission::whereIn('name', [
                    'access_dashboard',
                    'access_slides',
                    'access_post-categories',
                    'access_posts',
                    'access_post-tags',
                    'access_driver_services',
                    'access_driver_testimonials',
                    'access_driver_contacts',
                ])->pluck('name')->all();
                $role->syncPermissions($editorPermissionNames);
            } else { // user
                // User chỉ có quyền xem dashboard và một số quyền cơ bản
                $userPermissionNames = Permission::whereIn('name', [
                    'access_dashboard',
                    'access_posts',
                ])->pluck('name')->all();
                $role->syncPermissions($userPermissionNames);
            }
        }
    }
}


