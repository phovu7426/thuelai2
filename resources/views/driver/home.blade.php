@extends('driver.layouts.main')

@section('page_title', 'Dịch vụ lái xe thuê an toàn')

@section('content')
    @if(isset($homeBanner) && $homeBanner && $homeBanner->status && $homeBanner->is_announcement && $homeBanner->image_url && false)
        <!-- Announcement Bar on top of Hero -->
        <div class="announcement-bar">
            <div class="announcement-bg" style="background-image: url('{{ $homeBanner->image_url }}');"></div>
            <div class="announcement-overlay"></div>
            <div class="container">
                <div class="announcement-inner">
                    <div class="announcement-text">
                        <strong>{{ $homeBanner->title ?: 'Thông báo' }}</strong>
                        @if($homeBanner->subtitle)
                            <span class="sep">•</span> <span>{{ $homeBanner->subtitle }}</span>
                        @endif
                    </div>
                    @if($homeBanner->link)
                        <a href="{{ $homeBanner->link }}" class="announcement-btn">
                            {{ $homeBanner->button_text ?: 'Xem chi tiết' }}
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @if(isset($homeBanner) && $homeBanner && $homeBanner->status && $homeBanner->image_url)
    <!-- Home Banner Section (full-width, top) -->
    <section class="home-banner-full">
        <div class="home-banner-bg" style="background-image: url('{{ $homeBanner->image_url }}');"></div>
        <div class="home-banner-layer"></div>
        <div class="container">
            <div class="home-banner-inner">
                @if($homeBanner->title)
                    <h2 class="home-banner-title">{{ $homeBanner->title }}</h2>
                @endif
                @if($homeBanner->subtitle)
                    <p class="home-banner-subtitle">{{ $homeBanner->subtitle }}</p>
                @endif
                @if($homeBanner->link)
                    <a href="{{ $homeBanner->link }}" class="btn-primary-glow home-banner-btn">
                        {{ $homeBanner->button_text ?: 'Xem chi tiết' }}
                        <span class="btn-icon"><i class="fas fa-arrow-right"></i></span>
                    </a>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Hero Section với Video Background -->
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
                        Dịch vụ 5 sao được tin cậy
                    </span>
                </div>

                <h1 class="hero-title">
                    <span class="title-line">Lái xe an toàn</span>
                    <span class="title-highlight">chuyên nghiệp</span>
                    <span class="title-line">24/7</span>
                </h1>

                <p class="hero-description">
                    Dịch vụ lái xe thuê cao cấp với đội ngũ tài xế giàu kinh nghiệm,
                    phương tiện hiện đại và dịch vụ khách hàng xuất sắc
                </p>

                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" data-count="1000">0</div>
                        <div class="stat-label">Khách hàng hài lòng</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="24">0</div>
                        <div class="stat-label">Giờ hỗ trợ</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-count="5">0</div>
                        <div class="stat-label">Sao đánh giá</div>
                    </div>
                </div>

                <div class="hero-actions">
                    <a href="#booking" class="btn-primary-glow">
                        <span class="btn-text">Đặt tài xế ngay</span>
                        <span class="btn-icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                    <a href="#services" class="btn-secondary">
                        <i class="fas fa-play"></i>
                        <span>Xem dịch vụ</span>
                    </a>
                </div>
            </div>

            <div class="hero-visual"></div>
        </div>

        
    </section>

    <!-- Driver Highlights - horizontal scroller -->
    <section class="driver-highlights">
        <div class="container">
            <div class="features-scroller" aria-label="Driver highlights">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-user-tie"></i></div>
                    <div class="feature-title">Tài xế chuyên nghiệp</div>
                    <div class="feature-desc">Được đào tạo bài bản</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="feature-title">An toàn tuyệt đối</div>
                    <div class="feature-desc">Bảo hiểm đầy đủ</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-clock"></i></div>
                    <div class="feature-title">Dịch vụ 24/7</div>
                    <div class="feature-desc">Luôn sẵn sàng phục vụ</div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Pricing Section -->
    <section class="pricing-section" @if($contactInfo && $contactInfo->pricing_background_image) style="background-image: url('{{ asset($contactInfo->pricing_background_image) }}'); background-size: cover; background-position: center; background-repeat: no-repeat;" @endif>
        <div class="pricing-overlay"></div>
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <span class="badge-modern">
                        <i class="fas fa-tags"></i>
                        Bảng giá
                    </span>
                </div>
                <h2 class="section-title">BẢNG BÁO GIÁ LÁI XE HỖ THEO CHUYẾN</h2>
                <p class="section-subtitle">
                    Không phát sinh chi phí, giá cả rõ ràng và cạnh tranh
                </p>
            </div>

            <div class="pricing-table-container">
                <div class="pricing-table-modern">
                    <div class="table-responsive">
                        <table class="table table-bordered pricing-table">
                            <thead>
                                <tr class="table-header">
                                    <th class="text-center pricing-col-time">
                                        Thời gian
                                    </th>
                                    @foreach ($pricingRules as $rule)
                                        <th class="text-center pricing-col-price">
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
                                        @foreach ($pricingRules as $rule)
                                            <td class="price-cell">
                                                @php
                                                    $pricingDistance = $rule->pricingDistances
                                                        ->where('distance_tier_id', $tier->id)
                                                        ->first();
                                                @endphp
                                                @if ($pricingDistance)
                                                    @if ($pricingDistance->price_text)
                                                        <span class="price-negotiable">{{ $pricingDistance->price_text }}</span>
                                                    @else
                                                        <span class="price-amount">{{ number_format($pricingDistance->price / 1000, 0) }}k</span>
                                                        <small class="price-unit">
                                                            @if ($tier->from_distance == 0 && $tier->to_distance)
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
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <span class="badge-modern">
                        <i class="fas fa-phone-alt"></i>
                        Hotline 24/7
                    </span>
                </div>
                <h2 class="section-title">Tại sao chọn chúng tôi?</h2>
                <p class="section-subtitle">
                    Nhậu xong không phải lo về nhà - Tài xế chuyên nghiệp phục vụ tận nơi
                </p>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Bạn uống tôi lái</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><strong>Nhậu xong không phải lo về nhà!</strong> Chúng tôi có dịch vụ lái xe hộ khi say rượu bia 24/7. Tài xế chuyên nghiệp sẽ đến đón bạn trong vòng 15 phút, đảm bảo an toàn tuyệt đối. <a href="{{ route('driver.services') }}" class="text-primary fw-bold">Xem dịch vụ chi tiết</a> | <strong>Gọi ngay: 0398982112</strong></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Lái xe hộ Hà Nội</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><strong>Dịch vụ lái xe hộ uy tín số 1 Hà Nội!</strong> Đội ngũ tài xế giàu kinh nghiệm, phương tiện hiện đại, phục vụ tận tâm. Cam kết giá cả hợp lý và an toàn tuyệt đối. <a href="{{ route('driver.pricing') }}" class="text-primary fw-bold">Xem bảng giá</a> | <strong>Hotline: 0398982112</strong></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Dịch vụ lái xe khi say</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><strong>Say rồi đừng tự lái!</strong> Chúng tôi đến trong 15 phút, lái xe hộ an toàn tận nơi. Dịch vụ 24/7, giá cả phải chăng, tài xế chuyên nghiệp. <a href="{{ route('driver.contact') }}" class="text-primary fw-bold">Liên hệ ngay</a> | <strong>Hotline: 0398982112</strong></p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <h3>Gọi 0398982112</h3>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><strong>Hotline 24/7: 0398982112</strong><br>
                        📞 Đặt xe ngay lập tức<br>
                        🚗 Tài xế chuyên nghiệp<br>
                        ⏰ Có mặt trong 15 phút<br>
                        💰 Giá cả hợp lý<br>
                        🛡️ An toàn tuyệt đối</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <span class="badge-modern">
                        <i class="fas fa-cogs"></i>
                        Dịch vụ của chúng tôi
                    </span>
                </div>
                <h2 class="section-title">Dịch vụ đa dạng</h2>
                <p class="section-subtitle">
                    Chúng tôi cung cấp đầy đủ các dịch vụ lái xe thuê phù hợp với mọi nhu cầu
                </p>
            </div>

            <div class="services-grid">
                @if (count($services) > 0)
                    @foreach ($services as $service)
                        <div class="service-card-modern" @if($service->image) style="background-image: url('{{ $service->image }}');" @endif>
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
                                @if ($service->is_featured)
                                    <div class="featured-tag">
                                        <span>Nổi bật</span>
                                    </div>
                                @endif
                            </div>

                            <div class="service-content">
                                <h3 class="service-title">{{ $service->name }}</h3>
                                <p class="service-description">{{ $service->short_description }}</p>

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
                        <h3>Chưa có dịch vụ</h3>
                        <p>Chúng tôi đang cập nhật dịch vụ mới</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Tư vấn 24/7</h3>
                        <p>Đội ngũ tư vấn chuyên nghiệp luôn sẵn sàng hỗ trợ bạn mọi lúc</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>An toàn tuyệt đối</h3>
                        <p>Bảo hiểm đầy đủ và cam kết an toàn cho mọi chuyến đi</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-smile"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Phục vụ chuyên nghiệp</h3>
                        <p>Tài xế thân thiện, có kinh nghiệm và phục vụ tận tâm</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Kinh nghiệm dày dặn</h3>
                        <p>Đội ngũ tài xế có nhiều năm kinh nghiệm lái xe</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process-section">
        <div class="container">
            <div class="section-header">
                <div class="section-badge">
                    <span class="badge-modern">
                        <i class="fas fa-route"></i>
                        Quy trình đơn giản
                    </span>
                </div>
                <h2 class="section-title">4 bước đặt tài xế</h2>
                <p class="section-subtitle">
                    Dịch vụ lái xe chất lượng, uy tín và chuyên nghiệp
                </p>
            </div>

            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Liên hệ</h3>
                    <p>Gọi hotline hoặc liên hệ trực tiếp</p>
                </div>

                <div class="process-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="process-step">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Xác nhận</h3>
                    <p>Chúng tôi xác nhận thông tin và báo giá</p>
                </div>

                <div class="process-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="process-step">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Đón khách</h3>
                    <p>Tài xế đến đúng địa điểm và thời gian</p>
                </div>

                <div class="process-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>

                <div class="process-step">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Thanh toán</h3>
                    <p>Thanh toán sau khi hoàn thành chuyến đi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if (count($testimonials) > 0)
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <span class="badge-modern">
                            <i class="fas fa-comments"></i>
                            Đánh giá khách hàng
                        </span>
                    </div>
                    <h2 class="section-title">Khách hàng nói gì?</h2>
                    <p class="section-subtitle">
                        Những đánh giá chân thực từ khách hàng đã sử dụng dịch vụ
                    </p>
                </div>

                <div class="testimonials-grid">
                    @foreach ($testimonials as $testimonial)
                        <div class="testimonial-card-modern">
                            <div class="testimonial-header">
                                @if ($testimonial->image)
                                    <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->customer_name }}"
                                        class="customer-avatar">
                                @else
                                    <div class="customer-avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div class="customer-info">
                                    <h4>{{ $testimonial->customer_name }}</h4>
                                    @if ($testimonial->customer_title)
                                        <span>{{ $testimonial->customer_title }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $testimonial->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>

                            <blockquote>
                                "{{ $testimonial->content }}"
                            </blockquote>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <div class="section-badge">
                        <span class="badge-modern">
                            <i class="fas fa-phone"></i>
                            Liên hệ ngay
                        </span>
                    </div>
                    <h2>Hãy liên hệ với chúng tôi</h2>
                    <p>Đội ngũ tư vấn chuyên nghiệp luôn sẵn sàng hỗ trợ bạn</p>

                    <div class="contact-methods">
                        @if ($contactPhone)
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Hotline</h4>
                                    <p>{{ $contactPhone }}</p>
                                    <span>{{ $contactWorkingTime ?: 'Hỗ trợ 24/7' }}</span>
                                </div>
                            </div>
                        @endif

                        @if ($contactEmail)
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Email</h4>
                                    <p>{{ $contactEmail }}</p>
                                    <span>Phản hồi nhanh</span>
                                </div>
                            </div>
                        @endif

                        @if ($contactAddress)
                            <div class="contact-method">
                                <div class="method-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="method-info">
                                    <h4>Địa chỉ</h4>
                                    <p>{{ $contactAddress }}</p>
                                    <span>Trụ sở chính</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter Animation
            const counters = document.querySelectorAll('.stat-number');
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = parseInt(counter.getAttribute('data-count'));
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };

                    updateCounter();
                });
            };

            // Intersection Observer for animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');

                        // Trigger counter animation for hero stats
                        if (entry.target.classList.contains('hero-stats')) {
                            animateCounters();
                        }
                    }
                });
            }, observerOptions);

            // Observe elements
            document.querySelectorAll(
                '.service-card-modern, .feature-item, .process-step, .testimonial-card-modern, .pricing-card-modern, .hero-stats'
            ).forEach(el => {
                observer.observe(el);
            });





            // Smooth scroll for navigation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Notification function
            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('show');
                }, 100);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }
        });
    </script>
    <style>
        /* ===== Harmonized HERO styling to match announcement banner ===== */
        .hero-section { position: relative; padding: 8px 0 0 !important; background: linear-gradient(180deg, rgba(42,0,84,0.85) 0%, rgba(42,0,84,0.70) 60%, rgba(42,0,84,0.60) 100%); }
        /* When using banner as hero background */
        .hero-section.hero-with-banner .hero-video-bg { display: block; position: absolute; inset: 0; background-size: cover; background-position: center; }
        .hero-section.hero-with-banner .hero-overlay { background: rgba(0,0,0,0.35); }
        .hero-title { font-weight: 800; line-height: 1.15; }
        .hero-description { color: #e9e3ef; font-size: 18px; opacity: .95; margin-bottom: 6px !important; }
        .hero-stats { margin-bottom: 6px !important; }
        .hero-actions { margin-top: 8px !important; }
        .btn-primary-glow { background: linear-gradient(90deg,#6a11cb,#2575fc); border: none; box-shadow: 0 10px 24px rgba(37,117,252,.35); }
        .btn-secondary { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18); color: #fff; }
        .hero-actions { display: flex !important; flex-direction: row !important; flex-wrap: nowrap; gap: 12px; align-items: center; justify-content: center; margin-top: 12px !important; }
        .hero-actions a { flex: 1 1 0 !important; margin: 0 !important; white-space: nowrap; min-width: 0; }
        /* Force hero stats to be horizontal at all sizes */
        .hero-section .hero-content .hero-stats { display: flex !important; flex-direction: row !important; flex-wrap: nowrap; align-items: flex-start; justify-content: center; gap: 24px; }
        .hero-section .hero-content .hero-stats .stat-item { flex: 1 1 0; text-align: center; }
        .hero-stats .stat-number { color: #fff; }
        .hero-stats .stat-label { color: rgba(255,255,255,.85); }

        

        /* Announcement bar */
        .announcement-bar { position: relative; z-index: 3; overflow: hidden; height: 200px; }
        .announcement-bg { position: absolute; inset: 0; background-size: contain; background-repeat: no-repeat; background-position: center; }
        .announcement-overlay { position: absolute; inset: 0; background: linear-gradient(90deg, rgba(0,0,0,0.18), rgba(0,0,0,0.10)); }
        .announcement-inner { position: relative; display: flex; align-items: center; justify-content: space-between; height: 100%; padding: 0; color: #fff; }
        .announcement-text { font-size: 15px; font-weight: 500; }
        .announcement-text .sep { opacity: 0.6; margin: 0 8px; }
        .announcement-btn { color: #fff; background: linear-gradient(90deg,#6a11cb,#2575fc); padding: 8px 14px; border-radius: 999px; font-weight: 700; letter-spacing: .2px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 6px 18px rgba(37,117,252,.35); }
        .announcement-btn:hover { opacity: 0.95; }
        .announcement-inner strong, .announcement-inner span { text-shadow: 0 2px 8px rgba(0,0,0,.35); }

        /* Home Banner (scoped) */
        .home-banner-full { position: relative; padding: 140px 0; min-height: 420px; overflow: hidden; margin: 0 0 24px; z-index: 1; }
        .home-banner-full .home-banner-bg {
            position: absolute; inset: 0; background-size: cover; background-position: center;
            transform: scale(1.02);
        }
        .home-banner-full .home-banner-layer {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, rgba(21, 0, 41, 0.55) 0%, rgba(21, 0, 41, 0.7) 100%);
            backdrop-filter: blur(0.5px);
        }
        .home-banner-inner { position: relative; z-index: 2; text-align: center; color: #fff; }
        .home-banner-title { font-size: 44px; font-weight: 800; margin-bottom: 12px; letter-spacing: 0.2px; }
        .home-banner-subtitle { font-size: 20px; opacity: 0.95; margin-bottom: 22px; }
        .home-banner-btn { display: inline-flex; align-items: center; gap: 8px; }

        /* Driver highlights scroller */
        .driver-highlights { padding: 12px 0 24px; }
        .features-scroller { display: flex; gap: 20px; overflow-x: auto; overflow-y: hidden; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; padding: 8px 4px; justify-content: center; scroll-padding-left: 0; scroll-padding-right: 0; touch-action: pan-x; }
        .features-scroller::-webkit-scrollbar { height: 8px; }
        .features-scroller::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 8px; }
        .feature-card { min-width: 300px; flex: 0 0 auto; background: rgba(255,255,255,0.9); border: 1px solid rgba(0,0,0,0.06); border-radius: 16px; padding: 32px !important; color: #1d1d1f; text-align: center; scroll-snap-align: center; backdrop-filter: blur(6px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
        .feature-icon { width: 68px !important; height: 68px !important; font-size: 32px !important; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; background: rgba(118,75,162,0.10); color: #764ba2 !important; box-shadow: inset 0 0 0 1px rgba(118,75,162,0.21); }
        .feature-title { font-weight: 800; margin-bottom: 6px; letter-spacing: .2px; color: #111827; font-size: 1.35rem !important; }
        .feature-desc { opacity: .8; font-size: 1.06rem !important; color: #374151; }

        /* Mobile tweaks for scroller: allow full scroll to first/last */
        @media (max-width: 576px) {
            .features-scroller { justify-content: flex-start; padding: 8px 16px; gap: 16px; scroll-padding-left: 16px; scroll-padding-right: 16px; }
            .feature-card { min-width: 95%; }
        }

        /* Responsive */
        @media (min-width: 1200px) {
            .home-banner-full { padding: 200px 0; min-height: 520px; }
        }
        @media (max-width: 992px) {
            .hero-section { padding: 28px 0 16px; }
            .announcement-bar { height: 160px; }
            .home-banner-full { padding: 80px 0; }
            .home-banner-title { font-size: 28px; }
            .home-banner-subtitle { font-size: 16px; }
            /* Hero stats: keep horizontal layout on tablet */
            .hero-section .hero-content .hero-stats { display: flex !important; gap: 16px; justify-content: space-between; }
            .hero-section .hero-content .hero-stats .stat-item { flex: 1 1 0; text-align: center; }
            /* Keep hero buttons in one row */
            .hero-actions { justify-content: space-between; }
            .hero-actions a { flex: 1 1 0 !important; display: inline-flex; align-items: center; justify-content: center; }
        }
        @media (max-width: 576px) {
            .hero-section { padding: 10px 0 4px !important; }
            .announcement-bar { height: 120px; }
            .home-banner-full { padding: 96px 0; }
            .home-banner-title { font-size: 28px; }
            .home-banner-subtitle { font-size: 16px; }
            /* Mobile: avoid banner stretching in Hero */
            .hero-section.hero-with-banner { background: #2a0054; }
            .hero-section.hero-with-banner .hero-video-bg {
                background-size: contain; /* keep original ratio */
                background-repeat: no-repeat;
                background-position: center top;
            }
            .hero-section.hero-with-banner .hero-overlay {
                background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(42,0,84,0.8) 60%, rgba(42,0,84,1) 100%);
            }
            /* Hero stats: display horizontally on mobile */
            .hero-section .hero-content .hero-stats { display: flex !important; gap: 12px; justify-content: space-between; }
            .hero-section .hero-content .hero-stats .stat-item { flex: 1 1 0; text-align: center; }
            .hero-section .hero-content .hero-stats .stat-number { font-size: 28px; }
            .hero-section .hero-content .hero-stats .stat-label { font-size: 12px; }
            /* Hero buttons side-by-side on mobile */
            .hero-actions { gap: 10px; }
            .hero-actions a { flex: 1 1 0 !important; display: inline-flex; align-items: center; justify-content: center; }
            
        }
    </style>
@endsection
