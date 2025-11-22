# Hướng dẫn thêm ảnh cho dịch vụ

## 🎯 Mục tiêu
Tạo giao diện đẹp và chuyên nghiệp cho các dịch vụ lái xe bằng cách thêm ảnh phù hợp.

## 📋 Các dịch vụ hiện có

### 1. Lái xe theo giờ
- **Slug**: `lai-xe-theo-gio`
- **Mô tả**: Tài xế chuyên nghiệp, phục vụ theo giờ
- **Ảnh đã cập nhật**: ✅

### 2. Lái xe theo chuyến  
- **Slug**: `lai-xe-theo-chuyen`
- **Mô tả**: Tài xế cho cả chuyến đi, giá cố định
- **Ảnh đã cập nhật**: ✅

### 3. Lái xe du lịch
- **Slug**: `lai-xe-du-lich`
- **Mô tả**: Tài xế du lịch, am hiểu các tuyến điểm
- **Ảnh đã cập nhật**: ✅

### 4. Lái xe đưa đón sân bay
- **Slug**: `lai-xe-dua-don-san-bay`
- **Mô tả**: Đưa đón sân bay chuyên nghiệp
- **Ảnh đã cập nhật**: ✅

## 🖼️ Nguồn ảnh miễn phí

### 1. Unsplash (Khuyến nghị)
- **Link**: https://unsplash.com
- **Ưu điểm**: Ảnh chất lượng cao, miễn phí
- **Từ khóa tìm kiếm**:
  - "professional driver"
  - "taxi service"
  - "car service"
  - "business driver"

### 2. Pexels
- **Link**: https://www.pexels.com
- **Ưu điểm**: Nhiều lựa chọn, dễ tìm kiếm
- **Từ khóa tìm kiếm**:
  - "driver"
  - "car service"
  - "transportation"

### 3. Pixabay
- **Link**: https://pixabay.com
- **Ưu điểm**: Có cả ảnh và vector
- **Từ khóa tìm kiếm**:
  - "driver"
  - "car"
  - "service"

## 🎨 Gợi ý ảnh cho từng dịch vụ

### Lái xe theo giờ
- Tài xế mặc vest chuyên nghiệp
- Xe sedan đen sang trọng
- Đồng hồ hoặc biểu tượng thời gian
- **Màu sắc**: Xanh navy, đen, trắng

### Lái xe theo chuyến
- Xe SUV hoặc minivan
- Tài xế đang kiểm tra bản đồ
- Cảnh đường cao tốc
- **Màu sắc**: Xanh lá, xanh dương

### Lái xe du lịch
- Xe du lịch với khách hàng
- Cảnh đẹp Việt Nam
- Biểu tượng du lịch
- **Màu sắc**: Vàng, cam, xanh lá

### Lái xe đưa đón sân bay
- Xe đang chờ ở sân bay
- Tài xế cầm bảng tên
- Sân bay với máy bay
- **Màu sắc**: Xanh dương, trắng, xám

## 📐 Kích thước ảnh khuyến nghị

- **Ảnh nền dịch vụ**: 800x600px hoặc 1200x800px
- **Icon**: 64x64px hoặc 128x128px
- **Format**: JPG (cho ảnh), PNG (cho icon)
- **Dung lượng**: < 500KB cho ảnh, < 100KB cho icon

## 🚀 Cách cập nhật ảnh

### Phương pháp 1: Sử dụng Command (Nhanh)
```bash
php artisan services:update-images
```

### Phương pháp 2: Qua Admin Panel
1. Vào **Admin Panel** → **Dịch vụ lái xe**
2. Chọn dịch vụ cần cập nhật
3. Upload ảnh vào trường **"Ảnh dịch vụ"**
4. Upload icon vào trường **"Icon dịch vụ"**
5. **Lưu** thay đổi

### Phương pháp 3: Cập nhật trực tiếp database
```php
$service = DriverService::where('slug', 'lai-xe-theo-gio')->first();
$service->update([
    'image' => 'https://example.com/image.jpg',
    'icon' => 'https://example.com/icon.png'
]);
```

## 🎯 Lưu ý quan trọng

### ✅ Nên làm:
- Chọn ảnh có màu sắc hài hòa với theme
- Đảm bảo ảnh rõ nét, không bị mờ
- Ưu tiên ảnh có cảm giác chuyên nghiệp
- Sử dụng ảnh có giấy phép miễn phí

### ❌ Tránh:
- Ảnh có text hoặc logo của công ty khác
- Ảnh có nội dung không phù hợp
- Ảnh có dung lượng quá lớn
- Ảnh có bản quyền

## 🔧 Troubleshooting

### Ảnh không hiển thị:
1. Kiểm tra URL ảnh có đúng không
2. Kiểm tra kết nối internet
3. Kiểm tra ảnh có tồn tại không

### Ảnh hiển thị chậm:
1. Giảm kích thước ảnh
2. Sử dụng CDN
3. Tối ưu hóa ảnh

### Ảnh bị méo:
1. Kiểm tra tỷ lệ khung hình
2. Sử dụng ảnh có kích thước phù hợp
3. Điều chỉnh CSS nếu cần

## 📱 Kiểm tra kết quả

Sau khi cập nhật ảnh, hãy kiểm tra:
1. **Trang dịch vụ**: `/services`
2. **Trang bảng giá**: `/pricing` (phần dịch vụ nổi bật)
3. **Trang chủ**: Phần bảng giá

## 🎉 Kết quả mong đợi

- Giao diện đẹp và chuyên nghiệp hơn
- Dễ dàng phân biệt các dịch vụ
- Tăng tính thẩm mỹ của website
- Cải thiện trải nghiệm người dùng
