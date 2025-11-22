<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\Testimonial\StoreRequest;
use App\Http\Requests\Admin\Driver\Testimonial\UpdateRequest;
use App\Models\Testimonial;
use App\Services\Admin\Driver\TestimonialService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends BaseController
{
    public function __construct(TestimonialService $testimonialService)
    {
        $this->service = $testimonialService;
    }

    /**
     * Lấy service instance
     * @return TestimonialService
     */
    public function getService(): TestimonialService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách đánh giá
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $testimonials = $this->getService()->getList($filters, $options);
        
        return view('admin.driver.testimonials.index', compact('testimonials', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo đánh giá
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.driver.testimonials.create');
    }

    /**
     * Xử lý tạo đánh giá
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo đánh giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết đánh giá
     * @param Testimonial $testimonial
     * @return View|Application|Factory
     */
    public function show(Testimonial $testimonial): View|Application|Factory
    {
        return view('admin.driver.testimonials.show', compact('testimonial'));
    }

    /**
     * Hiển thị form chỉnh sửa đánh giá
     * @param Testimonial $testimonial
     * @return View|Application|Factory
     */
    public function edit(Testimonial $testimonial): View|Application|Factory
    {
        return view('admin.driver.testimonials.edit', compact('testimonial'));
    }

    /**
     * Xử lý chỉnh sửa đánh giá
     * @param UpdateRequest $request
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Testimonial $testimonial): JsonResponse
    {
        $result = $this->getService()->update($testimonial->id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật đánh giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa đánh giá
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $result = $this->getService()->delete($testimonial->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa đánh giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái đánh giá
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function toggleStatus(Testimonial $testimonial): JsonResponse
    {
        $result = $this->getService()->toggleStatus($testimonial->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái featured
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function toggleFeatured(Testimonial $testimonial): JsonResponse
    {
        $result = $this->getService()->toggleFeatured($testimonial->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái nổi bật thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Cập nhật thứ tự sắp xếp
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $request->validate([
            'testimonials' => 'required|array',
            'testimonials.*.id' => 'required|exists:testimonials,id',
            'testimonials.*.sort_order' => 'required|integer|min:0'
        ]);

        $result = $this->getService()->updateOrder($request->testimonials);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật thứ tự thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Lọc đánh giá theo trạng thái
     * @param Request $request
     * @return JsonResponse
     */
    public function filterByStatus(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $filters = ['status' => $status];
        $options = $this->getOptions($request->all());
        
        $testimonials = $this->getService()->getList($filters, $options);
        
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Tìm kiếm đánh giá
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $filters = ['search' => $search];
        $options = $this->getOptions($request->all());
        
        $testimonials = $this->getService()->getList($filters, $options);
        
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * Bulk actions
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'exists:testimonials,id'
        ]);

        $result = $this->getService()->bulkAction($request->action, $request->ids);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thực hiện hành động thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Lấy thông tin đánh giá cho modal
     * @param Testimonial $testimonial
     * @return JsonResponse
     */
    public function getTestimonialInfo(Testimonial $testimonial): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $testimonial->id,
                'customer_name' => $testimonial->customer_name,
                'customer_position' => $testimonial->customer_position,
                'rating' => $testimonial->rating,
                'content' => $testimonial->content,
                'image' => $testimonial->image,
                'status' => $testimonial->status,
                'featured' => $testimonial->featured,
                'created_at' => $testimonial->created_at,
                'updated_at' => $testimonial->updated_at
            ]
        ]);
    }
}
