# Website-Ban-Gundam (Gundam Model Shop)

Chào mừng bạn đến với dự án **Website Bán Mô Hình Gundam**! Đây là một ứng dụng web thương mại điện tử đơn giản được xây dựng bằng PHP, chuyên cung cấp các mô hình Gundam chính hãng.

## 🚀 Tính Năng Nổi Bật

- **Trang chủ (Home):** Hiển thị banner nổi bật, các danh mục sản phẩm, và các sản phẩm nổi bật/mới nhất.
- **Danh mục sản phẩm (Categories):** Phân loại mô hình theo các cấp độ (ví dụ: SD, HG, RG, MG, PG...).
- **Chi tiết sản phẩm (Product Details):** Xem thông tin chi tiết về mô hình, giá cả, và mô tả.
- **Giỏ hàng (Cart):** Thêm sản phẩm vào giỏ hàng, cập nhật số lượng, và xóa sản phẩm.
- **Thanh toán (Checkout):** Xử lý đặt hàng cơ bản.
- **Tìm kiếm (Search):** Tìm kiếm sản phẩm theo tên.

## 🛠 Công Nghệ Sử Dụng

- **Backend:** PHP thuần (Native PHP) với kiến trúc cơ bản (Models, Views, Core).
- **Cơ sở dữ liệu:** MySQL (Sử dụng PDO để kết nối và thao tác dữ liệu).
- **Frontend:** HTML5, CSS3, JavaScript.
- **UI Framework/Thư viện:** Bootstrap 5, FontAwesome (Icons).

## 📁 Cấu Trúc Thư Mục

- `admin/`: Thư mục dành cho trang quản trị (Dashboard, quản lý sản phẩm, đơn hàng...).
- `core/`: Chứa các file cấu hình hệ thống, kết nối database (`database.php`), các hàm hỗ trợ chung (`functions.php`).
- `models/`: Chứa các lớp Model thao tác trực tiếp với cơ sở dữ liệu (`ProductModel.php`, `CategoryModel.php`...).
- `views/`: Chứa các file giao diện người dùng (giao diện header, footer, layout).
- `public/`: Chứa các tài nguyên tĩnh như CSS, JS, hình ảnh (`public/assets/css/styles.css`).
- `*.php`: Các trang chức năng chính như `index.php`, `products.php`, `cart.php`, `checkout.php`...
- `lamlaidoan_db.sql`: File script cơ sở dữ liệu để khởi tạo cấu trúc các bảng và dữ liệu mẫu.

## ⚙️ Hướng Dẫn Cài Đặt

1. **Clone repository:**
   ```bash
   git clone <URL_repository_của_bạn>
   cd Website-Ban-Gundam
   ```

2. **Cài đặt Web Server:**
   - Bạn cần một môi trường máy chủ ảo như **XAMPP**, **WAMP**, hoặc **Laragon** có hỗ trợ PHP và MySQL.
   - Di chuyển thư mục dự án vào thư mục gốc của web server (ví dụ: `htdocs` đối với XAMPP).

3. **Cấu hình Cơ sở dữ liệu:**
   - Mở phpMyAdmin (thường ở địa chỉ `http://localhost/phpmyadmin`).
   - Tạo một cơ sở dữ liệu mới (ví dụ: `lamlaidoan_db`).
   - Import file `lamlaidoan_db.sql` có sẵn trong thư mục gốc của dự án vào cơ sở dữ liệu vừa tạo.

4. **Cấu hình kết nối DB:**
   - Mở file `core/database.php` (hoặc file cấu hình tương ứng).
   - Kiểm tra và cập nhật các thông số kết nối (Tên DB, Username, Password) sao cho khớp với cấu hình MySQL trên máy của bạn.

5. **Chạy ứng dụng:**
   - Mở trình duyệt và truy cập: `http://localhost/Website-Ban-Gundam` (đường dẫn có thể thay đổi tùy thuộc vào tên thư mục dự án trên web server của bạn).

## 📝 Thông Tin Thêm

Dự án này là một ví dụ tuyệt vời để tìm hiểu về cách xây dựng một trang web thương mại điện tử cơ bản với PHP thuần và MySQL.
