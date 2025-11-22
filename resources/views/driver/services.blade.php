@extends('driver.layouts.main')

@section('page_title', 'Dịch vụ lái xe thuê - laixeho.net.vn')

@push('styles')
<style>
.hero-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.btn-primary-glow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(251, 191, 36, 0.3);
    border: none;
    cursor: pointer;
}

.btn-primary-glow:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(251, 191, 36, 0.4);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    color: white;
    text-decoration: none;
}

.hero-visual {
    position: absolute;
    right: 2rem;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
}

.floating-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.card-1, .card-2, .card-3 {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    padding: 1rem;
    width: 250px;
    animation: float 6s ease-in-out infinite;
}

.card-2 {
    animation-delay: -2s;
}

.card-3 {
    animation-delay: -4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.card-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    color: white;
    font-size: 1.5rem;
}

.card-content h4 {
    color: white;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.card-content p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    margin: 0;
}

@media (max-width: 1200px) {
    .hero-visual {
        display: none;
    }
}

@media (max-width: 768px) {
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-primary-glow,
    .btn-secondary {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
    <!-- Hero Section với Video Background -->
    <section class="hero-section">
        <div class="hero-video-bg">
            <video autoplay muted loop>
                <source src="{{ asset('assets/videos/hero-video.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-particles"></div>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="badge-glow">
                        <i class="fas fa-star"></i>
                        Dịch vụ chất lượng cao
                    </span>
                </div>
                
                <h1 class="hero-title">
                    <span class="title-line">Dịch vụ lái xe</span>
                    <span class="title-highlight">chuyên nghiệp</span>
                    <span class="title-line">đa dạng</span>
                </h1>
                
                <p class="hero-description">
                    Khám phá các gói dịch vụ lái xe thuê đa dạng, phù hợp với mọi nhu cầu 
                    từ cá nhân đến doanh nghiệp với chất lượng dịch vụ hàng đầu
                </p>
                
                <div class="hero-actions">
                    <a href="#services" class="btn-primary-glow">
                        <span class="btn-text">Xem dịch vụ</span>
                        <span class="btn-icon">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>
                    <a href="#contact" class="btn-secondary">
                        <i class="fas fa-phone"></i>
                        <span>Liên hệ tư vấn</span>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="floating-cards">
                    <div class="card-1">
                        <div class="card-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-content">
                            <h4>Tài xế chuyên nghiệp</h4>
                            <p>Được đào tạo bài bản</p>
                        </div>
                    </div>
                    <div class="card-2">
                        <div class="card-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="card-content">
                            <h4>An toàn tuyệt đối</h4>
                            <p>Bảo hiểm đầy đủ</p>
                        </div>
                    </div>
                    <div class="card-3">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-content">
                            <h4>Dịch vụ 24/7</h4>
                            <p>Luôn sẵn sàng phục vụ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Các gói dịch vụ của chúng tôi</h2>
                <p class="section-subtitle">
                    Đa dạng các gói dịch vụ lái xe thuê phù hợp với mọi nhu cầu của bạn
                </p>
            </div>

            <div class="services-grid">
                @if(count($services) > 0)
                    @foreach($services as $service)
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
            
            <!-- Pagination -->
            @if($services->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Tại sao chọn chúng tôi?</h2>
                <p class="section-subtitle">
                    Những lý do khiến laixeho.net.vn trở thành lựa chọn hàng đầu cho dịch vụ lái xe thuê
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>An toàn tuyệt đối</h3>
                        <p>Tài xế được đào tạo bài bản, xe được bảo dưỡng định kỳ và bảo hiểm đầy đủ</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Dịch vụ 24/7</h3>
                        <p>Luôn sẵn sàng phục vụ mọi lúc, mọi nơi với đội ngũ tài xế chuyên nghiệp</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Giá cả hợp lý</h3>
                        <p>Bảng giá minh bạch, không phát sinh chi phí ẩn và nhiều ưu đãi hấp dẫn</p>
                    </div>
                </div>

                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hỗ trợ tận tâm</h3>
                        <p>Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng hỗ trợ mọi vấn đề</p>
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
                    <h2>Bạn cần tư vấn về dịch vụ?</h2>
                    <p>Hãy liên hệ ngay với chúng tôi để được tư vấn chi tiết và báo giá tốt nhất.</p>
                </div>
                
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

                <div class="hero-actions" style="margin-top: 3rem;">
                    @if ($contactPhone)
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $contactPhone) }}" class="btn-primary-glow">
                            <span class="btn-text">Gọi ngay: {{ $contactPhone }}</span>
                            <span class="btn-icon">
                                <i class="fas fa-phone"></i>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('driver.contact') }}" class="btn-primary-glow">
                            <span class="btn-text">Liên hệ ngay</span>
                            <span class="btn-icon">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </a>
                    @endif
                    <a href="{{ route('driver.pricing') }}" class="btn-secondary">
                        <i class="fas fa-list"></i>
                        <span>Xem bảng giá</span>
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
            const servicesSection = document.querySelector('.services-section');
            if (servicesSection) {
                servicesSection.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    }
});
</script>
@endsection

