<?php

namespace App\Permissions;

class UserPermissions
{
    public const VIEW = 'view users';
    public const CREATE = 'create users';
    public const EDIT = 'edit users';
    public const DELETE = 'delete users';
    public const MANAGE = 'manage users';

    public static function all(): array
    {
        return [
            static::VIEW,
            static::CREATE,
            static::EDIT,
            static::DELETE,
            static::MANAGE,
        ];
    }
}
