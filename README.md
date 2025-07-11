# 📝 blog-admin

`blog-admin` là hệ thống quản trị nội dung (CMS) dành cho một blog cá nhân hoặc tổ chức, được phát triển bằng **Laravel**. 

Dự án tập trung vào khả năng quản lý bài viết, danh mục, thẻ, người dùng, bình luận và media với giao diện dễ sử dụng và khả năng mở rộng cao.

Dự án được phát triển với mục đích học tập & triển khai cá nhân. Mọi đóng góp đều được hoan nghênh!

---

## 📦 Cài đặt

```bash
# Clone project
git clone https://github.com/tenban/blog-admin.git
cd blog-admin

# Cài đặt package
composer install

# Tạo file cấu hình môi trường
cp .env.example .env

# Cấu hình biến môi trường
vi .env    # hoặc code .env

# Generate APP_KEY
php artisan key:generate

# Migrate + seed dữ liệu mẫu (nếu có)
php artisan migrate --seed

# Khởi chạy server
php artisan serve
```

---

## ⚙️ Tài khoản mẫu (dữ liệu seed)
Email: admin@example.com
Mật khẩu: password

---

## 🚀 Tính năng chính

- ✅ Quản lý bài viết (viết, sửa, xoá, đăng nháp, xuất bản)
- ✅ Quản lý danh mục & thẻ bài viết
- ✅ Trình soạn thảo nội dung hỗ trợ Markdown hoặc WYSIWYG
- ✅ Quản lý media (ảnh, video) với trình tải lên
- ✅ Quản lý bình luận (duyệt, ẩn, xoá)
- ✅ Quản lý người dùng & phân quyền
- ✅ Tối ưu SEO (slug, meta title, meta description)
- ✅ Giao diện admin hiện đại, responsive
- ✅ Tích hợp API hỗ trợ giao diện frontend VueJS

---

## 🛠️ Công nghệ sử dụng

- [Laravel 10.x](https://laravel.com/)
- [MySQL / MariaDB](https://www.mysql.com/)
- [TailwindCSS](https://tailwindcss.com/)
- [VueJS (Frontend riêng biệt)](https://vuejs.org/)
- [Spatie Laravel Permission](https://github.com/spatie/laravel-permission)
- [Laravel Sanctum](https://laravel.com/docs/sanctum) (cho xác thực API)

---

