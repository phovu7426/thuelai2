<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Contact Info Components</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Demo Contact Info Components</h1>
        
        <!-- Component đầy đủ với layout vertical -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component đầy đủ - Layout Vertical</h2>
                <div class="border p-4 rounded">
                    <x-contact-info />
                </div>
            </div>
        </div>

        <!-- Component với layout grid -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component với Layout Grid</h2>
                <div class="border p-4 rounded">
                    <x-contact-info layout="grid" />
                </div>
            </div>
        </div>

        <!-- Component với layout horizontal -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component với Layout Horizontal</h2>
                <div class="border p-4 rounded">
                    <x-contact-info layout="horizontal" />
                </div>
            </div>
        </div>

        <!-- Component chỉ hiển thị một số thông tin -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component tùy chỉnh (chỉ phone, email, social)</h2>
                <div class="border p-4 rounded">
                    <x-contact-info 
                        :show-address="false" 
                        :show-working-time="false" 
                        :show-title="false" />
                </div>
            </div>
        </div>

        <!-- Component đơn giản cho footer -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component đơn giản (cho Footer)</h2>
                <div class="border p-4 rounded bg-dark text-light">
                    <x-contact-info-simple />
                </div>
            </div>
        </div>

        <!-- Component đơn giản chỉ hiển thị phone và email -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Component đơn giản (chỉ phone và email)</h2>
                <div class="border p-4 rounded">
                    <x-contact-info-simple 
                        :show-address="false" 
                        :show-social="false" />
                </div>
            </div>
        </div>

        <!-- Sử dụng Helper trực tiếp -->
        <div class="row mb-5">
            <div class="col-12">
                <h2>Sử dụng Helper trực tiếp</h2>
                <div class="border p-4 rounded">
                    @php
                        use App\Helpers\ContactInfoHelper;
                    @endphp
                    
                    <p><strong>Địa chỉ:</strong> {{ ContactInfoHelper::get('address') ?: 'Chưa cập nhật' }}</p>
                    <p><strong>Điện thoại:</strong> {{ ContactInfoHelper::get('phone') ?: 'Chưa cập nhật' }}</p>
                    <p><strong>Email:</strong> {{ ContactInfoHelper::get('email') ?: 'Chưa cập nhật' }}</p>
                    <p><strong>Thời gian làm việc:</strong> {{ ContactInfoHelper::get('working_time') ?: 'Chưa cập nhật' }}</p>
                    
                    @if(ContactInfoHelper::hasContactInfo())
                        <p class="text-success">✓ Đã có thông tin liên hệ</p>
                    @else
                        <p class="text-warning">⚠ Chưa có thông tin liên hệ</p>
                    @endif

                    <h5>Social Links:</h5>
                    @php $socialLinks = ContactInfoHelper::getSocialLinks(); @endphp
                    @if(!empty($socialLinks))
                        <ul>
                            @foreach($socialLinks as $platform => $social)
                                <li>
                                    <a href="{{ $social['url'] }}" target="_blank">
                                        <i class="bi {{ $social['icon'] }}"></i> {{ $social['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Chưa có liên kết mạng xã hội</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hướng dẫn sử dụng -->
        <div class="row">
            <div class="col-12">
                <h2>Hướng dẫn sử dụng</h2>
                <div class="border p-4 rounded bg-light">
                    <h5>1. Component đầy đủ:</h5>
                    <code>&lt;x-contact-info /&gt;</code>
                    
                    <h5 class="mt-3">2. Component với tùy chọn:</h5>
                    <code>&lt;x-contact-info layout="grid" :show-address="false" :show-map="true" /&gt;</code>
                    
                    <h5 class="mt-3">3. Component đơn giản:</h5>
                    <code>&lt;x-contact-info-simple :show-social="false" /&gt;</code>
                    
                    <h5 class="mt-3">4. Sử dụng Helper:</h5>
                    <code>ContactInfoHelper::get('phone')</code><br>
                    <code>ContactInfoHelper::getSocialLinks()</code><br>
                    <code>ContactInfoHelper::hasContactInfo()</code>
                    
                    <h5 class="mt-3">5. Sử dụng biến global trong view:</h5>
                    <code>{{ '$globalContactInfo' }}</code> - Mảng chứa tất cả thông tin liên hệ
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
