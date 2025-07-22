<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $privacyAndCopyright = [
            //  Social network
            ['key' => 'facebook', 'value' => 'https://facebook.com', 'type' => 'social_network'],
            ['key' => 'twitter', 'value' => 'https://twitter.com', 'type' => 'social_network'],
            ['key' => 'instagram', 'value' => 'https://instagram.com', 'type' => 'social_network'],
            ['key' => 'youtube', 'value' => 'https://youtube.com', 'type' => 'social_network'],
            ['key' => 'linkedin', 'value' => 'https://linkedin.com', 'type' => 'social_network'],
            ['key' => 'github', 'value' => 'https://github.com', 'type' => 'social_network'],
            ['key' => 'pinterest', 'value' => 'https://pinterest.com', 'type' => 'social_network'],
            ['key' => 'reddit', 'value' => 'https://reddit.com', 'type' => 'social_network'],
            ['key' => 'tumblr', 'value' => 'https://tumblr.com', 'type' => 'social_network'],
            ['key' => 'snapchat', 'value' => 'https://snapchat.com', 'type' => 'social_network'],
            ['key' => 'whatsapp', 'value' => 'https://whatsapp.com', 'type' => 'social_network'],
            ['key' => 'telegram', 'value' => 'https://telegram.com', 'type' => 'social_network'],
            ['key' => 'discord', 'value' => 'https://discord.com', 'type' => 'social_network'],
            ['key' => 'tiktok', 'value' => 'https://tiktok.com', 'type' => 'social_network'],

            //  Privacy and copyright
            ['key' => 'terms_of_use', 'value' => 'Temerms of Use', 'type' => 'privacy_and_copyright'],
            ['key' => 'terms_of_service', 'value' => 'Terms of Service', 'type' => 'privacy_and_copyright'],
            ['key' => 'terms_of_sale', 'value' => 'Terms of Sale', 'type' => 'privacy_and_copyright'],
            ['key' => 'privacy_policy', 'value' => 'Privacy Policy', 'type' => 'privacy_and_copyright'],
            ['key' => 'refund_policy', 'value' => 'Refund Policy', 'type' => 'privacy_and_copyright'],
            ['key' => 'cookie_policy', 'value' => 'Cookie Policy', 'type' => 'privacy_and_copyright'],
            ['key' => 'disclaimer', 'value' => 'Disclaimer', 'type' => 'privacy_and_copyright'],
            ['key' => 'legal_notice', 'value' => 'Legal Notice', 'type' => 'privacy_and_copyright'],

            //  Technical
            ['key' => 'web_version', 'value' => '1.0.0', 'type' => 'technical'],
            ['key' => 'web_build', 'value' => '2025-07-11', 'type' => 'technical'],
            ['key' => 'theme', 'value' => 'Default', 'type' => 'technical'],
            ['key' => 'author', 'value' => 'My', 'type' => 'technical'],
            ['key' => 'cms', 'value' => 'aravel + VueJS', 'type' => 'technical'],
            ['key' => 'framework', 'value' => 'Laravel', 'type' => 'technical'],
            ['key' => 'language', 'value' => 'PHP', 'type' => 'technical'],
            ['key' => 'database', 'value' => 'MySQL', 'type' => 'technical'],
            ['key' => 'server', 'value' => 'Nginx', 'type' => 'technical'],
            ['key' => 'hosting', 'value' => 'Digital Ocean', 'type' => 'technical'],

            //  SEO
            ['key' => 'meta_title', 'value' => 'Blog Cuộc sống & Code', 'type' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Chia sẻ bài viết, hướng dẫn và cảm hứng sống.', 'type' => 'seo'],
            ['key' => 'og_image', 'value' => 'https://myblog.com/og.jpg', 'type' => 'seo'],
        ];

        foreach($privacyAndCopyright as $item) {
            \App\Models\Option::create([
                'key' => $item['key'],
                'value' => $item['value'],
                'type' => $item['type'],
            ]);
        }
    }
}
