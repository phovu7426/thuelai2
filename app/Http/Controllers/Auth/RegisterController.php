<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends BaseController
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    /**
     * Hàm gọi giao diện đăng ký
     * @return View
     */
    public function index(): View
    {
        return view('auth.register');
    }

    /**
     * Hàm gửi OTP quên mật khẩu về email
     * @param Request $request
     * @return JsonResponse
     */
    public function sendOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        return response()->json($this->registerService->sendOtp($request->email ?? ''));
    }

    /**
     * Hàm xử lý đăng ký
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->all();
        return response()->json($this->registerService->register($data));
    }
}
