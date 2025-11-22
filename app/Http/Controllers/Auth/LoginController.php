<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends BaseController
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Hàm gọi giao diện đăng nhập
     * @return RedirectResponse|View
     */
    public function index(): RedirectResponse|View
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) { // Assuming admin role is named 'admin'
                return redirect()->route('admin.index');
            }
            return redirect()->route('driver.home'); // Redirect non-admins to the home page
        }
        return view('auth.login');
    }

    /**
     * Hàm xử lý đăng nhập
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->all();
        $remember = $request->has('remember');
        return response()->json($this->loginService->login($credentials, $remember));
    }

    /**
     * Hàm xử lý đăng xuất
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->loginService->logout();
        Session::invalidate();
        return redirect()->route('login.index')->with('success', 'Bạn đã đăng xuất thành công.');
    }
}
