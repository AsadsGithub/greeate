# Greeate Installation Guide

Greeate gives you a **clinic_backend-style** Laravel + React + Inertia admin starter (purple login, sidebar, CRUD modules).

After install, visiting **`/`** redirects to **`/login`**, not the Laravel welcome page.

---

## URLs (default)

| URL | What you see |
|-----|----------------|
| `/` | Redirect → `/login` |
| `/login` | Purple gradient React admin login |
| `/dashboard` | Admin panel (after login) |

Default login: `admin@greeate.com` / `password`

---

## Laravel 12 React / Inertia host

### 1. Composer

```bash
composer require greeate/greeate
composer require spatie/laravel-permission spatie/laravel-activitylog laravel/sanctum inertiajs/inertia-laravel
```

### 2. `.env`

```env
GREEATE_UI=inertia
GREEATE_LOAD_FRONTEND_ROUTES=false
GREEATE_ADMIN_PREFIX=dashboard
GREEATE_PATCH_HOST_HOME=true
```

### 3. Auth (`config/auth.php`)

```php
'defaults' => ['guard' => 'web', 'passwords' => 'users'],
'guards' => ['web' => ['driver' => 'session', 'provider' => 'admins']],
'providers' => ['admins' => ['driver' => 'eloquent', 'model' => Greeate\Greeate\Models\Admin::class]],
```

### 4. Install

```bash
php artisan greeate:install --force
npm install lucide-react clsx tailwind-merge
npm run dev
```

Installer will:
- Publish `resources/js/pages/greeate/**` and `resources/js/greeate/**`
- Add `@import './greeate-inertia.css'` to `app.css`
- **Replace** `Route::inertia('/', 'welcome')` with redirect to Greeate login
- **Disable** conflicting `Route::inertia('dashboard', ...)` on host

### 5. `resources/js/app.tsx`

```tsx
layout: (name) => {
    if (name.startsWith('greeate/')) return null;
    // ...
},
```

### 6. Run

```bash
php artisan serve
# Open http://127.0.0.1:8000/  → should redirect to /login
```

---

## Troubleshooting

| Problem | Fix |
|---------|-----|
| Laravel welcome at `/` | Run `php artisan greeate:install --force` or patch `routes/web.php` manually |
| Blank / unstyled login | Run `npm run dev` or `npm run build` |
| 404 on `/admin` | Use `/dashboard` (default prefix) or set `GREEATE_ADMIN_PREFIX` |
| Wrong guard | Set `config/auth.php` web guard → admins provider |

---

## Blade-only (legacy)

```env
GREEATE_UI=blade
GREEATE_ADMIN_PREFIX=admin
```
