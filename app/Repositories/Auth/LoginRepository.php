<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRepository
{
    /**
     * Xử lý đăng nhập
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function login(array $credentials, bool $remember): bool
    {
        return Auth::attempt($credentials, $remember);
    }

    /**
     * Xử lý đăng xuất
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
