<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Global Contact Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Test Global Contact Variables</h1>
        
        {{-- Test các biến global --}}
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Biến Global Contact Info 2</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <td><strong>$contactPhone:</strong></td>
                                <td>{{ $contactPhone ?: 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <td><strong>$contactEmail:</strong></td>
                                <td>{{ $contactEmail ?: 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <td><strong>$contactAddress:</strong></td>
                                <td>{{ $contactAddress ?: 'Chưa có' }}</td>
                            </tr>
                            <tr>
                                <td><strong>$contactWorkingTime:</strong></td>
                                <td>{{ $contactWorkingTime ?: 'Chưa có' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Global Social Links</h5>
                    </div>
                    <div class="card-body">
                        @if(!empty($globalSocialLinks))
                            <div class="list-group">
                                @foreach($globalSocialLinks as $key => $social)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="{{ $social['icon'] }} me-2"></i>
                                        <strong>{{ $social['name'] }}:</strong>
                                    </div>
                                    <a href="{{ $social['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Xem
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Chưa có social links</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Test Array đầy đủ --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Global Contact Info Array</h5>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 rounded">{{ json_encode($globalContactInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Test Helper Methods --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Test Helper Methods</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>ContactInfoHelper::get() method:</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Phone:</strong> {{ \App\Helpers\ContactInfoHelper::get('phone') }}</li>
                                    <li><strong>Email:</strong> {{ \App\Helpers\ContactInfoHelper::get('email') }}</li>
                                    <li><strong>Address:</strong> {{ \App\Helpers\ContactInfoHelper::get('address') }}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Other Helper Methods:</h6>
                                <ul class="list-unstyled">
                                    <li><strong>Has Contact Info:</strong> {{ \App\Helpers\ContactInfoHelper::hasContactInfo() ? 'Yes' : 'No' }}</li>
                                    <li><strong>Formatted Phone:</strong> {{ \App\Helpers\ContactInfoHelper::formatPhone(\App\Helpers\ContactInfoHelper::get('phone')) }}</li>
                                    <li><strong>Social Links Count:</strong> {{ count(\App\Helpers\ContactInfoHelper::getSocialLinks()) }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Test Components --}}
    <div class="mt-5">
        <h2 class="text-center mb-4">Test Contact Info Section Component</h2>
        @include('components.contact-info-section')
    </div>
    
    <div class="mt-5">
        <h2 class="text-center mb-4">Test Footer Component</h2>
        @include('components.footer-contact')
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
