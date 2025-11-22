{{-- Ví dụ sử dụng Contact Info trong các layout khác nhau --}}

{{-- 1. Trong Header --}}
<header class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="logo">
                    <img src="/logo.png" alt="Logo">
                </div>
            </div>
            <div class="col-md-6 text-end">
                {{-- Hiển thị phone trong header --}}
                @if(!empty($globalContactInfo['phone']))
                    <a href="tel:{{ $globalContactInfo['phone'] }}" class="btn btn-primary">
                        <i class="bi bi-telephone"></i> {{ $globalContactInfo['phone'] }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

{{-- 2. Trong Footer --}}
<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Về chúng tôi</h5>
                <p>Mô tả về công ty...</p>
            </div>
            <div class="col-md-4">
                <h5>Thông tin liên hệ</h5>
                <x-contact-info-simple />
            </div>
            <div class="col-md-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Trang chủ</a></li>
                    <li><a href="#" class="text-light">Dịch vụ</a></li>
                    <li><a href="#" class="text-light">Liên hệ</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

{{-- 3. Trang Contact đầy đủ --}}
<section class="contact-page py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2>Liên hệ với chúng tôi</h2>
                <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                {{-- Form liên hệ --}}
                <div class="contact-form">
                    <h4>Gửi tin nhắn</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Họ tên">
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Tiêu đề">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Nội dung"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi tin nhắn</button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                {{-- Thông tin liên hệ --}}
                <x-contact-info :show-title="false" :show-map="true" />
            </div>
        </div>
    </div>
</section>

{{-- 4. Sidebar thông tin liên hệ --}}
<aside class="sidebar">
    <div class="widget">
        <x-contact-info layout="vertical" class="contact-widget" />
    </div>
</aside>

{{-- 5. Popup/Modal liên hệ nhanh --}}
<div class="modal fade" id="quickContactModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Liên hệ nhanh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <x-contact-info-simple :show-working-time="true" />
                
                <hr>
                
                <div class="quick-actions">
                    @if(!empty($globalContactInfo['phone']))
                        <a href="tel:{{ $globalContactInfo['phone'] }}" class="btn btn-success w-100 mb-2">
                            <i class="bi bi-telephone"></i> Gọi ngay
                        </a>
                    @endif
                    
                    @if(!empty($globalContactInfo['email']))
                        <a href="mailto:{{ $globalContactInfo['email'] }}" class="btn btn-primary w-100">
                            <i class="bi bi-envelope"></i> Gửi email
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 6. Floating contact button --}}
<div class="floating-contact">
    @if(!empty($globalContactInfo['phone']))
        <a href="tel:{{ $globalContactInfo['phone'] }}" class="floating-btn phone-btn" title="Gọi ngay">
            <i class="bi bi-telephone-fill"></i>
        </a>
    @endif
    
    @php $socialLinks = \App\Helpers\ContactInfoHelper::getSocialLinks(); @endphp
    @if(!empty($socialLinks['facebook']))
        <a href="{{ $socialLinks['facebook']['url'] }}" target="_blank" class="floating-btn facebook-btn" title="Facebook">
            <i class="bi bi-facebook"></i>
        </a>
    @endif
</div>

{{-- 7. Breadcrumb với thông tin liên hệ --}}
<div class="breadcrumb-section bg-light py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Liên hệ</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 text-end">
                @if(!empty($globalContactInfo['phone']))
                    <small class="text-muted">
                        <i class="bi bi-telephone"></i> {{ $globalContactInfo['phone'] }}
                    </small>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- 8. Card thông tin liên hệ trong trang chủ --}}
<section class="home-contact py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3>Liên hệ với chúng tôi</h3>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8 mx-auto">
                <x-contact-info layout="grid" :show-title="false" />
            </div>
        </div>
    </div>
</section>

<style>
/* Custom styles cho các ví dụ */
.floating-contact {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.floating-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.floating-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    color: white;
}

.phone-btn {
    background: #28a745;
}

.facebook-btn {
    background: #1877f2;
}

.contact-widget {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.quick-actions .btn {
    font-weight: 500;
}

@media (max-width: 768px) {
    .floating-contact {
        bottom: 15px;
        right: 15px;
    }
    
    .floating-btn {
        width: 45px;
        height: 45px;
    }
}
</style>
