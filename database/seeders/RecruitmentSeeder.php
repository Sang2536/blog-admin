<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recruitment;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = \App\Models\User::where('is_author', true)->pluck('id')->toArray();

        $position = [
            'Cộng tác viên nội dung',
            'Biên tập viên',
            'Biên tập viên nội dung',
            'Biên tập viên xuất bản',
            'Thành viên kỹ thuật',
            'Hỗ trợ kỹ thuật',
            'Quản lý cộng đồng',
            'Đánh giá bản thảo',
            'Dịch thuật',
            'Thiết kế',
            'Marketing nội dung',
            'Phóng viên',
            'Tổ chức sự kiện',
            'Cộng tác viên',
            'Tình nguyện viên',
            'Thực tập sinh',
        ];
        $locations = ['Online', 'Hà Nội', 'Thành phố Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Huế', 'Cần Thơ'];
        $types = ['full-time', 'part-time', 'remote', 'hybrid', 'contract'];

        foreach ($position as $index => $item) {
            $jobTitle = fake()->jobTitle();
            Recruitment::create([
                'user_id' => $userIds[array_rand($userIds)],
                'title' => $jobTitle,
                'slug' => str()->slug($jobTitle) . '-' . uniqid(),
                'description' => fake()->paragraph(5),
                'position' => $item,
                'location' => fake()->randomElement($locations),
                'type' => fake()->randomElement($types),
                'start_date' => now()->subDays(rand(10, 30)),
                'end_date' => now()->addDays(rand(10, 30)),
                'is_active' => true,
            ]);
        }
    }
}
