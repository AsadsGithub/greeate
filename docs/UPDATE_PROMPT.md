# Full prompt: apply latest Greeate to your project

Copy everything below into Cursor (run in your **host app**, e.g. savrli).  
**No uninstall required** unless migrations are broken beyond repair.

---

## PROMPT START

Apply the latest **greeate/greeate** package to this Laravel 12 React + Inertia project. Implement all fixes: MySQL migration index names, Inertia admin layout + sidebar + CRUD, public home/coming-soon pages, auth layout not wrapped by host layouts.

**Project path:** `/Users/mac/Sites/savrli`  
**Package source:** path repo `../greeate` OR `composer update greeate/greeate` from GitHub

---

### Phase 1 — Sync package code

**If path repo:**

```bash
cd /Users/mac/Sites/savrli

rsync -a ../greeate/src/ packages/greeate/src/
rsync -a ../greeate/database/migrations/ database/migrations/
rsync -a ../greeate/resources/js/ resources/js/
rsync -a ../greeate/resources/css/greeate-inertia.css resources/css/greeate-inertia.css
rsync -a ../greeate/resources/lang/ lang/vendor/greeate/
```

**If Composer VCS:**

```bash
composer update greeate/greeate
```

---

### Phase 2 — `.env` (required)

```env
GREEATE_UI=inertia
GREEATE_LOAD_FRONTEND_ROUTES=true
GREEATE_ADMIN_PREFIX=dashboard
GREEATE_PATCH_HOST_HOME=false
GREEATE_ADMIN_EMAIL=admin@greeate.com
GREEATE_ADMIN_PASSWORD=password
```

Use MySQL credentials for your DB. Do not use `GREEATE_LOAD_FRONTEND_ROUTES=false` if you want `/` home and `/coming-soon`.

---

### Phase 3 — `config/auth.php`

```php
'defaults' => [
    'guard' => 'web',
    'passwords' => 'users',
],
'guards' => [
    'web' => ['driver' => 'session', 'provider' => 'admins'],
    'fortify' => ['driver' => 'session', 'provider' => 'users'],
],
'providers' => [
    'users' => ['driver' => 'eloquent', 'model' => App\Models\User::class],
    'admins' => ['driver' => 'eloquent', 'model' => Greeate\Greeate\Models\Admin::class],
],
```

---

### Phase 4 — `bootstrap/app.php`

Web middleware append:

```php
\Greeate\Greeate\Http\Middleware\SetLocale::class,
\Greeate\Greeate\Http\Middleware\CheckMaintenanceMode::class,
```

Guest redirect for admin:

```php
$middleware->redirectGuestsTo(function (Request $request) {
    $adminPrefix = trim(config('greeate.admin_prefix', 'dashboard'), '/');
    if ($request->is($adminPrefix) || $request->is($adminPrefix.'/*')) {
        return route('greeate.login');
    }
    return route('login'); // or route('greeate.home')
});
```

---

### Phase 5 — `routes/web.php` (host)

**Do NOT** register `Route::inertia('/', 'welcome')` or redirect `/` to login when `GREEATE_LOAD_FRONTEND_ROUTES=true`.

Host file should only have language switch + settings require. Public `/` is registered by the package.

```php
<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->post('language/{locale}', function (string $locale) {
    session(['locale' => $locale]);
    cookie()->queue('locale', $locale, 60 * 24 * 365);
    return back();
})->name('greeate.language.switch');

require __DIR__.'/settings.php';
```

Comment out host `Route::inertia('dashboard', ...)` — Greeate owns `/dashboard`.

---

### Phase 6 — Publish & install

```bash
php artisan vendor:publish --tag=greeate-config --force
php artisan vendor:publish --tag=greeate-vite --force
php artisan greeate:install --force --no-assets
```

Confirm files exist:

- `resources/js/pages/greeate/auth/login.tsx`
- `resources/js/pages/greeate/admin/dashboard.tsx`
- `resources/js/pages/greeate/admin/crud/index.tsx`
- `resources/js/pages/greeate/frontend/home.tsx`
- `resources/js/pages/greeate/frontend/coming-soon.tsx`
- `resources/js/greeate/layouts/app-layout.tsx`
- `resources/js/greeate/components/app-sidebar.tsx`
- `database/migrations/2024_01_01_000008_create_greeate_notifications_table.php` uses short indexes: `greeate_notif_morph_idx`, `greeate_notif_unread_idx`

---

### Phase 7 — `resources/css/app.css`

Must include at top:

```css
@import './greeate-inertia.css';
```

---

### Phase 8 — `resources/js/app.tsx`

Greeate pages use their own layout (no host AppLayout/AuthLayout):

```tsx
layout: (name) => {
    switch (true) {
        case name.startsWith('greeate/'):
        case name.startsWith('greeate/auth/'):
        case name.startsWith('greeate/frontend/'):
        case name.startsWith('greeate/admin/'):
            return null;
        case name === 'welcome':
            return null;
        case name.startsWith('auth/'):
            return AuthLayout;
        case name.startsWith('settings/'):
            return [AppLayout, SettingsLayout];
        default:
            return AppLayout;
    }
},
```

---

### Phase 9 — Database (MySQL)

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate:fresh --seed
```

If only notifications migration failed before, fix the file then:

```bash
php artisan migrate
```

Or re-run Greeate seeders only:

```bash
php artisan db:seed --class="Greeate\Greeate\Database\Seeders\GreeateDatabaseSeeder"
```

---

### Phase 9b — Fix Wayfinder `home` export (if you see SyntaxError)

If the browser shows: `routes/index.ts does not provide an export named 'home'`:

Add to end of `resources/js/routes/index.ts`:

```ts
export { home } from './greeate'
```

Fix `resources/js/components/app-sidebar.tsx` (host starter) — use `href: '/'` not `import { home } from '@/routes'` if not using Wayfinder URLs.

Restart `npm run dev` after editing.

---

### Phase 10 — Frontend

```bash
npm install lucide-react clsx tailwind-merge
npm run dev
```

Keep `npm run dev` running while testing.

---

### Phase 11 — Verify

| Test | Expected |
|------|----------|
| GET `/` | Purple marketing home, links to login & coming-soon |
| GET `/coming-soon` | Coming soon page |
| GET `/login` | Purple admin login (not Laravel welcome, not broken layout) |
| Login `admin@greeate.com` / `password` | Redirect to `/dashboard` |
| GET `/dashboard` | Sidebar with Platform, Users, Content, Settings + stat cards |
| GET `/dashboard/admins` | Data table + Create button |
| GET `/dashboard/admins/create` | Form with name, email, password, role |

Log out and back in if sidebar menu is empty (permissions cache).

---

### Do NOT

- Run full `composer remove greeate/greeate` unless necessary
- Set `GREEATE_LOAD_FRONTEND_ROUTES=false` if you need home/coming-soon
- Use `/admin` URL — default prefix is **`/dashboard`**
- Leave `Route::inertia('/', 'welcome')` in host web.php

Report errors with exact URL and screenshot description. Do not git commit unless asked.

## PROMPT END
