@props([
    'showAddress' => true,
    'showPhone' => true,
    'showEmail' => true,
    'showWorkingTime' => false,
    'showSocial' => true,
    'class' => ''
])

@php
    use App\Helpers\ContactInfoHelper;
    $contactInfo = ContactInfoHelper::getContactInfoArray();
    $socialLinks = ContactInfoHelper::getSocialLinks();
@endphp

@if(ContactInfoHelper::hasContactInfo())
<div class="contact-info-simple {{ $class }}">
    @if($showAddress && !empty($contactInfo['address']))
        <div class="contact-item">
            <i class="bi bi-geo-alt"></i>
            <span>{{ $contactInfo['address'] }}</span>
        </div>
    @endif

    @if($showPhone && !empty($contactInfo['phone']))
        <div class="contact-item">
            <i class="bi bi-telephone"></i>
            <a href="tel:{{ $contactInfo['phone'] }}">
                {{ ContactInfoHelper::formatPhone($contactInfo['phone']) }}
            </a>
        </div>
    @endif

    @if($showEmail && !empty($contactInfo['email']))
        <div class="contact-item">
            <i class="bi bi-envelope"></i>
            <a href="mailto:{{ $contactInfo['email'] }}">
                {{ $contactInfo['email'] }}
            </a>
        </div>
    @endif

    @if($showWorkingTime && !empty($contactInfo['working_time']))
        <div class="contact-item">
            <i class="bi bi-clock"></i>
            <span>{{ $contactInfo['working_time'] }}</span>
        </div>
    @endif

    @if($showSocial && !empty($socialLinks))
        <div class="contact-social">
            @foreach($socialLinks as $platform => $social)
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener" 
                   class="social-link social-{{ $platform }}" 
                   title="{{ $social['name'] }}">
                    <i class="bi {{ $social['icon'] }}"></i>
                </a>
            @endforeach
        </div>
    @endif
</div>

<style>
.contact-info-simple {
    color: #666;
}

.contact-info-simple .contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.contact-info-simple .contact-item i {
    width: 16px;
    margin-right: 8px;
    color: #6f42c1;
}

.contact-info-simple .contact-item a {
    color: inherit;
    text-decoration: none;
}

.contact-info-simple .contact-item a:hover {
    color: #6f42c1;
}

.contact-info-simple .contact-social {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.contact-info-simple .social-link {
    width: 28px;
    height: 28px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    color: white;
    font-size: 0.8rem;
}

.contact-info-simple .social-facebook { background: #1877f2; }
.contact-info-simple .social-instagram { background: #e4405f; }
.contact-info-simple .social-youtube { background: #ff0000; }
.contact-info-simple .social-linkedin { background: #0077b5; }

.contact-info-simple .social-link:hover {
    opacity: 0.8;
    transform: translateY(-1px);
}
</style>
@endif
