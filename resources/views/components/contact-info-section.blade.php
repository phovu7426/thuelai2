{{-- Component hiển thị thông tin liên hệ --}}
<div class="contact-info-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">Thông tin liên hệ</h2>
                <p class="section-subtitle">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn mọi vấn đề</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Gọi điện thoại --}}
            @if ($contactPhone)
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <h4>Gọi điện thoại</h4>
                        <p class="contact-value">{{ $contactPhone }}</p>
                        <p class="contact-desc">{{ $contactWorkingTime ?: 'Hỗ trợ 24/7' }}</p>
                    </div>
                </div>
            @endif

            {{-- Gửi email --}}
            @if ($contactEmail)
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <h4>Gửi email</h4>
                        <p class="contact-value">{{ $contactEmail }}</p>
                        <p class="contact-desc">Phản hồi trong 2h</p>
                    </div>
                </div>
            @endif

            {{-- Chat trực tuyến --}}
            @if (!empty($globalSocialLinks))
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h4>Chat trực tuyến</h4>
                        <p class="contact-value">
                            @if (isset($globalSocialLinks['facebook']))
                                Zalo, Facebook
                            @else
                                Liên hệ trực tiếp
                            @endif
                        </p>
                        <p class="contact-desc">Phản hồi ngay lập tức</p>
                    </div>
                </div>
            @endif

            {{-- Văn phòng --}}
            @if ($contactAddress)
                <div class="col-lg-3 col-md-6">
                    <div class="contact-card text-center">
                        <div class="contact-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h4>Văn phòng</h4>
                        <p class="contact-value">{{ $contactAddress }}</p>
                        <p class="contact-desc">{{ $contactAddress }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .contact-info-section {
        padding: 32px 0 !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 0.65rem !important;
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .contact-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.15);
    }

    .contact-icon {
        width: 48px !important;
        height: 48px !important;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
    }

    .contact-card h4 {
        font-size: 1rem !important;
        font-weight: 600;
        margin-bottom: 5px !important;
    }

    .contact-value {
        font-size: 0.9rem !important;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #ffd700;
        word-break: break-all;
        overflow-wrap: break-word;
        max-width: 100%;
    }

    .contact-desc {
        font-size: 0.77rem !important;
        margin-top: 2px !important;
        opacity: 0.8;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .contact-info-section {
            padding: 20px 0 !important;
        }

        .section-title {
            font-size: 2rem;
        }

        .contact-card {
            padding: 0.65rem !important;
        }
    }
</style>
