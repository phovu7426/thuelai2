<?php

namespace App\Services\Admin\Driver;

use App\Models\DriverService;
use App\Models\Testimonial;
use App\Models\DriverContact;
use Illuminate\Support\Facades\DB;

class DriverDashboardService
{
    /**
     * Lấy thống kê tổng quan
     * @return array
     */
    public function getStats(): array
    {
        return [
            'total_services' => DriverService::count(),
            'active_services' => DriverService::where('status', true)->count(),
            'featured_services' => DriverService::where('is_featured', true)->count(),
            'total_testimonials' => Testimonial::count(),
            'active_testimonials' => Testimonial::where('status', true)->count(),
            'featured_testimonials' => Testimonial::where('is_featured', true)->count(),
        ];
    }

    /**
     * Lấy dịch vụ nổi bật
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFeaturedServices(int $limit = 5)
    {
        return DriverService::where('is_featured', true)
            ->where('status', true)
            ->orderBy('sort_order', 'asc')
            ->take($limit)
            ->get();
    }

    /**
     * Lấy đánh giá gần đây
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentTestimonials(int $limit = 5)
    {
        return Testimonial::where('status', true)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    /**
     * Lấy thống kê theo tháng
     * @return array
     */
    public function getMonthlyStats(): array
    {
        $months = [];
        $order_counts = [];
        $revenue_data = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month_name = $date->format('M Y');
            $months[] = $month_name;

            // Đếm đơn hàng theo tháng - đã loại bỏ
            $order_counts[] = 0;

            // Tính doanh thu theo tháng - đã loại bỏ
            $revenue_data[] = 0;
        }

        return [
            'months' => $months,
            'order_counts' => $order_counts,
            'revenue_data' => $revenue_data
        ];
    }

    /**
     * Lấy dữ liệu biểu đồ đơn hàng
     * @return array
     */
    public function getOrderChartData(): array
    {
        $statuses = ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'];
        $data = [];

        foreach ($statuses as $status) {
            $data[] = [
                'status' => $status,
                'count' => 0
            ];
        }

        return $data;
    }

    /**
     * Lấy dữ liệu biểu đồ doanh thu
     * @return array
     */
    public function getRevenueChartData(): array
    {
        $months = [];
        $revenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            $revenue[] = 0;
        }

        return [
            'labels' => $months,
            'data' => $revenue
        ];
    }

    /**
     * Lấy dữ liệu biểu đồ dịch vụ
     * @return array
     */
    public function getServiceChartData(): array
    {
        $services = DriverService::orderBy('name', 'asc')
            ->take(10)
            ->get();

        return [
            'labels' => $services->pluck('name')->toArray(),
            'data' => array_fill(0, $services->count(), 0)
        ];
    }

    /**
     * Lấy thống kê real-time
     * @return array
     */
    public function getRealTimeStats(): array
    {
        return [
            'today_orders' => 0,
            'today_revenue' => 0,
            'pending_orders' => 0,
            'unread_contacts' => DriverContact::where('status', 'unread')->count(),
        ];
    }
}


