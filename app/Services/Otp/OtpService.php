<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Redis;

class OtpService
{
    /**
     * Xác thực xem OTP có đúng không
     * @param string $key
     * @param string|int $otp
     * @return array
     */
    public function verify(string $key, string|int $otp): array
    {
        if (!Redis::exists($key) || (($ttl = Redis::ttl($key)) && $ttl === -2)) {
            return ['success' => false, 'message' => 'Mã OTP đã hết hạn hoặc không tồn tại.'];
        }
        $return = ['success' => false, 'message' => 'OTP bị sai.'];
        if (!empty($otp) && $otp === Redis::get($key)) {
            $return['success'] = true;
            $return['message'] = 'Nhập OTP đúng.';
        }
        return $return;
    }
}
