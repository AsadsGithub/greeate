<?php

namespace Greeate\Greeate\Database\Seeders;

use Greeate\Greeate\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'native_name' => 'English', 'direction' => 'ltr', 'is_default' => true, 'is_active' => true, 'sort_order' => 1],
            ['name' => 'Arabic', 'code' => 'ar', 'native_name' => 'العربية', 'direction' => 'rtl', 'is_default' => false, 'is_active' => true, 'sort_order' => 2],
            ['name' => 'Urdu', 'code' => 'ur', 'native_name' => 'اردو', 'direction' => 'rtl', 'is_default' => false, 'is_active' => true, 'sort_order' => 3],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], $lang);
        }
    }
}
