<?php

namespace App\Permissions;

class Permissions
{
    public const MODULES = [
        'users' => 'Quản lý tài khoản',
        'books' => 'Quản lý sách',
        'payments' => 'Quản lý thanh toán',
    ];

    /**
     * Hàm lấy danh sách quyền
     * @return array
     */
    public static function getPermissions(): array
    {
        $permissions = [];
        foreach (static::MODULES as $module => $name) {
            $permissions[$module] = [
                'view' => "view {$module}",
                'create' => "create {$module}",
                'edit' => "edit {$module}",
                'delete' => "delete {$module}",
                'manage' => "manage {$module}",
            ];
        }
        return $permissions;
    }

    /**
     * Hàm lấy tất cả quyền
     * @return array
     */
    public static function all(): array
    {
        return collect(static::getPermissions())->flatten()->all();
    }
}
