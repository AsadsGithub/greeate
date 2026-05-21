# Greeate Installation Guide

Greeate defaults to **Laravel + React + Inertia** (clinic_backend style). Blade/Alpine remains available with `GREEATE_UI=blade`.

---

## Laravel 12 React / Inertia host (recommended)

### 1. Composer

```bash
composer require greeate/greeate
composer require spatie/laravel-permission spatie/laravel-activitylog laravel/sanctum inertiajs/inertia-laravel

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 2. Environment (`.env`)

```env
GREEATE_UI=inertia
GREEATE_LOAD_FRONTEND_ROUTES=false
```

- Host Inertia app stays on `/` (welcome, settings, etc.)
- Greeate admin: `/admin`
- Greeate login: `/login`

### 3. Auth (`config/auth.php`)

```php
'defaults' => ['guard' => 'web', 'passwords' => 'users'],
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'admins'],
],
'providers' => [
    'admins' => ['driver' => 'eloquent', 'model' => Greeate\Greeate\Models\Admin::class],
],
```

### 4. Middleware (`bootstrap/app.php`)

```php
$middleware->web(append: [
    \Greeate\Greeate\Http\Middleware\SetLocale::class,
    \Greeate\Greeate\Http\Middleware\CheckMaintenanceMode::class,
    // Host HandleInertiaRequests stays — Greeate adds ShareGreeateInertiaProps on its routes
]);
```

Guest redirect for admin:

```php
$middleware->redirectGuestsTo(function (Request $request) {
    $adminPrefix = trim(config('greeate.admin_prefix', 'admin'), '/');
    if ($request->is($adminPrefix) || $request->is($adminPrefix.'/*')) {
        return route('greeate.login');
    }
    return route('login');
});
```

### 5. Install

```bash
php artisan greeate:install --force
npm install lucide-react clsx tailwind-merge
npm run build
```

Installer publishes:

- `resources/js/pages/greeate/**` — Inertia pages
- `resources/js/greeate/**` — layouts, components, hooks
- `resources/css/greeate-inertia.css` — Tailwind sources

### 6. Host `resources/css/app.css`

Add:

```css
@import './greeate-inertia.css';
```

### 7. Host `resources/js/app.tsx`

Greeate pages include their own layout. Ensure Inertia resolves `greeate/*` pages (Laravel Vite plugin does this when files exist under `resources/js/pages/greeate/`).

Optional layout hook:

```tsx
layout: (name) => {
    if (name.startsWith('greeate/')) return null; // GreeateAppLayout is inside each page
    // ... your existing layout rules
},
```

### 8. Verify

| URL | Expected |
|-----|----------|
| `/login` | Purple gradient React login |
| `/admin` | React sidebar + dashboard |
| Login | `admin@greeate.com` / `password` |

---

## Blade-only host (legacy)

```env
GREEATE_UI=blade
GREEATE_LOAD_FRONTEND_ROUTES=true
```

```bash
php artisan greeate:install --force
npm install alpinejs --save-dev
npm run build
```

Vite inputs: `resources/css/greeate.css`, `resources/js/greeate.js`

---

## Uninstall / reinstall (Inertia host)

See prompt in chat or run:

```bash
# Roll back greeate migrations, remove published files, composer remove greeate/greeate
composer require greeate/greeate
php artisan greeate:install --force
npm run build
```

---

## Default credentials

| Email | Password |
|-------|----------|
| admin@greeate.com | password |

---

## Git install

```json
"repositories": [{"type": "vcs", "url": "https://github.com/AsadsGithub/greeate.git"}],
"require": {"greeate/greeate": "dev-main"}
```
