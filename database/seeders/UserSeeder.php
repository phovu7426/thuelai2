<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions to ensure role assignment works
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        // Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );
        $admin->assignRole('admin');

        // Demo editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );
        $editor->assignRole('editor');

        // Demo user
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]
        );
        $user->assignRole('user');
    }
}


