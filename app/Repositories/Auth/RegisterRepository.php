<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterRepository
{
    /**
     * Xử lý đăng ký
     * @param array $data
     * @return User|null
     */
    public function register(array $data): ?User
    {
        $user = User::create([
            'name' => $data['name'] ?? $data['email'],
            'email' => $data['email'],
            'status' => 1,
            'password' => Hash::make($data['password']),
        ]);
        if ($user) {
            Auth::login($user);
        }
        return $user;
    }
}
