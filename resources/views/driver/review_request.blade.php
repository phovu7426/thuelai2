@extends('driver.layouts.main')

@section('page_title', 'Gửi yêu cầu đánh giá dịch vụ')

@section('content')
<section class="booking-section">
    <div class="container">
        <div class="booking-content">
            <div class="section-header">
                <h2 class="section-title">Gửi yêu cầu đánh giá</h2>
                <p class="section-subtitle">Điền thông tin để nhận email đánh giá dịch vụ</p>
            </div>

            <div class="booking-form-container">
                <form class="booking-form-modern" id="reviewInviteForm">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Họ và tên</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Số điện thoại (tuỳ chọn)</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-submit">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            <span>Gửi email đánh giá</span>
                        </button>
                    </div>

                    <div id="devLink" class="mt-3" style="display:none;">
                        <small><strong>Dev:</strong> Link đánh giá trực tiếp: <a href="#" id="devReviewUrl" target="_blank"></a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reviewInviteForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = form.querySelector('.btn-submit');
        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Đang gửi...</span>';

        const formData = new FormData(form);
        fetch('{{ route('review.send-email') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                if (data.review_url) {
                    const devLink = document.getElementById('devLink');
                    const devReviewUrl = document.getElementById('devReviewUrl');
                    devReviewUrl.href = data.review_url;
                    devReviewUrl.textContent = data.review_url;
                    devLink.style.display = 'block';
                }
            } else {
                alert(data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Có lỗi xảy ra, vui lòng thử lại');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = original;
        });
    });
});
</script>
@endsection






