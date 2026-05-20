<?php

return [
    'name' => 'Greeate',
    'version' => '1.0.0',

    'route_prefix' => env('GREEATE_ROUTE_PREFIX', 'greeate'),
    'admin_prefix' => env('GREEATE_ADMIN_PREFIX', 'admin'),
    'api_prefix' => env('GREEATE_API_PREFIX', 'api/v1'),

    'guard' => env('GREEATE_GUARD', 'web'),
    'admin_guard' => env('GREEATE_ADMIN_GUARD', 'web'),

    'super_admin_role' => 'super-admin',

    'default_admin' => [
        'name' => env('GREEATE_ADMIN_NAME', 'Super Admin'),
        'email' => env('GREEATE_ADMIN_EMAIL', 'admin@greeate.com'),
        'password' => env('GREEATE_ADMIN_PASSWORD', 'password'),
    ],

    'pagination' => [
        'per_page' => 15,
        'max_per_page' => 100,
    ],

    'upload' => [
        'disk' => env('GREEATE_UPLOAD_DISK', 'public'),
        'max_size' => 5120,
        'allowed_images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'allowed_files' => ['pdf', 'doc', 'docx', 'xls', 'xlsx'],
        'thumbnails' => [
            'small' => [150, 150],
            'medium' => [400, 400],
            'large' => [800, 800],
        ],
    ],

    'maintenance' => [
        'ip_whitelist' => array_filter(explode(',', env('GREEATE_MAINTENANCE_IPS', ''))),
    ],

    'modules' => [
        'admins' => true,
        'roles' => true,
        'permissions' => true,
        'banners' => true,
        'faqs' => true,
        'languages' => true,
        'notifications' => true,
        'activity_logs' => true,
        'site_settings' => true,
        'contact_messages' => true,
        'static_pages' => true,
    ],

    'repositories' => [
        \Greeate\Greeate\Models\Admin::class => \Greeate\Greeate\Repositories\AdminRepository::class,
        \Greeate\Greeate\Models\Banner::class => \Greeate\Greeate\Repositories\BannerRepository::class,
        \Greeate\Greeate\Models\Faq::class => \Greeate\Greeate\Repositories\FaqRepository::class,
        \Greeate\Greeate\Models\Language::class => \Greeate\Greeate\Repositories\LanguageRepository::class,
        \Greeate\Greeate\Models\ContactMessage::class => \Greeate\Greeate\Repositories\ContactMessageRepository::class,
        \Greeate\Greeate\Models\StaticPage::class => \Greeate\Greeate\Repositories\StaticPageRepository::class,
        \Greeate\Greeate\Models\SiteSetting::class => \Greeate\Greeate\Repositories\SiteSettingRepository::class,
        \Greeate\Greeate\Models\GreeateNotification::class => \Greeate\Greeate\Repositories\NotificationRepository::class,
        \Spatie\Permission\Models\Role::class => \Greeate\Greeate\Repositories\RoleRepository::class,
        \Spatie\Permission\Models\Permission::class => \Greeate\Greeate\Repositories\PermissionRepository::class,
    ],

    'rate_limits' => [
        'login' => '5,1',
        'api' => '60,1',
        'contact' => '10,1',
    ],
];
