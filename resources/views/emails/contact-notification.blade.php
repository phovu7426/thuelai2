<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo liên hệ mới</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .info-section {
            margin-bottom: 25px;
        }
        .info-section h3 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #555;
        }
        .info-value {
            flex: 1;
            color: #333;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .topic-badge {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .timestamp {
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Thông báo liên hệ mới</h1>
        </div>

        <div class="info-section">
            <h3>📋 Thông tin khách hàng</h3>
            <div class="info-row">
                <div class="info-label">Họ tên:</div>
                <div class="info-value">{{ $contactData['name'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">
                    <a href="mailto:{{ $contactData['email'] }}" style="color: #007bff; text-decoration: none;">
                        {{ $contactData['email'] }}
                    </a>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Số điện thoại:</div>
                <div class="info-value">
                    <a href="tel:{{ $contactData['phone'] }}" style="color: #007bff; text-decoration: none;">
                        {{ $contactData['phone'] }}
                    </a>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Chủ đề:</div>
                <div class="info-value">
                    <span class="topic-badge">{{ $contactData['topic'] }}</span>
                </div>
            </div>
            @if($contactData['subject'])
            <div class="info-row">
                <div class="info-label">Tiêu đề:</div>
                <div class="info-value">{{ $contactData['subject'] }}</div>
            </div>
            @endif
        </div>

        <div class="info-section">
            <h3>💬 Nội dung tin nhắn</h3>
            <div class="message-content">
                {{ $contactData['message'] }}
            </div>
        </div>

        <div class="info-section">
            <h3>🔍 Thông tin kỹ thuật</h3>
            <div class="info-row">
                <div class="info-label">IP Address:</div>
                <div class="info-value">{{ $contactData['ip_address'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Thời gian:</div>
                <div class="info-value timestamp">{{ $contactData['submitted_at'] }}</div>
            </div>
        </div>

        <div class="footer">
            <p>Email này được gửi tự động từ hệ thống website.</p>
            <p>Vui lòng phản hồi khách hàng trong thời gian sớm nhất.</p>
        </div>
    </div>
</body>
</html>
