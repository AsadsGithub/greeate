<?php

namespace Greeate\Greeate\Database\Seeders;

use Greeate\Greeate\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            ['slug' => 'privacy-policy', 'title' => 'Privacy Policy', 'content' => '<p>Your privacy policy content here.</p>', 'status' => 'published'],
            ['slug' => 'terms-and-conditions', 'title' => 'Terms & Conditions', 'content' => '<p>Your terms and conditions here.</p>', 'status' => 'published'],
        ];

        foreach ($pages as $page) {
            StaticPage::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}
