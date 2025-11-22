@extends('driver.layouts.main')

@section('page_title', 'Bảng giá dịch vụ lái xe thuê - laixeho.net.vn')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-video-bg">
            <div class="hero-overlay"></div>
            <div class="hero-particles"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-glow">
                        <i class="fas fa-star"></i>
                        Giá cả minh bạch
                    </span>
                </div>
                <h1 class="hero-title">
                    <span class="title-line">Bảng giá dịch vụ</span>
                    <span class="title-highlight">cạnh tranh</span>
                    <span class="title-line">và minh bạch</span>
                </h1>
                <p class="hero-description">
                    Khám phá bảng giá dịch vụ lái xe thuê với mức giá cạnh tranh, 
                    không phát sinh chi phí ẩn và nhiều ưu đãi hấp dẫn
                </p>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Gói dịch vụ nổi bật</h2>
                <p class="section-subtitle">
                    Những gói dịch vụ được khách hàng lựa chọn nhiều nhất với giá cả hợp lý
                </p>
            </div>

            <div class="services-grid">
                @if(count($services) > 0)
                    @foreach($services->where('is_featured', true)->take(3) as $service)
                        <div class="service-card-modern animate-in" @if($service->image) style="background-image: url('{{ $service->image }}');" @endif>
                            <div class="service-overlay"></div>
                            <div class="service-header">
                                <div class="service-icon-wrapper">
                                    @php $icon = $service->icon; @endphp
                                    @if($icon)
                                        @if(\Illuminate\Support\Str::startsWith($icon, ['fa ', 'fas ', 'far ', 'fal ', 'fad ', 'fab ']))
                                            <i class="{{ $icon }}"></i>
                                        @else
                                            <img src="{{ $icon }}" alt="{{ $service->name }}">
                                        @endif
                                    @else
                                        <i class="fas fa-car"></i>
                                    @endif
                                </div>
                                @if($service->is_featured)
                                    <div class="featured-tag">Nổi bật</div>
                                @endif
                            </div>
                            
                            <div class="service-content">
                                <h3 class="service-title">{{ $service->name }}</h3>
                                <p class="service-description">{{ $service->description }}</p>
                                
                                <a href="{{ route('driver.contact') }}" class="btn-book-service">
                                    <span>Liên hệ tư vấn</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <h3>Chưa có dịch vụ nào</h3>
                        <p>Vui lòng quay lại sau hoặc liên hệ với chúng tôi để được tư vấn.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Pricing Table Section -->
    <section class="pricing-section" @if($contactInfo && $contactInfo->pricing_background_image) style="background-image: url('{{ asset($contactInfo->pricing_background_image) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;" @endif>
        <div class="pricing-overlay"></div>
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Bảng giá chi tiết</h2>
                <p class="section-subtitle">
                    Xem chi tiết giá cả theo khoảng cách và thời gian
                </p>
            </div>

            <div class="pricing-table-container">
                <div class="pricing-table-modern">
                    <div class="table-responsive">
                        <table class="table table-bordered pricing-table">
                            <thead>
                                <tr class="table-header">
                                    <th class="text-center" style="width: {{ count($pricingRules) > 0 ? 100 / (count($pricingRules) + 1) : 20 }}%;">
                                        Thời gian</th>
                                    @foreach($pricingRules as $rule)
                                    <th class="text-center" style="width: {{ 100 / (count($pricingRules) + 1) }}%;">
                                        <div class="time-info">
                                            <i class="{{ $rule->time_icon }}" style="color: white;"></i>
                                            <span class="time-text">{{ $rule->time_slot }}</span>
                                        </div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distanceTiers as $tier)
                                <tr class="pricing-row">
                                    <td class="distance-slot">
                                        <div class="distance-info">
                                            <i class="fas fa-route"></i>
                                            <span class="distance-text">{{ $tier->display_text }}</span>
                                        </div>
                                    </td>
                                    @foreach($pricingRules as $rule)
                                    <td class="price-cell">
                                        @php
                                            $pricingDistance = $rule->pricingDistances->where('distance_tier_id', $tier->id)->first();
                                        @endphp
                                        @if($pricingDistance)
                                            @if($pricingDistance->price_text)
                                                <span class="price-negotiable">{{ $pricingDistance->price_text }}</span>
                                            @else
                                                <span class="price-amount">{{ number_format($pricingDistance->price / 1000, 0) }}k</span>
                                                <small class="price-unit">
                                                    @if($tier->from_distance == 0 && $tier->to_distance)
                                                        /chuyến
                                                    @else
                                                        /km
                                                    @endif
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ count($pricingRules) + 1 }}" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-calculator"></i>
                                            </div>
                                            <h3>Chưa có bảng giá</h3>
                                            <p>Vui lòng liên hệ với chúng tôi để được tư vấn về giá cả.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pricing Notes -->
                <div class="pricing-notes">
                    Lưu ý: Đặt xe trước 60 phút trở lên giảm 5% - Phụ thu phí phát sinh cho đợi 50k/h
                </div>

                <!-- CTA Button -->
                <div class="pricing-cta">
                    @if ($contactPhone)
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="btn-contact-now">
                            <i class="fas fa-phone"></i>
                            Gọi ngay: {{ $contactPhone }}
                        </a>
                    @else
                        <a href="{{ route('driver.contact') }}" class="btn-contact-now">
                            <i class="fas fa-phone"></i>
                            Liên hệ ngay
                        </a>
                    @endif
                </div>

                <!-- Additional Pricing Info -->
                <div class="pricing-info">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="info-content">
                                <h4>Lưu ý về giá</h4>
                                <ul>
                                    <li>Giá trên chưa bao gồm phí cầu đường, bãi xe</li>
                                    <li>Phí chờ: 50k/giờ (áp dụng sau 15 phút chờ)</li>
                                    <li>Phí đi sân bay: +100k so với giá thường</li>
                                    <li>Giá có thể thay đổi trong dịp lễ, Tết</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="info-content">
                                <h4>Liên hệ tư vấn</h4>
                                <p>Để biết chính xác giá cho chuyến đi của bạn, vui lòng liên hệ:</p>
                                <div class="contact-info">
                                    @if ($contactPhone)
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <span>Hotline: {{ $contactPhone }}</span>
                                    </div>
                                    @endif
                                    @if ($contactEmail)
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <span>Email: {{ $contactEmail }}</span>
                                    </div>
                                    @endif
                                </div>
                                <a href="{{ route('driver.contact') }}" class="btn-contact-advice">
                                    <i class="fas fa-comments"></i>
                                    Tư vấn miễn phí
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Thông tin bổ sung</h2>
                <p class="section-subtitle">
                    Những thông tin quan trọng về dịch vụ và chính sách của chúng tôi
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Giờ làm việc</h3>
                        <p>Dịch vụ 24/7, hỗ trợ mọi lúc mọi nơi với đội ngũ tài xế chuyên nghiệp</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Khu vực phục vụ</h3>
                        <p>Toàn bộ Hà Nội và các tỉnh lân cận với mạng lưới tài xế rộng khắp</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hình thức thanh toán</h3>
                        <p>Tiền mặt, chuyển khoản, ví điện tử với nhiều lựa chọn thuận tiện</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Bảo hiểm đầy đủ</h3>
                        <p>Bảo hiểm đầy đủ cho khách hàng và phương tiện với mức bồi thường cao</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Bạn cần tư vấn về giá?</h2>
                    <p>Hãy liên hệ ngay với chúng tôi để được tư vấn chi tiết và báo giá tốt nhất.</p>
                </div>
                
                <div class="contact-methods">
                    @if ($contactPhone)
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="method-info">
                            <h4>Gọi điện thoại</h4>
                            <p>{{ $contactPhone }}</p>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                    @endif

                    @if ($contactEmail)
                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="method-info">
                            <h4>Gửi email</h4>
                            <p>{{ $contactEmail }}</p>
                            <span>Phản hồi trong 2h</span>
                        </div>
                    </div>
                    @endif

                    <div class="contact-method">
                        <div class="method-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="method-info">
                            <h4>Chat trực tuyến</h4>
                            <p>Zalo, Facebook</p>
                            <span>Phản hồi ngay lập tức</span>
                        </div>
                    </div>
                </div>

                <div class="hero-actions" style="margin-top: 3rem;">
                    <a href="{{ route('driver.contact') }}" class="btn-primary-glow">
                        <span class="btn-text">Liên hệ ngay</span>
                        <span class="btn-icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);

    // Observe all elements with animate-in class
    document.querySelectorAll('.animate-in').forEach(el => {
        observer.observe(el);
    });



    // Smooth scroll for scroll indicator
    const scrollArrow = document.querySelector('.scroll-arrow');
    if (scrollArrow) {
        scrollArrow.addEventListener('click', function() {
            const pricingSection = document.querySelector('.pricing-section');
            if (pricingSection) {
                pricingSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
});
</script>
@endsection
