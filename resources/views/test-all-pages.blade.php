<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test All Updated Pages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">🎉 Test All Updated Pages</h1>

        <div class="row g-4">
            {{-- Admin Panel --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-gear-fill"></i> Admin Panel</h5>
                    </div>
                    <div class="card-body">
                        <p>Quản lý thông tin liên hệ từ admin panel</p>
                        <div class="d-grid gap-2">
                            <a href="/admin/contact-info" class="btn btn-primary" target="_blank">
                                <i class="bi bi-shield-lock"></i> Admin Contact Info
                            </a>
                            <a href="/test/admin-contact-info" class="btn btn-outline-primary" target="_blank">
                                <i class="bi bi-tools"></i> Test Admin Form
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Global Variables --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-globe"></i> Global Variables</h5>
                    </div>
                    <div class="card-body">
                        <p>Test các biến global contact info</p>
                        <div class="d-grid gap-2">
                            <a href="/test/global-contact" class="btn btn-success" target="_blank">
                                <i class="bi bi-code-square"></i> Test Global Variables
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Updated Pages --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-house-fill"></i> Updated Home Page</h5>
                    </div>
                    <div class="card-body">
                        <p>Trang chủ đã được cập nhật với dữ liệu từ admin</p>
                        <div class="d-grid gap-2">
                            <a href="/test/home-updated" class="btn btn-info" target="_blank">
                                <i class="bi bi-house"></i> View Updated Home
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-info" target="_blank">
                                <i class="bi bi-arrow-right"></i> Original Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Page --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bi bi-telephone-fill"></i> Updated Contact Page</h5>
                    </div>
                    <div class="card-body">
                        <p>Trang liên hệ đã được cập nhật với dữ liệu từ admin</p>
                        <div class="d-grid gap-2">
                            <a href="/test/contact-updated" class="btn btn-warning" target="_blank">
                                <i class="bi bi-telephone"></i> View Updated Contact
                            </a>
                            <a href="{{ route('home.contact') }}" class="btn btn-outline-warning" target="_blank">
                                <i class="bi bi-arrow-right"></i> Original Contact
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Driver Layout Footer --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-layout-text-window-reverse"></i> Driver Layout Footer</h5>
                    </div>
                    <div class="card-body">
                        <p>Footer trong driver layout đã được cập nhật</p>
                        <div class="d-grid gap-2">
                            <a href="/test/driver-layout" class="btn btn-danger" target="_blank">
                                <i class="bi bi-layout-text-window-reverse"></i> View Driver Layout
                            </a>
                            <a href="{{ route('driver.home') }}" class="btn btn-outline-danger" target="_blank">
                                <i class="bi bi-arrow-right"></i> Original Driver
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Empty slot for grid alignment --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-light text-dark">
                        <h5 class="mb-0"><i class="bi bi-check-circle-fill text-success"></i> All Updated!</h5>
                    </div>
                    <div class="card-body">
                        <p>Tất cả các trang đã được cập nhật thành công!</p>
                        <div class="alert alert-success">
                            <strong>✅ Hoàn thành:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Admin Panel</li>
                                <li>Global Variables</li>
                                <li>Home Page</li>
                                <li>Contact Page</li>
                                <li>Driver Footer</li>
                                <li>Social Links</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Current Data Preview --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-eye-fill"></i> Current Contact Data Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>📞 Contact Information:</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> {{ $contactPhone ?: 'Not set' }}</li>
                                    <li><strong>Email:</strong> {{ $contactEmail ?: 'Not set' }}</li>
                                    <li><strong>Address:</strong> {{ $contactAddress ?: 'Not set' }}</li>
                                    <li><strong>Working Time:</strong> {{ $contactWorkingTime ?: 'Not set' }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>🌐 Social Media Links:</h6>
                                @if (!empty($globalSocialLinks))
                                    <ul class="list-unstyled">
                                        @foreach ($globalSocialLinks as $key => $social)
                                            <li>
                                                <i class="{{ $social['icon'] }}"></i>
                                                <strong>{{ $social['name'] }}:</strong>
                                                <a href="{{ $social['url'] }}" target="_blank"
                                                    class="text-decoration-none">
                                                    {{ $social['url'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No social links configured</p>
                                @endif
                            </div>
                        </div>

                        @if ($contactMapEmbed)
                            <div class="mt-3">
                                <h6>🗺️ Map Embed:</h6>
                                <div class="border rounded p-2" style="height: 200px; overflow: hidden;">
                                    {!! $contactMapEmbed !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Instructions --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5><i class="bi bi-info-circle-fill"></i> Hướng dẫn sử dụng:</h5>
                    <ol>
                        <li><strong>Cập nhật thông tin:</strong> Truy cập Admin Panel để thay đổi thông tin liên hệ</li>
                        <li><strong>Kiểm tra Global Variables:</strong> Xem các biến global có hoạt động không</li>
                        <li><strong>Test Updated Pages:</strong> Kiểm tra trang chủ và trang liên hệ đã cập nhật</li>
                        <li><strong>So sánh:</strong> So sánh với trang gốc để thấy sự khác biệt</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Components Test --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bi bi-puzzle-fill"></i> Components Test</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Contact Info Section Component:</h6>
                                @include('components.contact-info-section')
                            </div>
                            <div class="col-md-6">
                                <h6>Footer Contact Component:</h6>
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @include('components.footer-contact')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
