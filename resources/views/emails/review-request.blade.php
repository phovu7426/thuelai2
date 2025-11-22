<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu đánh giá dịch vụ - laixeho.net.vn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
        .highlight {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌟 Đánh giá dịch vụ laixeho.net.vn</h1>
        <p>Chúng tôi rất mong nhận được phản hồi từ bạn!</p>
    </div>
    
    <div class="content">
        <p>Xin chào <strong>{{ $customerName }}</strong>,</p>
        
        <p>Cảm ơn bạn đã sử dụng dịch vụ của <strong>laixeho.net.vn</strong>!</p>
        
        <p>Để cải thiện chất lượng dịch vụ và phục vụ bạn tốt hơn, chúng tôi rất mong nhận được đánh giá của bạn về trải nghiệm sử dụng dịch vụ.</p>
        
        <div class="highlight">
            <strong>💡 Đánh giá của bạn rất quan trọng với chúng tôi!</strong><br>
            Chỉ mất 2 phút để hoàn thành và giúp chúng tôi phục vụ tốt hơn.
        </div>
        
        <p>Vui lòng click vào nút bên dưới để thực hiện đánh giá:</p>
        
        <div style="text-align: center;">
            <a href="{{ $reviewUrl }}" class="btn">📝 Đánh giá ngay</a>
        </div>
        
        <p><strong>Hoặc copy link này vào trình duyệt:</strong></p>
        <p style="word-break: break-all; color: #667eea;">{{ $reviewUrl }}</p>
        
        <p><strong>Thông tin đánh giá:</strong></p>
        <ul>
            <li>Họ và tên: {{ $customerName }}</li>
            <li>Dịch vụ: Dịch vụ tài xế</li>
        </ul>
        
        <p><strong>Lưu ý:</strong></p>
        <ul>
            <li>Link đánh giá chỉ có hiệu lực một lần</li>
            <li>Đánh giá của bạn sẽ được xem xét trước khi hiển thị công khai</li>
            <li>Mọi thông tin cá nhân sẽ được bảo mật tuyệt đối</li>
        </ul>
        
        <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:</p>
        <ul>
            @if(isset($contactInfo['phone']) && !empty($contactInfo['phone']))
                <li>📞 Hotline: {{ $contactInfo['phone'] }}</li>
            @else
                <li>📞 Hotline: 1900 1234</li>
            @endif
            
            @if(isset($contactInfo['email']) && !empty($contactInfo['email']))
                <li>📧 Email: {{ $contactInfo['email'] }}</li>
            @else
                <li>📧 Email: info@thuelai.vn</li>
            @endif
            
            <li>💬 Chat trực tuyến tại website</li>
        </ul>
        
        <p>Trân trọng,<br>
        <strong>Đội ngũ laixeho.net.vn</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} laixeho.net.vn - Dịch vụ tài xế thuê lái chuyên nghiệp</p>
        <p>Email này được gửi tự động, vui lòng không trả lời trực tiếp</p>
    </div>
</body>
</html>

