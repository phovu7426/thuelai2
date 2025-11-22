{{-- Component footer với thông tin liên hệ --}}
<footer class="main-footer">
    <div class="container">
        <div class="row g-4">
            {{-- Thông tin công ty --}}
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title">Cơ sở sản xuất đá ốp lát DN</h5>
                    <p class="footer-desc">
                        Chúng tôi chuyên cung cấp các loại đá tự nhiên cao cấp với chất lượng tốt nhất 
                        và dịch vụ chuyên nghiệp.
                    </p>
                    
                    {{-- Social Links --}}
                    @if(!empty($globalSocialLinks))
                    <div class="social-links">
                        @foreach($globalSocialLinks as $key => $social)
                        <a href="{{ $social['url'] }}" target="_blank" class="social-link" title="{{ $social['name'] }}">
                            <i class="{{ $social['icon'] }}"></i>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Thông tin liên hệ --}}
            <div class="col-lg-4 col-md-6">
                <div class="footer-section">
                    <h5 class="footer-title">Thông tin liên hệ</h5>
                    
                    @if($contactAddress)
                    <div class="contact-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span>{{ $contactAddress }}</span>
                    </div>
                    @endif
                    
                    @if($contactPhone)
                    <div class="contact-item">
                        <i class="bi bi-telephone-fill"></i>
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $contactPhone) }}">{{ $contactPhone }}</a>
                    </div>
                    @endif
                    
                    @if($contactEmail)
                    <div class="contact-item">
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                    </div>
                    @endif
                    
                    @if($contactWorkingTime)
                    <div class="contact-item">
                        <i class="bi bi-clock-fill"></i>
                        <span>{{ $contactWorkingTime }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Bản đồ nhúng --}}
            @if($contactMapEmbed)
            <div class="col-lg-4 col-md-12">
                <div class="footer-section">
                    <h5 class="footer-title">Vị trí</h5>
                    <div class="map-container">
                        {!! $contactMapEmbed !!}
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        {{-- Copyright --}}
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        © {{ date('Y') }} Cơ sở sản xuất đá ốp lát DN. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Trang chủ</a>
                        <a href="{{ route('home.about') }}">Giới thiệu</a>
                        <a href="{{ route('home.contact') }}">Liên hệ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.main-footer {
    background: #2c3e50;
    color: #ecf0f1;
    padding: 60px 0 0;
    margin-top: auto;
}

.footer-section {
    margin-bottom: 2rem;
}

.footer-title {
    color: #3498db;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
}

.footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 50px;
    height: 2px;
    background: #3498db;
}

.footer-desc {
    color: #bdc3c7;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-link {
    width: 40px;
    height: 40px;
    background: #34495e;
    color: #ecf0f1;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.1rem;
}

.social-link:hover {
    background: #3498db;
    color: white;
    transform: translateY(-2px);
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    color: #bdc3c7;
}

.contact-item i {
    color: #3498db;
    width: 20px;
    margin-right: 10px;
    font-size: 1rem;
}

.contact-item a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-item a:hover {
    color: #3498db;
}

.map-container {
    border-radius: 8px;
    overflow: hidden;
    height: 200px;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

.footer-bottom {
    border-top: 1px solid #34495e;
    padding: 20px 0;
    margin-top: 40px;
}

.copyright {
    color: #95a5a6;
    margin: 0;
    font-size: 0.9rem;
}

.footer-links {
    display: flex;
    gap: 20px;
    justify-content: flex-end;
}

.footer-links a {
    color: #95a5a6;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #3498db;
}

@media (max-width: 768px) {
    .main-footer {
        padding: 40px 0 0;
    }
    
    .footer-links {
        justify-content: flex-start;
        margin-top: 10px;
    }
    
    .social-links {
        justify-content: flex-start;
    }
    
    .map-container {
        height: 150px;
    }
}
</style>
