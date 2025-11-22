<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverContact;
use App\Mail\ContactNotification;
use App\Helpers\ContactInfoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:20',
            'topic' => 'required|in:khiếu nại,tư vấn dịch vụ,phản hồi,khác',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
            'topic.required' => 'Vui lòng chọn chủ đề',
            'topic.in' => 'Chủ đề không hợp lệ',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Save to database
            $contact = DriverContact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'topic' => $request->topic,
                'subject' => $request->subject ?: 'Liên hệ từ website',
                'message' => $request->message,
                'status' => 'unread',
            ]);

            // Prepare email data
            $emailData = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'topic' => $request->topic,
                'subject' => $request->subject ?: 'Liên hệ từ website',
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'submitted_at' => now()->format('d/m/Y H:i:s'),
            ];

            // Send email notification to configured email address
            $contactInfo = ContactInfoHelper::getContactInfoArray();
            $adminEmail = $contactInfo['email'] ?? 'info@thuelai.vn';
            
            if (!empty($adminEmail)) {
                try {
                    Mail::to($adminEmail)->send(new ContactNotification($emailData));
                    \Illuminate\Support\Facades\Log::info('Contact notification email sent to: ' . $adminEmail);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send contact notification email: ' . $e->getMessage());
                }
            }

            // Log the contact message
            \Illuminate\Support\Facades\Log::info('Contact form submission', $emailData);

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'
            ], 500);
        }
    }
}
