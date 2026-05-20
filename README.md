# Greeate - Modern SaaS Admin Panel for Laravel

[![Latest Version](https://img.shields.io/packagist/v/greeate/greeate.svg)](https://packagist.org/packages/greeate/greeate)
[![License](https://img.shields.io/packagist/l/greeate/greeate.svg)](https://packagist.org/packages/greeate/greeate)

**Greeate** is a production-ready, enterprise-grade Laravel package that provides a complete modern SaaS admin panel foundation for any Laravel 12+ application.

## Features

- Modern SaaS Admin Panel (Linear/Stripe-inspired UI)
- Authentication (Sanctum, 2FA-ready, email verification)
- Roles & Permissions (Spatie)
- Admin Management CRUD
- Site Settings (cacheable, grouped)
- RTL/LTR & Multi-language
- Activity Logs (Spatie)
- Notifications (in-app, email, Firebase push)
- Firebase Cloud Messaging integration
- CMS Modules (Banners, FAQs, Static Pages, Contact)
- Maintenance Mode
- Repository Pattern + Trait-based CRUD
- API-ready (Sanctum + Resources)
- Broadcasting (Pusher, Reverb, Firebase)
- Dark/Light mode
- TailwindCSS + AlpineJS + Blade Components

## Requirements

- PHP 8.3+
- Laravel 12+
- MySQL 8+
- Node.js 18+ (for assets)

## Installation

### 1. Install via Composer

```bash
composer require greeate/greeate
```

### 2. Publish Spatie Permission (required)

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 3. Publish Spatie Activity Log (required)

```bash
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
```

### 4. Install Sanctum

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 5. Run Greeate Installer

```bash
php artisan greeate:install
```

The installer will:
- Publish configs, migrations, views, lang files, assets
- Run migrations
- Seed Super Admin, roles, permissions, languages, settings
- Create storage link
- Configure broadcasting & Firebase placeholders
- Install npm dependencies (optional)

### 6. Configure Auth

Add to your `config/auth.php`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'admins' => [
        'driver' => 'eloquent',
        'model' => Greeate\Greeate\Models\Admin::class,
    ],
],
```

### 7. Build Assets

Copy `vite.config.js` and `tailwind.config.js` from the package, or merge into your project:

```bash
npm install
npm run build
```

## Default Credentials

| Field    | Value              |
|----------|--------------------|
| Email    | admin@greeate.com  |
| Password | password           |

Change via `.env`:

```env
GREEATE_ADMIN_EMAIL=your@email.com
GREEATE_ADMIN_PASSWORD=your-secure-password
```

## Configuration

Publish config:

```bash
php artisan vendor:publish --tag=greeate-config
```

Key options in `config/greeate.php`:

```php
'admin_prefix' => 'admin',        // Admin panel URL prefix
'api_prefix' => 'api/v1',         // API prefix
'super_admin_role' => 'super-admin',
'upload.disk' => 'public',
```

## Usage

### Helpers

```php
greeate_setting('site_name');
greeate_trans('messages.welcome');
greeate_is_rtl();
greeate_direction(); // 'rtl' or 'ltr'
```

### Blade Directives

```blade
@greeateCan('admins.create')
    <a href="...">Create Admin</a>
@endgreeateCan

@greeateRtl
    <div dir="rtl">...</div>
@endgreeateRtl
```

### Repository Pattern

```php
use Greeate\Greeate\Contracts\AdminRepositoryInterface;

public function __construct(protected AdminRepositoryInterface $admins) {}

public function index(Request $request)
{
    return $this->admins->paginate($request);
}
```

### Extending with Custom Modules

1. Create Model + Migration
2. Create `XxxRepositoryInterface` extending `BaseRepositoryInterface`
3. Create `XxxRepository` extending `BaseRepository`
4. Register binding in `config/greeate.php` repositories array
5. Create Controller using `CrudController` trait
6. Add permissions to `PermissionSeeder` or your seeder
7. Add routes to `routes/admin.php` or your routes file

### API Authentication

```bash
POST /api/v1/auth/login
Content-Type: application/json

{"email": "admin@greeate.com", "password": "password"}
```

Response includes Sanctum token for subsequent requests.

## Firebase Setup

```env
GREEATE_FIREBASE_ENABLED=true
FIREBASE_SERVER_KEY=your-server-key
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_SENDER_ID=your-sender-id
FIREBASE_VAPID_KEY=your-vapid-key
```

Or configure via Admin → Settings → Firebase (stored in database).

## Broadcasting Setup

```env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-key
PUSHER_APP_SECRET=your-secret
PUSHER_APP_CLUSTER=mt1
```

For Laravel Reverb:

```env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-key
REVERB_APP_SECRET=your-secret
```

## Permissions

Permissions follow the pattern: `{resource}.{action}`

Examples:
- `admins.view`
- `roles.edit`
- `site-settings.general.edit`

Super Admin role bypasses all permission checks.

## Localization

Languages are managed via Admin → Languages. Each language has:
- `code` (en, ar, ur)
- `direction` (ltr, rtl)
- `is_default`

Switch language:

```blade
<form method="POST" action="{{ route('greeate.language.switch', 'ar') }}">
    @csrf
    <button type="submit">العربية</button>
</form>
```

## Package Structure

```
greeate/                    # repository root (this package)
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   ├── lang/
│   └── views/greeate/
├── routes/
├── src/
│   ├── Console/
│   ├── Contracts/
│   ├── Events/
│   ├── Http/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Repositories/
│   ├── Services/
│   ├── Traits/
│   └── View/
└── tests/
```

## Testing

```bash
composer test
# or
./vendor/bin/pest
```

## Publishing Assets

```bash
php artisan vendor:publish --tag=greeate-config
php artisan vendor:publish --tag=greeate-migrations
php artisan vendor:publish --tag=greeate-views
php artisan vendor:publish --tag=greeate-lang
php artisan vendor:publish --tag=greeate-assets
```

## License

MIT License. See [LICENSE](LICENSE) for details.

## Credits

Built with inspiration from modern Laravel architecture patterns. Designed for Laravel 12+ and PHP 8.3+.
