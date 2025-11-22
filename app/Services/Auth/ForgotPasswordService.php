<?php

namespace App\Services\Auth;

use App\Mail\Auth\ForgotPassword;
use App\Repositories\User\Users\UserRepository;
use App\Services\Otp\OtpService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Throwable;

class ForgotPasswordService
{
    protected UserRepository $userRepository;
    protected OtpService $otpService;
    public static string $key = 'ForgotPassword:email:';

    public function __construct(UserRepository $userRepository, OtpService $otpService)
    {
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
            $user = $this->userRepository->findByEmail($email);
            if(!$user) {
                $return['message'] = 'Email này chưa có tài khoản được tạo';
            } else {
                $otp = rand(100000, 999999);
                Redis::setex(static::$key . $email, 600, $otp);
                $data = ['otp' => $otp];
                if (Mail::to($email)->send(new ForgotPassword($data))) {
                    $return['success'] = true;
                    $return['message'] = 'Gửi otp về email thành công';
                }
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
     * Hàm đặt lại mật khẩu
     * @param array $data
     * @return array
     */
    public function resetPassword(array $data): array
    {
        try {
            $return = ['success' => false, 'message' => 'Đặt lại mật khẩu thất bại'];
            if (!empty($data['email'])
                && !empty($data['password'])
                && !empty($data['otp'])
                && ($checkOtp = $this->otpService->verify(static::$key . $data['email'], $data['otp']))
                && !empty($checkOtp['success'])
            ) {
                $updateData = [
                    'password' => Hash::make($data['password']),
                ];
                if (($user = $this->userRepository->findByEmail($data['email']))
                    && $this->userRepository->update($user, $updateData)
                ) {
                    Redis::del(static::$key . $data['email']);
                    $return['success'] = true;
                    $return['message'] = 'Đặt lại mật khẩu thành công';
                }
            } else {
                $return['message'] = $checkOtp['message'] ?? $return['message'];
            }
            return $return;
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => 'Đặt lại mật khẩu thất bại',
                'error' => $exception->getMessage()
            ];
        }
    }

}

