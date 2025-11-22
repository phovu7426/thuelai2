<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đánh giá dịch vụ - laixeho.net.vn</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
        }

        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }

        .customer-info h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item i {
            color: #667eea;
            width: 20px;
        }

        .rating-section {
            margin-bottom: 30px;
        }

        .rating-section h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .stars {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }

        .star {
            font-size: 3rem;
            color: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .star:hover,
        .star.active {
            color: #ffd700;
            transform: scale(1.1);
        }

        .star.selected {
            color: #ffd700;
        }

        .rating-text {
            text-align: center;
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .comment-section {
            margin-bottom: 30px;
        }

        .comment-section h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            resize: vertical;
            min-height: 120px;
            transition: border-color 0.3s ease;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 18px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.success {
            background: #28a745;
        }

        .notification.error {
            background: #dc3545;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 0.9rem;
            border-top: 1px solid #eee;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .content {
                padding: 30px 20px;
            }

            .stars {
                gap: 5px;
            }

            .star {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-star"></i> Đánh giá dịch vụ</h1>
            <p>Cảm ơn bạn đã sử dụng dịch vụ của laixeho.net.vn!</p>
        </div>

        <div class="content">
            <div class="customer-info">
                <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <i class="fas fa-user"></i>
                        <span><strong>Họ tên:</strong> {{ $review->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span><strong>Email:</strong> {{ $review->customer_email }}</span>
                    </div>
                    @if($review->customer_phone)
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <span><strong>SĐT:</strong> {{ $review->customer_phone }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <i class="fas fa-car"></i>
                        <span><strong>Dịch vụ:</strong> Dịch vụ tài xế</span>
                    </div>
                </div>
            </div>

            <form id="reviewForm">
                <div class="rating-section">
                    <h3><i class="fas fa-star"></i> Đánh giá chất lượng dịch vụ</h3>
                    <div class="stars">
                        <i class="star" data-rating="1" aria-label="1 sao">★</i>
                        <i class="star" data-rating="2" aria-label="2 sao">★</i>
                        <i class="star" data-rating="3" aria-label="3 sao">★</i>
                        <i class="star" data-rating="4" aria-label="4 sao">★</i>
                        <i class="star" data-rating="5" aria-label="5 sao">★</i>
                    </div>
                    <div class="rating-text" id="ratingText">Vui lòng chọn số sao đánh giá</div>
                </div>

                <div class="comment-section">
                    <h3><i class="fas fa-comment"></i> Nhận xét của bạn</h3>
                    <div class="form-group">
                        <label for="title">Tiêu đề đánh giá</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            placeholder="Ví dụ: Rất hài lòng về chuyến đi" 
                            style="width:100%;padding:12px;border:2px solid #e1e5e9;border-radius:10px;font-size:1rem;">
                    </div>
                    <div class="form-group">
                        <label for="comment">Nội dung đánh giá (không bắt buộc)</label>
                        <textarea 
                            id="comment" 
                            name="comment" 
                            placeholder="Ví dụ: Tài xế rất thân thiện, xe sạch sẽ, dịch vụ chuyên nghiệp..."></textarea>
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Gửi đánh giá</span>
                </button>
            </form>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} laixeho.net.vn - Dịch vụ tài xế thuê lái chuyên nghiệp</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedRating = 0;
            const stars = document.querySelectorAll('.star');
            const ratingText = document.getElementById('ratingText');
            const form = document.getElementById('reviewForm');
            const submitBtn = document.getElementById('submitBtn');

            // Star rating functionality
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    selectedRating = rating;
                    
                    // Update stars
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('selected');
                        } else {
                            s.classList.remove('selected');
                        }
                    });

                    // Update rating text
                    const ratingTexts = [
                        'Rất không hài lòng',
                        'Không hài lòng',
                        'Bình thường',
                        'Hài lòng',
                        'Rất hài lòng'
                    ];
                    ratingText.textContent = ratingTexts[rating - 1];
                });

                // Hover effects
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });

                star.addEventListener('mouseleave', function() {
                    stars.forEach(s => s.classList.remove('active'));
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (selectedRating === 0) {
                    showNotification('Vui lòng chọn số sao đánh giá', 'error');
                    return;
                }

                const formData = new FormData();
                formData.append('rating', selectedRating);
                formData.append('title', document.getElementById('title').value);
                formData.append('comment', document.getElementById('comment').value);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Disable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang gửi...</span>';

                // Send request
                fetch('{{ route("review.submit", $review->review_token) }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification(data.message, 'success');
                        // Redirect after 2 seconds
                        setTimeout(() => {
                            window.location.href = '{{ route("driver.home") }}';
                        }, 2000);
                    } else {
                        showNotification(data.message || 'Có lỗi xảy ra', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
                })
                .finally(() => {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i><span>Gửi đánh giá</span>';
                });
            });

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `notification ${type}`;
                notification.innerHTML = `
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                    ${message}
                `;
                
                document.body.appendChild(notification);
                
                // Show notification
                setTimeout(() => {
                    notification.classList.add('show');
                }, 100);
                
                // Hide notification after 5 seconds
                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 5000);
            }
        });
    </script>
</body>
</html>

