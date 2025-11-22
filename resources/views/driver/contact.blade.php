@extends('driver.layouts.main')

@section('page_title', 'Liên hệ - Dịch vụ tài xế thuê lái')

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
                        Hỗ trợ 24/7
                    </span>
                </div>
                <h1 class="hero-title">
                    <span class="title-line">Liên hệ với chúng tôi</span>
                    <span class="title-highlight">ngay hôm nay</span>
                    <span class="title-line">để được tư vấn</span>
                </h1>
                <p class="hero-description">
                    Đội ngũ chăm sóc khách hàng chuyên nghiệp sẵn sàng hỗ trợ bạn
                    mọi lúc, mọi nơi với nhiều kênh liên lạc thuận tiện
                </p>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-content">
                <div class="contact-info">
                    <h2>Thông tin liên hệ</h2>
                    <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn mọi vấn đề</p>
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
                                <h4>Gửi email</h4>
                                <p>{{ $contactEmail }}</p>
                                <span>Phản hồi trong 2h</span>
                            </div>
                        </div>
                    @endif

                    @if (!empty($globalSocialLinks))
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="method-info">
                                <h4>Chat trực tuyến</h4>
                                <p>
                                    @if (isset($globalSocialLinks['facebook']))
                                        Zalo, Facebook
                                    @else
                                        Liên hệ trực tiếp
                                    @endif
                                </p>
                                <span>Phản hồi ngay lập tức</span>
                            </div>
                        </div>
                    @endif

                    @if ($contactAddress)
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="method-info">
                                <h4>Văn phòng</h4>
                                <p>{{ $contactAddress }}</p>
                                <span>{{ $contactAddress }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="booking-section">
        <div class="container">
            <div class="booking-content">
                <div class="section-header">
                    <h2 class="section-title">Gửi tin nhắn cho chúng tôi</h2>
                    <p class="section-subtitle">
                        Điền form bên dưới để gửi yêu cầu tư vấn hoặc phản hồi
                    </p>
                </div>

                <div class="booking-form-container">
                    <form class="booking-form-modern" id="contactForm">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-user"></i>
                                    Họ và tên
                                </label>
                                <input type="text" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone"></i>
                                    Số điện thoại
                                </label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="topic">
                                    <i class="fas fa-tag"></i>
                                    Tiêu đề
                                </label>
                                <select id="topic" name="topic" required>
                                    <option value="">Chọn chủ đề</option>
                                    <option value="tư vấn dịch vụ">Tư vấn dịch vụ</option>
                                    <option value="phản hồi">Phản hồi</option>
                                    <option value="khiếu nại">Khiếu nại</option>
                                    <option value="khác">Khác</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subject">
                                    <i class="fas fa-heading"></i>
                                    Tiêu đề
                                </label>
                                <input type="text" id="subject" name="subject" placeholder="Nhập tiêu đề tin nhắn...">
                            </div>

                            <div class="form-group">
                                <label for="pickup_location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Điểm đón
                                </label>
                                <input type="text" id="pickup_location" name="pickup_location"
                                    placeholder="Nhập điểm đón...">
                            </div>

                            <div class="form-group">
                                <label for="dropoff_location">
                                    <i class="fas fa-map-pin"></i>
                                    Điểm đến
                                </label>
                                <input type="text" id="dropoff_location" name="dropoff_location"
                                    placeholder="Nhập điểm đến...">
                            </div>

                            <div class="form-group">
                                <label for="pickup_date">
                                    <i class="fas fa-calendar-alt"></i>
                                    Ngày đón
                                </label>
                                <input type="datetime-local" id="pickup_date" name="pickup_date">
                            </div>

                            <div class="form-group">
                                <label for="passengers">
                                    <i class="fas fa-users"></i>
                                    Số hành khách
                                </label>
                                <input type="number" id="passengers" name="passengers" placeholder="1" min="1"
                                    max="10" value="1">
                            </div>

                            <div class="form-group full-width">
                                <label for="message">
                                    <i class="fas fa-comment"></i>
                                    Nội dung tin nhắn
                                </label>
                                <textarea id="message" name="message" rows="5" required
                                    placeholder="Vui lòng mô tả chi tiết yêu cầu của bạn..."></textarea>
                            </div>
                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                <span>Gửi tin nhắn</span>
                            </button>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Tại sao chọn chúng tôi?</h2>
                <p class="section-subtitle">
                    Những lý do khiến laixeho.net.vn trở thành lựa chọn hàng đầu
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-item animate-in">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Hỗ trợ tận tâm</h3>
                        <p>Đội ngũ chăm sóc khách hàng chuyên nghiệp, sẵn sàng hỗ trợ mọi vấn đề</p>
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
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="feature-content">
                        <h3>An toàn tuyệt đối</h3>
                        <p>Tài xế được đào tạo bài bản, xe được bảo dưỡng định kỳ và bảo hiểm đầy đủ</p>
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
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Vị trí của chúng tôi</h2>
                <p class="section-subtitle">
                    Ghé thăm văn phòng của chúng tôi để được tư vấn trực tiếp
                </p>
            </div>

            <div class="booking-form-container">
                <div class="booking-form-modern">
                    <div class="row">
                        <div class="col-md-6">
                            @if ($contactAddress)
                                <h4><i class="fas fa-map-marker-alt text-primary me-2"></i>Địa chỉ văn phòng</h4>
                                <p class="mb-3">{{ $contactAddress }}</p>
                            @endif

                            @if ($contactWorkingTime)
                                <h4><i class="fas fa-clock text-primary me-2"></i>Giờ làm việc</h4>
                                <p class="mb-3">{{ $contactWorkingTime }}</p>
                            @endif

                            <h4><i class="fas fa-phone text-primary me-2"></i>Liên hệ</h4>
                            <p class="mb-3">
                                @if ($contactPhone)
                                    Điện thoại: {{ $contactPhone }}<br>
                                @endif
                                @if ($contactEmail)
                                    Email: {{ $contactEmail }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if ($contactMapEmbed)
                                <div class="map-container"
                                    style="height: 300px; border-radius: var(--radius-lg); overflow: hidden;">
                                    {!! $contactMapEmbed !!}
                                </div>
                            @else
                                <div class="map-placeholder"
                                    style="height: 300px; background: var(--gray-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: var(--gray-600);">
                                    <div class="text-center">
                                        <i class="fas fa-map fa-3x mb-3"></i>
                                        <p>Bản đồ sẽ được hiển thị tại đây</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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



            // Handle contact form submission
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const submitBtn = this.querySelector('.btn-submit');
                    const originalText = submitBtn.innerHTML;

                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang gửi...</span>';

                    // Get form data
                    const formData = new FormData(this);

                    // Send AJAX request
                    fetch('{{ route('driver.contact.submit') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification(data.message, 'success');
                                contactForm.reset();
                            } else {
                                showNotification(data.message || 'Có lỗi xảy ra, vui lòng thử lại.',
                                    'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Có lỗi xảy ra, vui lòng thử lại.', 'error');
                        })
                        .finally(() => {
                            // Reset button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });

                // Auto-fill subject based on topic
                const topicSelect = document.getElementById('topic');
                const subjectInput = document.getElementById('subject');

                if (topicSelect && subjectInput) {
                    topicSelect.addEventListener('change', function() {
                        const topic = this.value;

                        if (!subjectInput.value) {
                            switch (topic) {
                                case 'khiếu nại':
                                    subjectInput.value = 'Khiếu nại dịch vụ';
                                    break;
                                case 'tư vấn dịch vụ':
                                    subjectInput.value = 'Yêu cầu tư vấn dịch vụ';
                                    break;
                                case 'phản hồi':
                                    subjectInput.value = 'Phản hồi dịch vụ';
                                    break;
                                default:
                                    subjectInput.value = 'Liên hệ chung';
                            }
                        }
                    });
                }
            }

            // Smooth scroll for scroll indicator
            const scrollArrow = document.querySelector('.scroll-arrow');
            if (scrollArrow) {
                scrollArrow.addEventListener('click', function() {
                    const contactSection = document.querySelector('.contact-section');
                    if (contactSection) {
                        contactSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }



            // Notification function
            function showNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `notification notification-${type}`;
                notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Show notification
                setTimeout(() => {
                    notification.classList.add('show');
                }, 100);

                // Hide notification after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 5000);
            }
        });
    </script>
@endsection
