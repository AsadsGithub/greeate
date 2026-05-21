# Greeate Installation Guide

Laravel 12 + React + Inertia admin starter (clinic-style): public pages, purple login, sidebar, CRUD modules.

---

## URLs (default)

| URL | Page |
|-----|------|
| `/` | Public home |
| `/coming-soon` | Coming soon |
| `/contact` | Contact |
| `/login` | Admin login |
| `/dashboard` | Admin panel |

Login: `admin@greeate.com` / `password`

---

## `.env` (Inertia host)

```env
GREEATE_UI=inertia
GREEATE_LOAD_FRONTEND_ROUTES=true
GREEATE_ADMIN_PREFIX=dashboard
GREEATE_PATCH_HOST_HOME=false
```

---

## Quick install

```bash
composer require greeate/greeate inertiajs/inertia-laravel
composer require spatie/laravel-permission spatie/laravel-activitylog laravel/sanctum
php artisan greeate:install --force
npm install lucide-react clsx tailwind-merge
npm run dev
```

See `docs/UPDATE_PROMPT.md` for applying updates to an existing project without full reinstall.
