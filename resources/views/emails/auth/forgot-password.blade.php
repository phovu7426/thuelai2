<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu cầu đặt lại mật khẩu - laixeho.net.vn</title>
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
        .header {
            background: linear-gradient(135deg, #ff8a00 0%, #e52e71 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .otp-code {
            background: #e9ecef;
            color: #495057;
            font-size: 28px;
            font-weight: bold;
            padding: 15px 25px;
            border-radius: 8px;
            text-align: center;
            margin: 25px 0;
            letter-spacing: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Đặt lại mật khẩu của bạn</h1>
    </div>
    
    <div class="content">
        <p>Xin chào,</p>
        <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong>laixeho.net.vn</strong>. Vui lòng sử dụng mã OTP dưới đây để tiếp tục:</p>
        
        <div class="otp-code">
            {{ $data['otp'] ?? 'N/A' }}
        </div>
        
        <p><strong>Lưu ý:</strong></p>
        <ul>
            <li>Mã OTP này chỉ có hiệu lực trong vòng 5 phút.</li>
            <li>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này và bảo mật tài khoản của bạn.</li>
        </ul>
        
        <p>Trân trọng,<br>
        <strong>Đội ngũ laixeho.net.vn</strong></p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} laixeho.net.vn - Dịch vụ tài xế thuê lái chuyên nghiệp</p>
        <p>Email này được gửi tự động, vui lòng không trả lời.</p>
    </div>
</body>
</html>