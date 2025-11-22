<?php

namespace App\Http\Controllers;

use App\Models\Testimonial as Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ContactInfoHelper;

class ReviewController extends Controller
{
    public function showReviewForm($token)
    {
        $review = Review::where('review_token', $token)
            ->whereNull('reviewed_at')
            ->first();

        if (!$review) {
            abort(404, 'Liên kết đánh giá không hợp lệ hoặc đã được sử dụng.');
        }

        return view('reviews.form', compact('review'));
    }

    public function submitReview(Request $request, $token)
    {
        $review = Review::where('review_token', $token)
            ->where(function($q){$q->where('status', false)->orWhere('status', 'pending');})
            ->first();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Liên kết đánh giá không hợp lệ hoặc đã được sử dụng.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|min:3|max:120',
            'comment' => 'nullable|string|min:10|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá',
            'rating.integer' => 'Số sao phải là số nguyên',
            'rating.min' => 'Số sao tối thiểu là 1',
            'rating.max' => 'Số sao tối đa là 5',
            'title.required' => 'Vui lòng nhập tiêu đề đánh giá',
            'title.min' => 'Tiêu đề phải có ít nhất 3 ký tự',
            'title.max' => 'Tiêu đề không được quá 120 ký tự',
            'comment.min' => 'Nhận xét phải có ít nhất 10 ký tự',
            'comment.max' => 'Nhận xét không được quá 1000 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $review->update([
                'rating' => $request->rating,
                'title' => $request->title,
                'content' => $request->comment,
                'reviewed_at' => now(),
                'status' => true,
                'is_featured' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã đánh giá dịch vụ! Chúng tôi sẽ xem xét và phản hồi sớm nhất.'
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Review submission error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'
            ], 500);
        }
    }

    public function sendReviewEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|min:10|max:20',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create review record
            $review = Review::create([
                'customer_name' => $request->name,
                'customer_title' => null,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'content' => '',
                'rating' => 5,
                'is_featured' => false,
                'status' => false, // chờ khách đánh giá xong admin mới bật
                'sort_order' => 0,
                'review_token' => bin2hex(random_bytes(16)),
            ]);

            $reviewUrl = route('review.form', $review->review_token);

            // Send email to customer
            Mail::send('emails.review-request', [
                'customerName' => $request->name,
                'reviewUrl' => $reviewUrl,
                'contactInfo' => ContactInfoHelper::getContactInfoArray()
            ], function ($message) use ($request) {
                $message->to($request->email, $request->name)
                        ->subject('Mời bạn đánh giá dịch vụ của chúng tôi');
            });

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi email mời đánh giá thành công đến ' . $request->email,
                'review_url' => $reviewUrl,
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Review email error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi email, vui lòng thử lại sau.'
            ], 500);
        }
    }
}

