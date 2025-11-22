<?php

namespace App\Services\Auth;

use App\Repositories\Auth\LoginRepository;
use App\Repositories\User\Users\UserRepository;

class LoginService
{
    protected LoginRepository $loginRepository;
    protected UserRepository $userRepository;

    public function __construct(LoginRepository $loginRepository, UserRepository $userRepository)
    {
        $this->loginRepository = $loginRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Service xử lý đăng nhập
     * @param array $credentials
     * @param bool $remember
     * @return array
     */
    public function login(array $credentials, bool $remember): array
    {
        if (empty($credentials['email']) || empty($credentials['password'])) {
            return ['success' => false, 'message' => 'Email và mật khẩu không được để trống.'];
        }
        $return = ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng.'];
        if (($user = $this->userRepository->findByEmail($credentials['email']))
            && !empty($user->is_blocked)
        ) {
            $return['message'] = 'Tài khoản này đang bị khóa. Vui lòng liên hệ quản trị viên.';
            return $return;
        }
        $data = ['email' => $credentials['email'], 'password' => $credentials['password']];
        if ($this->loginRepository->login($data, $remember)) {
            $user = auth()->user();
            $redirectUrl = route('driver.home'); // Default redirect for non-admins
            if ($user->hasRole('admin')) { // Assuming admin role is named 'admin'
                $redirectUrl = route('admin.index');
            }
            $return = [
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'redirect' => $redirectUrl
            ];
        }
        return $return;
    }

    /**
     * Service xử lý đăng xuất
     * @return void
     */
    public function logout(): void
    {
        $this->loginRepository->logout();
    }
}

