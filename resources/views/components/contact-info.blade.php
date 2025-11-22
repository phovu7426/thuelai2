@props([
    'showTitle' => true,
    'showAddress' => true,
    'showPhone' => true,
    'showEmail' => true,
    'showWorkingTime' => true,
    'showSocial' => true,
    'showMap' => false,
    'layout' => 'vertical', // vertical, horizontal, grid
    'class' => ''
])

@php
    use App\Helpers\ContactInfoHelper;
    $contactInfo = ContactInfoHelper::getContactInfoArray();
    $socialLinks = ContactInfoHelper::getSocialLinks();
@endphp

@if(ContactInfoHelper::hasContactInfo())
<div class="contact-info {{ $class }}" data-layout="{{ $layout }}">
    @if($showTitle)
        <h3 class="contact-info-title">
            <i class="bi bi-telephone-fill"></i>
            Liên hệ
        </h3>
    @endif

    <div class="contact-info-content {{ $layout === 'grid' ? 'row' : '' }}">
        @if($showAddress && !empty($contactInfo['address']))
            <div class="contact-info-item {{ $layout === 'grid' ? 'col-md-6 mb-3' : 'mb-3' }}">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Địa chỉ</h5>
                        <p>{{ $contactInfo['address'] }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($showPhone && !empty($contactInfo['phone']))
            <div class="contact-info-item {{ $layout === 'grid' ? 'col-md-6 mb-3' : 'mb-3' }}">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Hotline</h5>
                        <p>
                            <a href="tel:{{ $contactInfo['phone'] }}" class="contact-link">
                                {{ ContactInfoHelper::formatPhone($contactInfo['phone']) }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($showEmail && !empty($contactInfo['email']))
            <div class="contact-info-item {{ $layout === 'grid' ? 'col-md-6 mb-3' : 'mb-3' }}">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Email</h5>
                        <p>
                            <a href="mailto:{{ $contactInfo['email'] }}" class="contact-link">
                                {{ $contactInfo['email'] }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($showWorkingTime && !empty($contactInfo['working_time']))
            <div class="contact-info-item {{ $layout === 'grid' ? 'col-md-6 mb-3' : 'mb-3' }}">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="contact-details">
                        <h5>Thời gian</h5>
                        <p>{{ $contactInfo['working_time'] }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($showSocial && !empty($socialLinks))
        <div class="contact-social mt-4">
            <h5>Kết nối với chúng tôi</h5>
            <div class="social-links">
                @foreach($socialLinks as $platform => $social)
                    <a href="{{ $social['url'] }}" target="_blank" rel="noopener" 
                       class="social-link social-{{ $platform }}" 
                       title="{{ $social['name'] }}">
                        <i class="bi {{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    @if($showMap && !empty($contactInfo['map_embed']))
        <div class="contact-map mt-4">
            <h5>Bản đồ</h5>
            <div class="map-container">
                {!! $contactInfo['map_embed'] !!}
            </div>
        </div>
    @endif
</div>

<style>
.contact-info {
    padding: 20px;
}

.contact-info-title {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.5rem;
    font-weight: 600;
}

.contact-info-title i {
    color: #6f42c1;
    margin-right: 10px;
}

.contact-card {
    display: flex;
    align-items: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #6f42c1;
    transition: all 0.3s ease;
    height: 100%;
}

.contact-card:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(111, 66, 193, 0.1);
}

.contact-icon {
    width: 50px;
    height: 50px;
    background: #6f42c1;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.contact-icon i {
    color: white;
    font-size: 1.2rem;
}

.contact-details h5 {
    margin: 0 0 5px 0;
    color: #333;
    font-weight: 600;
    font-size: 1rem;
}

.contact-details p {
    margin: 0;
    color: #666;
    font-size: 0.95rem;
}

.contact-link {
    color: #6f42c1;
    text-decoration: none;
    font-weight: 500;
}

.contact-link:hover {
    color: #5a2d91;
    text-decoration: underline;
}

.social-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    color: white;
}

.social-facebook { background: #1877f2; }
.social-instagram { background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); }
.social-youtube { background: #ff0000; }
.social-linkedin { background: #0077b5; }

.social-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    color: white;
}

.map-container {
    position: relative;
    width: 100%;
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
}

.map-container iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Layout variations */
.contact-info[data-layout="horizontal"] .contact-info-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.contact-info[data-layout="horizontal"] .contact-info-item {
    flex: 1;
    min-width: 250px;
}

@media (max-width: 768px) {
    .contact-info[data-layout="horizontal"] .contact-info-content {
        flex-direction: column;
    }
    
    .contact-card {
        padding: 15px;
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        margin-right: 12px;
    }
    
    .contact-icon i {
        font-size: 1rem;
    }
}
</style>
@endif
