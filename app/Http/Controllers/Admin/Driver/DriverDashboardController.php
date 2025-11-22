<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Services\Admin\Driver\DriverDashboardService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverDashboardController extends BaseController
{
    protected DriverDashboardService $dashboardService;

    public function __construct(DriverDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Display the driver service dashboard.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        // Thống kê tổng quan
        $stats = $this->dashboardService->getStats();

        // Đơn hàng gần đây - đã loại bỏ
        $recent_orders = collect([]);

        // Dịch vụ nổi bật
        $featured_services = $this->dashboardService->getFeaturedServices(5);

        // Đánh giá gần đây
        $recent_testimonials = $this->dashboardService->getRecentTestimonials(5);

        // Thống kê theo tháng (6 tháng gần nhất)
        $monthly_stats = $this->dashboardService->getMonthlyStats();

        return view('admin.driver.dashboard', compact(
            'stats',
            'recent_orders',
            'featured_services',
            'recent_testimonials',
            'monthly_stats'
        ));
    }

    /**
     * Lấy dữ liệu cho biểu đồ
     * @param Request $request
     * @return JsonResponse
     */
    public function getChartData(Request $request): JsonResponse
    {
        $type = $request->get('type', 'orders');

        switch ($type) {
            case 'orders':
                $data = $this->dashboardService->getOrderChartData();
                break;
            case 'revenue':
                $data = $this->dashboardService->getRevenueChartData();
                break;
            case 'services':
                $data = $this->dashboardService->getServiceChartData();
                break;
            default:
                $data = $this->dashboardService->getOrderChartData();
        }

        return response()->json($data);
    }

    /**
     * Lấy thống kê real-time
     * @return JsonResponse
     */
    public function getRealTimeStats(): JsonResponse
    {
        $stats = $this->dashboardService->getRealTimeStats();
        return response()->json($stats);
    }
}
