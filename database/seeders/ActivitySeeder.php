<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $userIds = \App\Models\User::where('is_author', true)->pluck('id')->toArray();

        $activities = [
            [
                'type' => 'event',
                'name' => 'Tang Tình Tang Tính Tình Tang – Hành Trình Lan Tỏa Giá Trị Văn Hóa Miền Tây Nam Bộ Qua Góc Nhìn Người Trẻ (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'event',
                'name' => 'Sự Kiện Hobby Horizon 2025 – Lễ Hội Văn Hóa Mô Hình & Cosplay Nhật Bản Quy Mô Nhất Trong Năm',
                'location' => 'HCM',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận 10.000.000 Đồng Từ Cuộc Thi Văn Học - Viết Chữa Lành 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận Ngay Voucher Các Khóa Học, Thời Trang Và Giải Trí Từ Cuộc Thi Root2Rise 2025 Do Dự Án Bloom&Blow Tổ Chức (Miễn Phí Tham Dự)',
                'location' => 'Online',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận Khoá Học Miễn Phí Từ Cuộc Thi Viết Review Sách “Reader\'s Soul" Dự Án Bookademy (100% Người Tham Gia Nhận Giấy Chứng Nhận, Miễn Phí Tham Dự, Liên Tục Hàng Tháng)',
                'location' => 'Online',
            ],
            [
                'type' => 'event',
                'name' => 'Triển Lãm Tranh Từ Trẻ Khuyết Tật Lần 3 - Embrace Diversity: Khi Sự Khác Biệt Dệt Nên Thế Giới 2025 (miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận 30 Triệu Đồng Từ Cuộc Thi Thiết Kế Biểu Trưng (Logo) Của Phường Với Chủ Đề “Phường Sài Gòn - Hội Tụ Và Tỏa Sáng” 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'event',
                'name' => 'Workshop Logistics: The Mastery Quest - From Local To Global 2025 (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'event',
                'name' => 'Triển Lãm Nghệ Thuật Đương Đại: Tái Chất Hoàn Sinh - Vật Chất Tái Sinh - Materia Renata 2025 (Miễn Phí Tham Dự)',
                'location' => 'HN',
            ],
            [
                'type' => 'event',
                'name' => 'Webinar: "Emotional Resilience - Strengthening Your Mind To Overcome Challenges" 2025 (Miễn Phí Tham Dự)',
                'location' => 'Online',
            ],
            [
                'type' => 'event',
                'name' => 'Triển Lãm Tranh "Miền Ký Ức" - "The Realm Of Memories" Năm 2025 (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'event',
                'name' => 'Chương Trình Dành Cho Các Bạn Sinh Viên Mong Muốn Tìm Hiểu Về Học Bổng Thạc Sĩ Erasmus Mundus - Du Học Châu Âu 2025 (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận $300 Từ Cuộc Thi Viết Biopage Storytelling Writing Contest Năm 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn cầu',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận Giải Thưởng Lên Đến 6.000.000 VND Từ Cuộc Thi Viết Review Sách Thư Đàm Cổ Nguyệt Được Tổ Chức Bởi Cổ Nguyệt Đường 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Thứ Sức Bản Thân Tại Cuộc Thi Marketing Challengers 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận Được Giải Thưởng Lên Đến 90 Triệu Đồng Từ Cuộc Thi Thiết Kế Thời Trang Pierre Cardin – Young Designers Award 2025 (Miễn Phí Tham Dự)',
                'location' => 'Online',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận €5000 Từ Cuộc Thi Thiết Kế Child Resistant Closure Design 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn cầu',
            ],
            [
                'type' => 'event',
                'name' => 'Triển Lãm Quốc Tế Thể Thao Và Giải Trí Việt Nam 2025 (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
            [
                'type' => 'competition',
                'name' => 'Cuộc Thi Toa Sách Hạnh Phúc - Học Bổng Acecook 2025',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ hội nhận €5000 từ cuộc thi thiết kế - Tamper Evident Closure Design 2025 (Miễn Phí Tham Dự)',
                'location' => 'Toàn quốc',
            ],
            [
                'type' => 'competition',
                'name' => 'Cơ Hội Nhận Học Bổng Toàn Phần Học Phí Tại Học Viện Thiết Kế Và Thời Trang London Từ Cuộc Thi Thiết Kế: Việt Nam - Nơi Tôi Sống 2025 (Miễn Phí Tham Dự)',
                'location' => 'Online',
            ],
            [
                'type' => 'event',
                'name' => 'Chương Trình Huấn Luyện Startup MasterTrack - 9 Modules Kiến Tạo Doanh Nghiệp Bền Vững 2025 (Miễn Phí Tham Dự)',
                'location' => 'HCM',
            ],
        ];

        foreach ($activities as $activity) {
            $slug = Str::slug($activity['name']);

            Activity::create([
                'user_id' => $userIds[array_rand($userIds)],
                'type' => $activity['type'],
                'name' => $activity['name'],
                'slug' => $slug,
                'image' => null,
                'link' => 'https://example.com/' . $activity['type'] . '/' . $slug,
                'location' => $activity['location'],
                'start_date' => fake()->dateTimeBetween('-1 month', '+1 month'),
                'end_date' => fake()->dateTimeBetween('+1 month', '+2 months'),
                'deadline' => fake()->dateTimeBetween('-1 month', '+1 week'),
                'description' => fake()->paragraph(3),
            ]);
        }
    }
}
