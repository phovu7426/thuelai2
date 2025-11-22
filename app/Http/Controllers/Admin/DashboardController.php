<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverService;
use App\Models\DriverContact;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Thống kê người dùng
            $totalUsers = User::count();
            $newUsers = User::where('created_at', '>=', now()->subDays(7))->count();
            
            // Thống kê dịch vụ lái xe
            $totalServices = DriverService::count();
            $newServices = DriverService::where('created_at', '>=', now()->subDays(7))->count();
            $activeServices = DriverService::where('status', 1)->count();
            
            // Thống kê liên hệ
            $totalContacts = DriverContact::count();
            $newContacts = DriverContact::where('created_at', '>=', now()->subDays(7))->count();
            $unreadContacts = DriverContact::where('status', 'unread')->count();
            
            // Thống kê đánh giá
            $totalTestimonials = Testimonial::count();
            $newTestimonials = Testimonial::where('created_at', '>=', now()->subDays(7))->count();
            $featuredTestimonials = Testimonial::where('is_featured', 1)->count();
            
            // Thống kê theo tháng (6 tháng gần nhất)
            $monthlyStats = $this->getMonthlyStats();
            
            // Thống kê dịch vụ theo trạng thái
            $servicesByStatus = $this->getServicesByStatus();
            
            // Thống kê liên hệ theo trạng thái
            $contactsByStatus = $this->getContactsByStatus();
            
            // Hoạt động gần đây
            $recentServices = DriverService::latest()->take(5)->get();
            $recentContacts = DriverContact::latest()->take(5)->get();
            $recentTestimonials = Testimonial::latest()->take(5)->get();
            
        } catch (\Exception $e) {
            // Nếu có lỗi, đặt giá trị mặc định
            $totalUsers = 0;
            $newUsers = 0;
            $totalServices = 0;
            $newServices = 0;
            $activeServices = 0;
            $totalContacts = 0;
            $newContacts = 0;
            $unreadContacts = 0;
            $totalTestimonials = 0;
            $newTestimonials = 0;
            $featuredTestimonials = 0;
            $monthlyStats = ['months' => [], 'services' => [], 'contacts' => []];
            $servicesByStatus = ['labels' => [], 'data' => []];
            $contactsByStatus = ['labels' => [], 'data' => []];
            $recentServices = collect([]);
            $recentContacts = collect([]);
            $recentTestimonials = collect([]);
        }
        
        return view('admin.dashboard', compact(
            'totalUsers', 'newUsers',
            'totalServices', 'newServices', 'activeServices',
            'totalContacts', 'newContacts', 'unreadContacts',
            'totalTestimonials', 'newTestimonials', 'featuredTestimonials',
            'monthlyStats', 'servicesByStatus', 'contactsByStatus',
            'recentServices', 'recentContacts', 'recentTestimonials'
        ));
    }
    
    /**
     * Lấy thống kê theo tháng (6 tháng gần nhất)
     */
    private function getMonthlyStats()
    {
        try {
            $months = collect([]);
            $services = collect([]);
            $contacts = collect([]);
            
            // Lấy dữ liệu 6 tháng gần nhất
            for ($i = 5; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $monthName = $date->format('m/Y');
                
                $months->push($monthName);
                
                // Đếm dịch vụ mới trong tháng
                $monthlyServices = DriverService::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                
                // Đếm liên hệ mới trong tháng
                $monthlyContacts = DriverContact::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count();
                
                $services->push($monthlyServices);
                $contacts->push($monthlyContacts);
            }
            
            return [
                'months' => $months,
                'services' => $services,
                'contacts' => $contacts
            ];
        } catch (\Exception $e) {
            return [
                'months' => ['01/2024', '02/2024', '03/2024', '04/2024', '05/2024', '06/2024'],
                'services' => [0, 0, 0, 0, 0, 0],
                'contacts' => [0, 0, 0, 0, 0, 0]
            ];
        }
    }
    
    /**
     * Lấy thống kê dịch vụ theo trạng thái
     */
    private function getServicesByStatus()
    {
        try {
            $activeServices = DriverService::where('status', 1)->count();
            $inactiveServices = DriverService::where('status', 0)->count();
            
            return [
                'labels' => ['Hoạt động', 'Không hoạt động'],
                'data' => [$activeServices, $inactiveServices]
            ];
        } catch (\Exception $e) {
            return [
                'labels' => ['Hoạt động', 'Không hoạt động'],
                'data' => [0, 0]
            ];
        }
    }
    
    /**
     * Lấy thống kê liên hệ theo trạng thái
     */
    private function getContactsByStatus()
    {
        try {
            $readContacts = DriverContact::whereIn('status', ['read', 'replied', 'closed'])->count();
            $unreadContacts = DriverContact::where('status', 'unread')->count();
            
            return [
                'labels' => ['Đã đọc', 'Chưa đọc'],
                'data' => [$readContacts, $unreadContacts]
            ];
        } catch (\Exception $e) {
            return [
                'labels' => ['Đã đọc', 'Chưa đọc'],
                'data' => [0, 0]
            ];
        }
    }
} 