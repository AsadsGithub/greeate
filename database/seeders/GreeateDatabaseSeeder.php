<?php

namespace Greeate\Greeate\Database\Seeders;

use Illuminate\Database\Seeder;

class GreeateDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            LanguageSeeder::class,
            SiteSettingSeeder::class,
            SuperAdminSeeder::class,
            StaticPageSeeder::class,
        ]);
    }
}
