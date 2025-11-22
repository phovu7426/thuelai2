<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\ContactInfo\UpdateRequest;
use App\Services\Admin\ContactInfoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactInfoController extends BaseController
{
    public function __construct(ContactInfoService $contactInfoService)
    {
        $this->service = $contactInfoService;
    }

    public function getService(): ContactInfoService
    {
        return $this->service;
    }

    /**
     * Hiển thị trang quản lý thông tin liên hệ (chỉ có 1 bản ghi)
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $contactInfo = $this->getService()->getFirstOrCreate();

        return view('admin.contact-info.index', compact('contactInfo'));
    }

    /**
     * Xử lý cập nhật thông tin liên hệ (chỉ có 1 bản ghi)
     * @param UpdateRequest $request
     * @return JsonResponse
     */
    public function store(UpdateRequest $request): JsonResponse
    {
        $result = $this->getService()->updateContactInfo($request->validated());

        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật thông tin liên hệ thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Lấy thông tin liên hệ để hiển thị trong form
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $contactInfo = $this->getService()->getFirstContactInfo();

        return response()->json([
            'success' => true,
            'data' => $contactInfo ?: []
        ]);
    }
}
