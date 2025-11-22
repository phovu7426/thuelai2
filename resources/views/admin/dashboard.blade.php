@extends('admin.layouts.main')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card bg-gradient-primary text-white rounded-3 p-4 shadow-sm">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mb-2">Chào mừng trở lại! 👋</h2>
                        <p class="mb-0 opacity-75">Đây là tổng quan về hoạt động của hệ thống dịch vụ lái xe</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="welcome-icon">
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-users text-primary fa-2x"></i>
                        </div>
                        <div class="stat-trend text-success">
                            <i class="fas fa-arrow-up"></i>
                            <small>{{ number_format(($newUsers / max(1, $totalUsers)) * 100, 1) }}%</small>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ number_format($totalUsers) }}</h3>
                    <p class="stat-label text-muted mb-2">Tổng người dùng</p>
                    <div class="progress stat-progress" style="height: 6px;">
                        <div class="progress-bar bg-primary rounded-pill" style="width: {{ min(100, ($newUsers / max(1, $totalUsers)) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">{{ $newUsers }} người dùng mới trong 7 ngày</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-car text-success fa-2x"></i>
                        </div>
                        <div class="stat-trend text-success">
                            <i class="fas fa-arrow-up"></i>
                            <small>{{ number_format(($activeServices / max(1, $totalServices)) * 100, 1) }}%</small>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ number_format($totalServices) }}</h3>
                    <p class="stat-label text-muted mb-2">Dịch vụ lái xe</p>
                    <div class="progress stat-progress" style="height: 6px;">
                        <div class="progress-bar bg-success rounded-pill" style="width: {{ min(100, ($activeServices / max(1, $totalServices)) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">{{ $activeServices }} dịch vụ đang hoạt động</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-envelope text-warning fa-2x"></i>
                        </div>
                        <div class="stat-trend text-warning">
                            <i class="fas fa-arrow-up"></i>
                            <small>{{ number_format(($unreadContacts / max(1, $totalContacts)) * 100, 1) }}%</small>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ number_format($totalContacts) }}</h3>
                    <p class="stat-label text-muted mb-2">Liên hệ</p>
                    <div class="progress stat-progress" style="height: 6px;">
                        <div class="progress-bar bg-warning rounded-pill" style="width: {{ min(100, ($unreadContacts / max(1, $totalContacts)) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">{{ $unreadContacts }} liên hệ chưa đọc</small>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="stat-card card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-star text-info fa-2x"></i>
                        </div>
                        <div class="stat-trend text-info">
                            <i class="fas fa-arrow-up"></i>
                            <small>{{ number_format(($featuredTestimonials / max(1, $totalTestimonials)) * 100, 1) }}%</small>
                        </div>
                    </div>
                    <h3 class="stat-number mb-1">{{ number_format($totalTestimonials) }}</h3>
                    <p class="stat-label text-muted mb-2">Đánh giá</p>
                    <div class="progress stat-progress" style="height: 6px;">
                        <div class="progress-bar bg-info rounded-pill" style="width: {{ min(100, ($featuredTestimonials / max(1, $totalTestimonials)) * 100) }}%"></div>
                    </div>
                    <small class="text-muted">{{ $featuredTestimonials }} đánh giá nổi bật</small>
                </div>
            </div>
        </div>
    </div>
    <!-- /Statistics Cards -->

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Monthly Stats Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="chart-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Thống kê theo tháng
                        </h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary">6 tháng gần nhất</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Monthly Stats Chart -->

        <!-- Services Status Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="chart-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-pie-chart text-success me-2"></i>
                            Trạng thái dịch vụ
                        </h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="servicesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Services Status Chart -->
    </div>
    <!-- /Charts Row -->

    <!-- Contacts Status Chart -->
    <div class="row g-4 mb-4">
                 <div class="col-xl-6 col-lg-6">
             <div class="chart-card card border-0 shadow-sm h-100">
                 <div class="card-header bg-transparent border-0 p-4">
                     <div class="d-flex align-items-center justify-content-between">
                         <h5 class="card-title mb-0">
                             <i class="fas fa-envelope text-warning me-2"></i>
                             Trạng thái liên hệ
                         </h5>
                     </div>
                 </div>
                 <div class="card-body p-4">
                     <div class="chart-container" style="height: 250px;">
                         <canvas id="contactsChart"></canvas>
                         <div id="contactsChartPlaceholder" class="chart-placeholder" style="display: none;">
                             <div class="text-center py-5">
                                 <i class="fas fa-chart-pie text-muted fa-3x mb-3"></i>
                                 <p class="text-muted">Chưa có dữ liệu liên hệ</p>
                                 <small class="text-muted">Hoặc tất cả đều bằng 0</small>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
        <div class="col-xl-6 col-lg-6">
            <div class="quick-stats-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tachometer-alt text-info me-2"></i>
                        Thống kê nhanh
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="quick-stat-item text-center p-3 bg-primary bg-opacity-10 rounded-3">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-car text-primary fa-2x"></i>
                                </div>
                                <h4 class="text-primary mb-1">{{ number_format($newServices) }}</h4>
                                <p class="text-muted mb-0 small">Dịch vụ mới (7 ngày)</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="quick-stat-item text-center p-3 bg-warning bg-opacity-10 rounded-3">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-envelope text-warning fa-2x"></i>
                                </div>
                                <h4 class="text-warning mb-1">{{ number_format($newContacts) }}</h4>
                                <p class="text-muted mb-0 small">Liên hệ mới (7 ngày)</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="quick-stat-item text-center p-3 bg-success bg-opacity-10 rounded-3">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-users text-success fa-2x"></i>
                                </div>
                                <h4 class="text-success mb-1">{{ number_format($newUsers) }}</h4>
                                <p class="text-muted mb-0 small">Người dùng mới (7 ngày)</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="quick-stat-item text-center p-3 bg-info bg-opacity-10 rounded-3">
                                <div class="stat-icon mb-2">
                                    <i class="fas fa-star text-info fa-2x"></i>
                                </div>
                                <h4 class="text-info mb-1">{{ number_format($newTestimonials) }}</h4>
                                <p class="text-muted mb-0 small">Đánh giá mới (7 ngày)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Contacts Status Chart -->

    <!-- Recent Activity -->
    <div class="row g-4">
        <div class="col-xl-4 col-lg-4">
            <div class="activity-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-car text-primary me-2"></i>
                        Dịch vụ gần đây
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($recentServices->count() > 0)
                        <div class="activity-list">
                            @foreach($recentServices->take(5) as $service)
                            <div class="activity-item d-flex align-items-center p-3 rounded-3 mb-3 bg-light">
                                <div class="activity-icon me-3">
                                    <i class="fas fa-car text-primary"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <h6 class="mb-1">{{ $service->name ?? 'N/A' }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="badge bg-{{ $service->status == 1 ? 'success' : 'warning' }} bg-opacity-10 text-{{ $service->status == 1 ? 'success' : 'warning' }}">
                                            {{ $service->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}
                                        </span>
                                        <small class="text-muted">{{ $service->created_at ? $service->created_at->format('d/m/Y') : 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-car text-muted fa-3x mb-3"></i>
                                <p class="text-muted">Chưa có dịch vụ nào</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">
            <div class="activity-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-envelope text-warning me-2"></i>
                        Liên hệ gần đây
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($recentContacts->count() > 0)
                        <div class="activity-list">
                            @foreach($recentContacts->take(5) as $contact)
                            <div class="activity-item d-flex align-items-center p-3 rounded-3 mb-3 bg-light">
                                <div class="activity-icon me-3">
                                    <i class="fas fa-envelope text-warning"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <h6 class="mb-1">{{ $contact->name ?? 'N/A' }}</h6>
                                                                         <div class="d-flex align-items-center justify-content-between">
                                         <span class="badge bg-{{ $contact->status == 'unread' ? 'warning' : 'success' }} bg-opacity-10 text-{{ $contact->status == 'unread' ? 'warning' : 'success' }}">
                                             {{ $contact->status_text ?? 'N/A' }}
                                         </span>
                                         <small class="text-muted">{{ $contact->created_at ? $contact->created_at->format('d/m/Y') : 'N/A' }}</small>
                                     </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-envelope text-muted fa-3x mb-3"></i>
                                <p class="text-muted">Chưa có liên hệ nào</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">
            <div class="activity-card card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-star text-info me-2"></i>
                        Đánh giá gần đây
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($recentTestimonials->count() > 0)
                        <div class="activity-list">
                            @foreach($recentTestimonials->take(5) as $testimonial)
                            <div class="activity-item d-flex align-items-center p-3 rounded-3 mb-3 bg-light">
                                <div class="activity-icon me-3">
                                    <i class="fas fa-star text-info"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <h6 class="mb-1">{{ $testimonial->customer_name ?? 'N/A' }}</h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="rating-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= ($testimonial->rating ?? 0) ? 'text-warning' : 'text-muted' }} fa-sm"></i>
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ $testimonial->created_at ? $testimonial->created_at->format('d/m/Y') : 'N/A' }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-star text-muted fa-3x mb-3"></i>
                                <p class="text-muted">Chưa có đánh giá nào</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- /Recent Activity -->
</div>

<!-- Data payload for charts (kept outside <script> to avoid linter issues) -->
<div id="dashboard-data"
     data-monthly-months='@json($monthlyStats["months"])'
     data-monthly-services='@json($monthlyStats["services"])'
     data-monthly-contacts='@json($monthlyStats["contacts"])'
     data-services-labels='@json($servicesByStatus["labels"])'
     data-services-data='@json($servicesByStatus["data"])'
     data-contacts-labels='@json($contactsByStatus["labels"])'
     data-contacts-data='@json($contactsByStatus["data"])'></div>

@endsection

@section('styles')
<style>
/* Custom Dashboard Styles */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: transform 0.3s ease;
}

.welcome-card:hover {
    transform: translateY(-2px);
}

.stat-card {
    transition: all 0.3s ease;
    border-radius: 15px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.stat-icon {
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.9rem;
    font-weight: 500;
}

.stat-progress {
    border-radius: 10px;
    background-color: #f8f9fa;
}

.stat-progress .progress-bar {
    border-radius: 10px;
    transition: width 0.6s ease;
}

.chart-card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.chart-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
}

.quick-stats-card {
    border-radius: 15px;
}

.quick-stat-item {
    transition: all 0.3s ease;
    border-radius: 12px;
}

.quick-stat-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.activity-card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.activity-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
}

.activity-item {
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.activity-item:hover {
    border-color: #e9ecef;
    background-color: #f8f9fa !important;
    transform: translateX(5px);
}

.activity-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(0,0,0,0.05);
}

.empty-state {
    opacity: 0.6;
}

/* Badge improvements */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
    border-radius: 8px;
}

/* Chart improvements */
.chart-container {
    position: relative;
    margin: auto;
}

.chart-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border-radius: 8px;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .stat-number {
        font-size: 1.5rem;
    }
    
    .welcome-card h2 {
        font-size: 1.5rem;
    }
    
    .welcome-card .fa-3x {
        font-size: 2rem !important;
    }
}

/* Animation for loading */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .chart-card, .activity-card {
    animation: fadeInUp 0.6s ease forwards;
}

.stat-card:nth-child(1) { animation-delay: 0.1s; }
.stat-card:nth-child(2) { animation-delay: 0.2s; }
.stat-card:nth-child(3) { animation-delay: 0.3s; }
.stat-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataEl = document.getElementById('dashboard-data');
    const monthlyMonths = JSON.parse(dataEl.getAttribute('data-monthly-months') || '[]');
    const monthlyServices = JSON.parse(dataEl.getAttribute('data-monthly-services') || '[]');
    const monthlyContacts = JSON.parse(dataEl.getAttribute('data-monthly-contacts') || '[]');
    const servicesLabels = JSON.parse(dataEl.getAttribute('data-services-labels') || '[]');
    const servicesData = JSON.parse(dataEl.getAttribute('data-services-data') || '[]');
    const contactsLabels = JSON.parse(dataEl.getAttribute('data-contacts-labels') || '[]');
    const contactsData = JSON.parse(dataEl.getAttribute('data-contacts-data') || '[]');
    
    // Debug data
    console.log('Contacts Labels:', contactsLabels);
    console.log('Contacts Data:', contactsData);

    // Monthly Stats Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyMonths,
            datasets: [{
                label: 'Dịch vụ mới',
                data: monthlyServices,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: 'rgb(75, 192, 192)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }, {
                label: 'Liên hệ mới',
                data: monthlyContacts,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.4,
                borderWidth: 3,
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    }
                }
            }
        }
    });

    // Services Status Chart
    const servicesCtx = document.getElementById('servicesChart').getContext('2d');
    new Chart(servicesCtx, {
        type: 'doughnut',
        data: {
            labels: servicesLabels,
            datasets: [{
                data: servicesData,
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });

    // Contacts Status Chart
    const contactsCtx = document.getElementById('contactsChart');
    const contactsPlaceholder = document.getElementById('contactsChartPlaceholder');
    
    if (contactsCtx) {
        // Kiểm tra nếu có dữ liệu
        if (contactsData.length > 0 && contactsData.some(value => value > 0)) {
            // Ẩn placeholder và hiển thị chart
            if (contactsPlaceholder) contactsPlaceholder.style.display = 'none';
            contactsCtx.style.display = 'block';
            
            new Chart(contactsCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: contactsLabels,
                    datasets: [{
                        data: contactsData,
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.8)',
                            'rgba(255, 193, 7, 0.8)'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });
        } else {
            // Hiển thị placeholder khi không có dữ liệu
            contactsCtx.style.display = 'none';
            if (contactsPlaceholder) contactsPlaceholder.style.display = 'block';
        }
    } else {
        console.error('Contacts chart canvas not found');
    }
});
</script>
@endsection




