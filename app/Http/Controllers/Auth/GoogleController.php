<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Services\Auth\RegisterService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class GoogleController extends BaseController
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * Hiển thị form đăng nhập với google
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
     */
    public function redirect(): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Hàm để google gọi lại
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            if ($user = User::where('email', $googleUser->email)->first()) {
                Auth::login($user);
                $result['success'] = true;
                $result['message'] = 'Đăng nhập google thành công';
            } else {
                $data = [
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt('12345678'),
                ];
                $result = $this->registerService->register($data);
            }
            if ($result['success']) {
                return redirect()->route('dashboard')->with('success', $result['message']);
            }
            return redirect()->route('registerForm')->with('error', $result['message']);
        } catch (Exception $e) {
            return redirect()->route('login.index')->with('error', 'Đăng nhập Google thất bại!');
        }
    }
}
