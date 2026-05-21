# Greeate Installation Guide

## Fresh Laravel 12 (Blade host)

```bash
composer require greeate/greeate
composer require spatie/laravel-permission spatie/laravel-activitylog laravel/sanctum

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

php artisan greeate:install
npm install alpinejs @tailwindcss/forms tailwindcss vite laravel-vite-plugin --save-dev
npm run build
```

### Auth (`config/auth.php`)

```php
'defaults' => ['guard' => 'web', 'passwords' => 'users'],
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'admins'],
],
'providers' => [
    'admins' => ['driver' => 'eloquent', 'model' => Greeate\Greeate\Models\Admin::class],
],
```

### Middleware (`bootstrap/app.php`)

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \Greeate\Greeate\Http\Middleware\SetLocale::class,
        \Greeate\Greeate\Http\Middleware\CheckMaintenanceMode::class,
    ]);
})
```

### Vite (`vite.config.js`)

Ensure inputs include:

```js
'resources/css/greeate.css',
'resources/js/greeate.js',
```

The installer publishes `greeate.tailwind4.css` as `resources/css/greeate.css` for Tailwind v4 hosts.

---

## Laravel 12 React / Inertia host

```env
GREEATE_LOAD_FRONTEND_ROUTES=false
```

Keep your Inertia routes on `/`. Use Greeate at:

- `/login` — admin auth
- `/admin` — Blade admin panel

Merge `vite.config.ts`:

```ts
input: [
    'resources/css/app.css',
    'resources/js/app.tsx',
    'resources/css/greeate.css',
    'resources/js/greeate.js',
],
```

Run `npm run build` after install.

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
