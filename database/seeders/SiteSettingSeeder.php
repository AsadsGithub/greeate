<?php

namespace Greeate\Greeate\Database\Seeders;

use Greeate\Greeate\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Greeate', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'hello@greeate.com', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_phone', 'value' => '', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_address', 'value' => '', 'type' => 'text', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'UTC', 'type' => 'text', 'group' => 'general'],
            ['key' => 'default_language', 'value' => 'en', 'type' => 'text', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'USD', 'type' => 'text', 'group' => 'general'],
            ['key' => 'copyright', 'value' => '© '.date('Y').' Greeate. All rights reserved.', 'type' => 'text', 'group' => 'general'],
            ['key' => 'primary_color', 'value' => '#6366f1', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'secondary_color', 'value' => '#8b5cf6', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'dark_mode_default', 'value' => 'false', 'type' => 'boolean', 'group' => 'theme'],
            ['key' => 'layout_type', 'value' => 'sidebar', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'activity_log_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'activity-log'],
            ['key' => 'firebase_server_key', 'value' => '', 'type' => 'text', 'group' => 'firebase'],
            ['key' => 'firebase_project_id', 'value' => '', 'type' => 'text', 'group' => 'firebase'],
            ['key' => 'firebase_sender_id', 'value' => '', 'type' => 'text', 'group' => 'firebase'],
            ['key' => 'firebase_api_key', 'value' => '', 'type' => 'text', 'group' => 'firebase'],
            ['key' => 'firebase_vapid_key', 'value' => '', 'type' => 'text', 'group' => 'firebase'],
            ['key' => 'support_email', 'value' => 'support@greeate.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'support_phone', 'value' => '', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'meta_title', 'value' => 'Greeate - Modern SaaS Admin', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Modern SaaS Admin Panel for Laravel', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'laravel,admin,saas', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
