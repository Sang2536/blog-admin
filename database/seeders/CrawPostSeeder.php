<?php

namespace Database\Seeders;

use App\Models\MediaFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Post;
use App\Models\User;

class CrawPostSeeder extends Seeder
{
    public function run(): void
    {
        try {
            //  kiểm tra user
            if (!User::count()) {
                echo "⚠️ Không tìm thấy user nào.\n";
                $this->command->info('Đang tự động tạo user ngẫu nhiên.');

                if (!User::where('email', 'admin@example.com')->exists()) {
                    User::create([
                        'name' => 'Admin User',
                        'email' => 'admin@example.com',
                        'email_verified_at' => now(),
                        'password' => Hash::make('password'),
                        'remember_token' => Str::random(10),
                        'is_admin' => true,
                        'is_author' => true,
                        'is_active' => true,
                        'avatar' => null,
                    ]);
                }
                User::factory()->count(10)->create();
            }

            $user = User::get()->random();

            $tags = \App\Models\Tag::pluck('id')->toArray();

            // Giả định HTML lấy từ trang chủ zing: https://znews.vn/
            // $html = file_get_contents(storage_path('app/mock/zing.html'));
            $html = file_get_contents('https://znews.vn/');

            $crawler = new Crawler($html);
            $articles = $crawler->filter('article.article-item');

            $articles->each(function (Crawler $node) use ($user, $tags) {
                $title = $node->filter('.article-title a')->text();
                $url = $node->filter('.article-title a')->attr('href');
                $slug = Str::slug($title);
                $excerpt = $node->filter('.article-summary')->text() ?? '';
                $thumbnail = $node->filter('.article-thumbnail img')->attr('src');

                // Check article tồn tại?
                if (Post::where('slug', $slug)->exists()) {
                    echo "⚠️ Đã tồn tại. Bỏ qua: $title\n";
                    return;
                }

                $htmlContent = file_get_contents($url);
                $crawlerContent = new Crawler($htmlContent);
                $articleContent = $crawlerContent->filter('div.the-article-body');

                $post = Post::create([
                    'user_id' => $user->id,
                    'category_id' => 1,
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $excerpt,
                    'content' => $articleContent,
                    'status' => 'published',
                    'is_featured' => random_int(0, 1) === 1,
                    'views' => rand(0, 10000),
                    'published_at' => now(),
                ]);

                $mediaFile = MediaFile::create([
                    'name' => $title,
                    'file_path' => $thumbnail,
                    'mime_type' => 'image/jpeg',
                    'size' => rand(10000, 500000),
                    'user_id' => $user->id,
                ]);

                $post->tags()->attach(array_rand(array_flip($tags), random_int(1, 4)));
                $post->media()->attach(array_rand(array_flip($mediaFile)));

                echo "✅ Đã thêm: $title\n";
            });
        } catch (\Throwable $th) {
            echo "Đã có lỗi xảy ra. Lỗi: " . $th->getMessage();
        }
    }
}
