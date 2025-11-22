<?php

namespace App\Services\Auth;

use App\Mail\Auth\Register;
use App\Repositories\Auth\RegisterRepository;
use App\Repositories\User\Users\UserRepository;
use App\Services\Otp\OtpService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Throwable;

class RegisterService
{
    protected RegisterRepository $registerRepository;
    protected UserRepository $userRepository;
    protected OtpService $otpService;
    public static string $key = 'Register:email:';

    public function __construct(RegisterRepository $registerRepository, UserRepository $userRepository, OtpService $otpService)
    {
        $this->registerRepository = $registerRepository;
        $this->userRepository = $userRepository;
        $this->otpService = $otpService;
    }

    /**
     * Hàm gửi OTP quên mật khẩu về email
     * @param string $email
     * @return array
     */
    public function sendOtp(string $email): array
    {
        try {
            $return = ['success' => false, 'message' => 'Gửi otp về email thất bại'];
            $otp = rand(100000, 999999);
            Redis::setex(static::$key . $email, 600, $otp);
            $data = ['otp' => $otp];
            if (Mail::to($email)->send(new Register($data))) {
                $return['success'] = true;
                $return['message'] = 'Gửi otp về email thành công';
            }
            return $return;
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Gửi otp về email thất bại!',
                'error' => $exception->getMessage()
            ];
        }
    }

    /**
     * Service xử lý đăng ký
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        try {
            if (empty($data['email']) || empty($data['password']) || empty($data['otp'])) {
                return ['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.'];
            }
            $return = ['success' => false, 'message' => 'Đăng ký thất bại. Vui lòng thử lại!'];
            if (($checkOtp = $this->otpService->verify(static::$key . $data['email'], $data['otp']))
                && !empty($checkOtp['success'])
                && $this->registerRepository->register($data)
            ) {
                $return['success'] = true;
                $return['message'] = 'Đăng ký thành công!';
                Redis::del(static::$key . $data['email']);
            } else {
                $return['message'] = $checkOtp['message'] ?? $return['message'];
            }
            return $return;
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Đăng ký thất bại. Vui lòng thử lại!',
                'error' => $exception->getMessage()
            ];
        }
    }
}

