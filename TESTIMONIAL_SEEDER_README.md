# Testimonial Seeder - Đánh giá 5 sao mẫu

## Mô tả
Seeder này tạo ra 23 đánh giá 5 sao mẫu cho dịch vụ thuê tài xế, giống như đánh giá thật từ khách hàng.

## Tính năng
- **23 đánh giá 5 sao** với nội dung đa dạng
- **Đánh giá từ nhiều ngành nghề khác nhau**: Giám đốc, Bác sĩ, Kỹ sư, Giáo viên, Nhân viên văn phòng, v.v.
- **Nội dung thực tế**: Mô tả chi tiết trải nghiệm sử dụng dịch vụ
- **Thông tin khách hàng**: Tên, chức danh, email, số điện thoại
- **Thời gian đánh giá**: Phân bố trong 23 ngày gần đây
- **Đánh giá nổi bật**: 7 đánh giá được đánh dấu là featured
- **Thời gian đánh giá**: Phân bố trong 23 ngày gần đây

## Cách sử dụng

### 1. Chạy seeder riêng lẻ
```bash
php artisan db:seed --class=TestimonialSeeder
```

### 2. Chạy tất cả seeders
```bash
php artisan db:seed
```

### 3. Chạy với fresh database
```bash
php artisan migrate:fresh --seed
```

## Cấu trúc dữ liệu

### Các trường chính:
- `customer_name`: Tên khách hàng
- `customer_title`: Chức danh/chức vụ
- `title`: Tiêu đề đánh giá
- `content`: Nội dung chi tiết đánh giá
- `rating`: Đánh giá sao (luôn là 5)
- `is_featured`: Có phải đánh giá nổi bật không
- `status`: Trạng thái hiển thị
- `sort_order`: Thứ tự sắp xếp
- `customer_email`: Email khách hàng
- `customer_phone`: Số điện thoại
- `reviewed_at`: Thời gian đánh giá

### Ngành nghề khách hàng:
1. Giám đốc Công ty TNHH ABC
2. Chủ doanh nghiệp
3. Kỹ sư xây dựng
4. Bác sĩ
5. Giáo viên
6. Nhân viên văn phòng
7. Chủ nhà hàng
8. Nhân viên bán hàng
9. Kế toán trưởng
10. Kỹ sư IT
11. Nhân viên marketing
12. Chủ xưởng sản xuất
13. Nhân viên tư vấn
14. Nhân viên kinh doanh
15. Nhân viên hành chính
16. Nhân viên ngân hàng
17. Luật sư
18. Nhân viên bảo hiểm
19. Nhân viên bất động sản
20. Nhân viên du lịch
21. Nhân viên y tế
22. Nhân viên giáo dục
23. Nhân viên tài chính

## Lưu ý
- Tất cả đánh giá đều có rating = 5 sao
- 7 đánh giá được đánh dấu là featured (nổi bật)
- Thời gian đánh giá được phân bố từ 1-23 ngày trước
- Email và số điện thoại được tạo theo format thực tế
- Nội dung đánh giá phản ánh trải nghiệm thực tế của từng ngành nghề

## Tùy chỉnh
Bạn có thể chỉnh sửa file `database/seeders/TestimonialSeeder.php` để:
- Thay đổi số lượng đánh giá
- Điều chỉnh nội dung đánh giá
- Thay đổi thông tin khách hàng
- Cập nhật rating hoặc các trường khác
