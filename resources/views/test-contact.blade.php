<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Contact Info System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Test Contact Info System</h1>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Helper Test</h3>
                @php
                    use App\Helpers\ContactInfoHelper;
                    $contactInfo = ContactInfoHelper::getContactInfoArray();
                    $socialLinks = ContactInfoHelper::getSocialLinks();
                    $hasContact = ContactInfoHelper::hasContactInfo();
                @endphp
                
                <div class="card">
                    <div class="card-body">
                        <h5>Contact Info Array:</h5>
                        <pre>{{ json_encode($contactInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        
                        <h5>Social Links:</h5>
                        <pre>{{ json_encode($socialLinks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        
                        <h5>Has Contact: {{ $hasContact ? 'Yes' : 'No' }}</h5>
                        
                        <h5>Individual Fields:</h5>
                        <ul>
                            <li>Phone: {{ ContactInfoHelper::get('phone') ?: 'Empty' }}</li>
                            <li>Email: {{ ContactInfoHelper::get('email') ?: 'Empty' }}</li>
                            <li>Address: {{ ContactInfoHelper::get('address') ?: 'Empty' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h3>Global Variable Test</h3>
                <div class="card">
                    <div class="card-body">
                        <h5>$globalContactInfo:</h5>
                        <pre>{{ json_encode($globalContactInfo ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h3>Component Test</h3>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Full Component</h5>
                        <div class="border p-3">
                            <x-contact-info />
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Simple Component</h5>
                        <div class="border p-3 bg-dark text-light">
                            <x-contact-info-simple />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h3>Database Test</h3>
                <div class="card">
                    <div class="card-body">
                        @php
                            try {
                                $dbContact = \App\Models\ContactInfo::first();
                                if ($dbContact) {
                                    echo "<h5>Database Record Found:</h5>";
                                    echo "<pre>" . json_encode($dbContact->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
                                } else {
                                    echo "<h5 class='text-warning'>No database record found</h5>";
                                }
                            } catch (\Exception $e) {
                                echo "<h5 class='text-danger'>Database Error: " . $e->getMessage() . "</h5>";
                            }
                        @endphp
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <h3>Service Test</h3>
                <div class="card">
                    <div class="card-body">
                        @php
                            try {
                                $service = app(\App\Services\Admin\ContactInfoService::class);
                                $firstContact = $service->getFirstOrCreate();
                                echo "<h5>Service getFirstOrCreate():</h5>";
                                echo "<pre>" . json_encode($firstContact->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre>";
                            } catch (\Exception $e) {
                                echo "<h5 class='text-danger'>Service Error: " . $e->getMessage() . "</h5>";
                            }
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
