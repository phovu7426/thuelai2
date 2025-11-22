<div style="background: #f6f6f6; padding: 32px 0; font-family: 'Segoe UI', Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); overflow: hidden;">
        <div style="background: linear-gradient(90deg, #b993d6 0%, #8ca6db 100%); padding: 32px 24px 16px 24px; color: #fff;">
            <h1 style="margin: 0 0 8px 0; font-size: 2.2rem; font-weight: bold; letter-spacing: 1px;">Xin chào Quản trị viên 👋</h1>
            <p style="margin: 0; font-size: 1.1rem;">Bạn vừa nhận được một liên hệ mới từ khách hàng trên website <strong>{{ config('app.name') ?? 'N/A' }}</strong>.</p>
        </div>
        <div style="padding: 28px 24px 16px 24px;">
            <h2 style="margin-top: 0; color: #8ca6db; font-size: 1.3rem; font-weight: 600; letter-spacing: 0.5px;">Thông tin khách hàng</h2>
            <table style="width: 100%; border-collapse: collapse; font-size: 1.05rem;">
                <tr>
                    <td style="padding: 8px 0; color: #555; width: 140px; font-weight: 500;">Họ và tên:</td>
                    <td style="padding: 8px 0; color: #222; font-weight: bold;">{{ $contactData['name'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: 500;">Email:</td>
                    <td style="padding: 8px 0; color: #222;">{{ $contactData['email'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: 500;">Số điện thoại:</td>
                    <td style="padding: 8px 0; color: #222;">{{ $contactData['phone'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: 500;">Tiêu đề:</td>
                    <td style="padding: 8px 0; color: #222;">{{ $contactData['subject'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #555; font-weight: 500; vertical-align: top;">Nội dung:</td>
                    <td style="padding: 8px 0; color: #222; background: #f3f7fa; border-radius: 6px;">
                        <div style="white-space: pre-line; font-size: 1.08rem;">{{ $contactData['message'] ?? 'N/A' }}</div>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 32px; padding: 18px 20px; background: #e0e7ff; border-radius: 8px; color: #333; font-size: 1.08rem;">
                <strong>Lưu ý:</strong> Vui lòng kiểm tra và phản hồi khách hàng sớm nhất có thể để nâng cao trải nghiệm dịch vụ.
            </div>
            <div style="margin-top: 36px; text-align: right; color: #888; font-size: 1rem;">
                <em>Trân trọng,<br>Hệ thống website {{ config('app.name') ?? 'N/A' }}</em>
            </div>
        </div>
        <div style="background: #f3f7fa; padding: 16px 24px; text-align: center; color: #aaa; font-size: 0.98rem; border-top: 1px solid #e5e7eb;">
            Email này được gửi tự động từ website. Vui lòng không trả lời lại email này.
        </div>
    </div>
</div> 