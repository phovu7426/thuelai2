<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Users\Profiles\UpdateRequest;
use App\Services\Admin\Users\ProfileService;
use App\Services\Admin\Users\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class ProfileController extends BaseController
{
    public UserService $userService;
    public function __construct(ProfileService $profileService, UserService $userService)
    {
        $this->service = $profileService;
        $this->userService = $userService;
    }

    public function getService(): ProfileService
    {
        return $this->service;
    }

    /**
     * Hiển thị form chỉnh sửa hồ sơ
     * @param $user_id
     * @return View|Application|Factory
     */
    public function edit($user_id): View|Application|Factory
    {
        $profile = $this->getService()->findByUserId($user_id);
        $user = $this->userService->findById($user_id);
        return view('admin.users.profiles.edit', compact('profile', 'user'));
    }

    /**
     * Xử lý chỉnh sửa hồ sơ
     * @param UpdateRequest $request
     * @param $user_id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, $user_id): RedirectResponse
    {
        $return = $this->getService()->update($user_id, $request->all());
        if (!empty($return['success'])) {
            return redirect()->route('admin.users.index')
                ->with('success', $return['message'] ?? 'Cập nhật hồ sơ thành công.');
        }
        return redirect()->route('admin.users.index')
            ->with('fail', $return['message'] ?? 'Cập nhật hồ sơ thất bại.');
    }
}
