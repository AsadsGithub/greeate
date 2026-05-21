# Greeate Laravel Package — Production Build Prompt

> **How to use:** Copy everything below the line `--- PROMPT START ---` into Cursor, Claude, or your dev agent. Point the agent at this repo (`/Users/mac/Sites/greeate`) and the reference app (`/Users/mac/Sites/clinic_backend`). The agent must **complete and harden** the package until it is installable on a fresh Laravel 12 app with zero manual wiring beyond documented steps.

---

## PROMPT START

You are a senior Laravel package architect. Build and complete the **`greeate/greeate`** Composer package — a production-ready, installable Laravel 12 admin foundation. The package lives at `/Users/mac/Sites/greeate`. Use `/Users/mac/Sites/clinic_backend` as the **reference architecture** for patterns (repository layer, Spatie RBAC, activity log, RTL/LTR, Firebase push, site settings, maintenance, notifications). **Do not copy clinic-specific domain** (clinics, bookings, treatments, wallets, payments). Extract only reusable infrastructure.

### Goal

After `composer require greeate/greeate` and `php artisan greeate:install` on a **fresh Laravel 12** application, the host app gets:

1. **Public frontend** — home, coming soon, contact us, privacy policy, terms & conditions (multi-language from DB + lang files)
2. **Auth area** — separate layout: login, register, forgot/reset password, email verification (admin guard)
3. **Admin panel** — modern SaaS dashboard (Linear/Stripe/Vercel aesthetic): sidebar, topbar, dark/light mode, stats cards, datatables, toasts, breadcrumbs
4. **Full RBAC** — Spatie roles/permissions; default `super-admin` role; role CRUD with permission assignment UI; permissions seeded as stubs (host extends per project)
5. **Repository pattern** — trait-based CRUD/filter/search/pagination consolidated in one `RepositoryOperations` trait used by `BaseRepository`; every module repository extends `BaseRepository`
6. **Activity log** — Spatie + custom `LogsActivity` trait on all admin-managed models
7. **Notifications** — in-app + email + Firebase Cloud Messaging (topics by role) + optional broadcast campaigns
8. **RTL/LTR** — driven by `languages` table + session/cookie + lang files under `resources/lang/vendor/greeate`
9. **Site settings** — DB-backed, cacheable groups: branding, colors, logo, default language, activity log toggle, Firebase config, contact info, maintenance config
10. **API** — Sanctum-authenticated `/api/v1` for admin auth + notifications (extensible)

---

## Technical constraints

| Requirement | Value |
|-------------|-------|
| PHP | `^8.3` |
| Laravel | `^12.0` (Illuminate components) |
| Package namespace | `Greeate\Greeate\` |
| Package name | `greeate/greeate` |
| UI stack | **Blade + Alpine.js + Tailwind CSS v4** (NOT Inertia/React inside the package — keeps the package portable; host Laravel React apps set `GREEATE_LOAD_FRONTEND_ROUTES=false`) |
| Auth | Separate `Admin` model + guard configurable via `config/greeate.php` |
| Testing | Pest + Orchestra Testbench |
| Code style | PSR-12, strict types where applicable, no dead stubs |

### Composer dependencies (require)

```json
"laravel/sanctum": "^4.0",
"spatie/laravel-permission": "^6.0",
"spatie/laravel-activitylog": "^4.0",
"kreait/laravel-firebase": "^5.0"
```

### Reference files to study and port (clinic_backend)

| Pattern | Reference path |
|---------|----------------|
| Repository operations (single trait) | `app/Traits/RepositoryOperations.php` |
| Base repository | `app/Repositories/BaseRepository.php`, `app/Contracts/BaseRepositoryInterface.php` |
| CrudController trait | `app/Traits/CrudController.php` |
| LogsActivity trait | `app/Traits/LogsActivity.php` |
| SetLocale middleware | `app/Http/Middleware/SetLocale.php` |
| Site settings service | `app/Services/SiteSettingsService.php` |
| Firebase provider | `app/Providers/FirebaseServiceProvider.php` |
| Notification + broadcast jobs | `app/Jobs/SendPushNotification.php`, `app/Jobs/SendBroadcastNotification.php` |
| Firebase topic service | `app/Services/FirebaseTopicService.php` |
| Gate ↔ permission mirror | `app/Providers/AuthServiceProvider.php` (trim to package modules only) |
| Permission seeder structure | `database/seeders/PermissionSeeder.php` |
| Activity log enrichment | `AppServiceProvider` `Activity::creating` hook |
| RTL root template pattern | `resources/views/app.blade.php` + `resources/css/rtl.css` |

**Refactor greeate's current split traits** (`CreateTrait`, `UpdateTrait`, `DeleteTrait`, `FilterTrait`, etc.) into **one** `RepositoryOperations` trait matching clinic_backend, then have `BaseRepository` `use RepositoryOperations` only.

---

## Package directory structure (complete)

Generate every file below. Existing files may be rewritten if incomplete.

```
greeate/
├── composer.json
├── README.md
├── LICENSE
├── phpunit.xml / pest.php
├── tailwind.config.js
├── vite.greeate.config.js          # publishable vite stub for host apps
├── config/
│   ├── greeate.php
│   ├── firebase.php
│   ├── broadcasting-greeate.php
│   └── permission.php             # Spatie overrides (custom Role model)
├── database/
│   ├── factories/
│   ├── migrations/                  # all prefixed greeate_ or namespaced
│   └── seeders/
│       ├── GreeateDatabaseSeeder.php
│       ├── PermissionSeeder.php
│       ├── SiteSettingSeeder.php
│       ├── LanguageSeeder.php
│       └── SuperAdminSeeder.php
├── public/
│   ├── vendor/greeate/              # built assets + firebase-messaging-sw.js
│   └── firebase-messaging-sw.js     # template, credentials injected at runtime
├── resources/
│   ├── css/
│   │   ├── greeate.css
│   │   ├── greeate.tailwind4.css
│   │   └── rtl.css
│   ├── js/
│   │   ├── greeate.js               # Alpine components, theme toggle, sidebar
│   │   ├── firebase-config.js
│   │   └── web-push.js
│   ├── lang/
│   │   ├── en/  (actions, common, fields, messages, nav, stats, validation)
│   │   └── ar/  (mirror all keys)
│   └── views/greeate/
│       ├── layouts/
│       │   ├── admin.blade.php      # sidebar + topbar + @stack scripts
│       │   ├── auth.blade.php       # centered card, no sidebar
│       │   └── frontend.blade.php   # marketing nav + footer
│       ├── components/              # blade components + anonymous components
│       ├── auth/                      # login, register, forgot, reset, verify
│       ├── frontend/                  # home, coming-soon, contact, page, maintenance
│       └── admin/                     # all CRUD modules (see modules section)
├── routes/
│   ├── web.php                      # frontend only
│   ├── auth.php                     # admin auth
│   ├── admin.php                    # dashboard CRUD
│   └── api.php                      # api/v1
├── src/
│   ├── GreeateServiceProvider.php
│   ├── GreeateAuthServiceProvider.php
│   ├── FirebaseServiceProvider.php
│   ├── Console/
│   │   └── InstallCommand.php
│   ├── Contracts/                   # *RepositoryInterface per model
│   ├── Events/
│   ├── Exceptions/
│   ├── Facades/Greeate.php
│   ├── helpers.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── BaseController.php
│   │   │   ├── Admin/               # one controller per module
│   │   │   ├── Auth/
│   │   │   ├── Frontend/
│   │   │   └── Api/V1/
│   │   ├── Middleware/
│   │   │   ├── SetLocale.php
│   │   │   ├── CheckPermission.php
│   │   │   ├── CheckAdminPanelAccess.php
│   │   │   ├── CheckMaintenanceMode.php
│   │   │   └── RestrictSuperAdminEdit.php
│   │   ├── Requests/Admin/        # FormRequest per store/update
│   │   └── Resources/               # API resources
│   ├── Jobs/
│   │   ├── SendPushNotification.php
│   │   └── SendBroadcastNotification.php
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Repositories/
│   ├── Services/
│   │   ├── SiteSettingsService.php
│   │   ├── FirebaseService.php
│   │   ├── FirebaseTopicService.php
│   │   ├── NotificationService.php
│   │   ├── BroadcastService.php
│   │   ├── MaintenanceService.php
│   │   ├── UploadService.php
│   │   ├── TranslationService.php
│   │   └── DeviceInfoService.php
│   ├── Traits/
│   │   ├── RepositoryOperations.php   # ALL repo CRUD/filter/search/paginate
│   │   ├── CrudController.php
│   │   ├── LogsActivity.php
│   │   ├── AuthorizesActions.php
│   │   └── HasTranslations.php          # JSON translatable columns
│   └── View/Components/
└── tests/
    ├── Feature/
    └── Unit/
```

---

## Database schema (migrations)

Create migrations with proper indexes, soft deletes where noted, and foreign keys.

### `greeate_admins`
- `id`, `name`, `email` (unique), `password`, `avatar`, `phone`, `status` (enum: active, inactive), `email_verified_at`, `two_factor_secret`, `two_factor_recovery_codes`, `notification_settings` (json), `last_login_at`, `remember_token`, timestamps, soft deletes

### `greeate_languages`
- `code` (unique, e.g. en, ar, ur), `name`, `native_name`, `direction` (ltr|rtl), `is_default`, `is_active`, `sort_order`

### `greeate_site_settings`
- `group` (general, branding, firebase, contact, maintenance, features), `key`, `value` (text/json), `type` (string, boolean, json, file), unique (`group`, `key`)

### Spatie tables
- Publish/adapt `create_permission_tables` migration; custom `greeate_roles` or extend Spatie `roles` with `alias` column on `Greeate\Models\Role`

### `greeate_banners`
- translatable: `title`, `description` (json); `image`, `link`, `position`, `sort_order`, `is_active`, `starts_at`, `ends_at`, soft deletes

### `greeate_faqs`
- translatable: `question`, `answer` (json); `category`, `sort_order`, `is_active`, soft deletes

### `greeate_static_pages`
- `slug` (unique: privacy-policy, terms-conditions, about, custom), translatable `title`, `content` (json), `meta` (json), `is_active`, soft deletes

### `greeate_contact_messages`
- `name`, `email`, `phone`, `subject`, `message`, `status` (new, read, replied), `admin_notes`, `read_at`, timestamps

### `greeate_notifications`
- `type`, `title`, `body`, `data` (json), `notifiable_type`, `notifiable_id`, `read_at`, `channel` (database, push, email), timestamps

### `greeate_device_tokens`
- `admin_id`, `token`, `platform` (web, android, ios), `topics` (json), unique (`admin_id`, `token`)

### `greeate_broadcasts`
- translatable `title`, `body` (json); `target_type` (all, role, topic), `target_value`, `scheduled_at`, `sent_at`, `status` (draft, scheduled, sent, failed), `created_by`, soft deletes

### `greeate_maintenance_modes`
- `is_enabled`, `title`, `description` (json translatable), `starts_at`, `ends_at`, `allowed_roles` (json array of role names), `allowed_ips` (json), `show_countdown`, timestamps

### `greeate_activity_log`
- Use Spatie's published migration; add soft deletes + indexes if missing

### `personal_access_tokens`
- Sanctum (document that host runs sanctum publish)

---

## Repository layer (mandatory pattern)

### `RepositoryOperations` trait must implement:

- `withTransaction(callable)`
- `create`, `update`, `delete`, `find`, `findOrFail`, `findBy`
- `paginate(Request $request)` with: search, filters, sort (`sort_by`, `sort_dir`), per_page cap from config, eager load via `?with[]=`, `?has[]=`, `?whereHas[]=`
- `beforeCreate`, `afterCreate`, `beforeUpdate`, `afterUpdate`, `applyCustomFilters` hooks
- Optional full-text search toggle per repository
- `logOperation()` for debug/audit breadcrumb

### `BaseRepository`
- Implements `BaseRepositoryInterface`
- `use RepositoryOperations`
- Constructor receives Model; sets `searchableFields`, `filterableFields`, `relationships` from overridable methods

### Concrete repositories (extend BaseRepository + interface):

`AdminRepository`, `RoleRepository`, `PermissionRepository`, `BannerRepository`, `FaqRepository`, `LanguageRepository`, `StaticPageRepository`, `ContactMessageRepository`, `SiteSettingRepository`, `NotificationRepository`, `BroadcastRepository`, `ActivityLogRepository`, `DeviceTokenRepository`, `MaintenanceModeRepository`

Register all bindings in `GreeateServiceProvider::registerRepositories()`.

### `CrudController` trait

Generic `index`, `create`, `store`, `show`, `edit`, `update`, `destroy` using repository + Gate checks. Admin controllers use this where standard CRUD applies.

---

## Authorization (Spatie + Gates)

### Default roles (seeded)

| Role | Behavior |
|------|----------|
| `super-admin` | `Gate::before` returns true for all abilities |
| `admin` | Optional; assign subset of permissions in seeder |

### Permission naming convention

`{resource}.{action}` — examples:

```
dashboard.view
profile.view, profile.edit
admins.view, admins.create, admins.edit, admins.delete
roles.view, roles.create, roles.edit, roles.delete
permissions.view
banners.*
faqs.*
languages.*
static-pages.*
contact-messages.view, contact-messages.delete
notifications.view, notifications.create, notifications.send
broadcasts.*
activity-logs.view, activity-logs.delete
site-settings.view, site-settings.edit
maintenance.view, maintenance.edit
```

`PermissionSeeder` creates permissions grouped by sidebar sections (Platform, User Management, Content, Settings, Notifications). **Do not** hardcode project-specific permissions beyond package modules.

### Middleware

- `greeate.admin` — auth + verified + `CheckAdminPanelAccess`
- `greeate.permission:{ability}` — `CheckPermission`
- `greeate.maintenance` — on frontend routes
- `greeate.super-admin.protect` — prevent editing/deleting super-admin account except by self profile

### Policies

`AdminPolicy`, `RolePolicy`, `BannerPolicy`, etc. — delegate to Gates.

---

## Admin modules (full CRUD + UI)

Each module: **index** (datatable with search/filter/sort/pagination), **create**, **edit**, **show** (where useful), FormRequests, Policy, Repository, lang keys, sidebar nav entry gated by permission.

| Module | Features |
|--------|----------|
| **Dashboard** | Stats cards (admins count, unread notifications, contact messages, active banners), recent activity, quick links |
| **My Profile** | Super admin / any admin: edit name, email, avatar, password change, 2FA setup (optional Laravel Fortify-compatible fields), notification preferences |
| **Admins management** | CRUD, assign roles, status toggle, avatar upload, cannot delete last super-admin |
| **Roles** | CRUD, assign permissions via checkbox matrix (`permission-table` component) |
| **Permissions** | View-only list grouped by module (create/edit/delete only via seeder in host) |
| **Banners** | CRUD, image upload, schedule, translatable fields, drag sort |
| **FAQs** | CRUD, translatable, category filter |
| **Languages** | CRUD, set default (only one), direction, activate/deactivate |
| **Static pages** | Privacy policy & terms CRUD with per-language tabs; slug reserved for `privacy-policy`, `terms-conditions` |
| **Contact messages** | Inbox list, mark read, show detail, delete, optional reply email |
| **Notifications** | In-app list, mark read, create manual notification to admin(s) |
| **Broadcasts** | Create campaign, target all/role/topic, schedule, send now, queue job |
| **Activity logs** | Index with filters (causer, subject, date), show detail, bulk delete |
| **Site settings** | Tabbed UI: General (site name, address, logo, favicon, default language, activity_log_enabled bool), Branding (primary/secondary colors as CSS vars), Contact (email, phone, social links), Firebase (credentials json, web config json, enable flags), Features toggles |
| **Maintenance mode** | Enable/disable, translatable title/description, start/end datetime, select allowed roles (multi-select), IP whitelist, live countdown on public maintenance page |

---

## Frontend (public) — separate layout

Routes under configurable prefix (default `/` when `load_frontend_routes=true`):

| Route | Page |
|-------|------|
| `/` | Home (hero + features; uses site settings) |
| `/coming-soon` | Coming soon page (toggle via setting) |
| `/contact` | Contact form → stores `contact_messages`, sends notification |
| `/privacy-policy` | Renders `static_pages` slug |
| `/terms-conditions` | Renders `static_pages` slug |
| `/maintenance` | Shown when maintenance mode active (middleware) |

Language switcher: `POST /language/{locale}` — persists session + cookie, respects `languages` table.

All strings via `@lang('greeate::...')` and/or `greeate_trans()` helper.

---

## Auth area — separate layout

Routes under `{admin_prefix}/auth` or `routes/auth.php`:

- Login (rate limited)
- Register (optional, config `greeate.auth.register_enabled`)
- Forgot / reset password
- Email verification
- Logout

Use `layouts/auth.blade.php` — minimal, centered, brand logo from site settings, dark mode support.

---

## Admin panel — separate layout

`layouts/admin.blade.php`:

- Collapsible sidebar with permission-filtered nav
- Topbar: search placeholder, language dropdown, theme toggle (dark/light), notification bell with unread count, profile dropdown
- Breadcrumbs component
- Flash toasts / alert component
- `@stack('styles')` / `@stack('scripts')`

**Design system:**

- Primary indigo/violet palette (configurable CSS variables from site settings)
- Inter font
- Rounded-xl cards, subtle borders, shadow-sm
- Responsive: mobile drawer sidebar
- Empty states, skeleton loaders optional
- Datatable: sortable columns, bulk actions where applicable

---

## RTL/LTR implementation

1. `languages.direction` drives `dir` attribute
2. `SetLocale` middleware: priority — query `?lang=`, session, cookie, site default language
3. `greeate_is_rtl()`, `greeate_direction()` helpers
4. Load `rtl.css` when locale direction is rtl
5. Blade: `<html lang="{{ app()->getLocale() }}" dir="{{ greeate_direction() }}">`
6. All admin form labels for translatable models: tab UI per active language (en, ar, …)
7. Model trait `HasTranslations` — get/set `{field}_{locale}` or JSON `{"en":"...","ar":"..."}`

---

## Firebase & notifications

### Config storage

Store in `site_settings` group `firebase`:
- `firebase_credentials_json` (service account)
- `firebase_web_config_json`
- `firebase_enabled`, `web_push_enabled`

### Services

- `FirebaseServiceProvider` — singleton `Kreait\Firebase\Messaging`
- `FirebaseTopicService` — subscribe/unsubscribe tokens to topics: `all`, `role_{role_name}`, `admin_{id}`
- `NotificationService` — create DB notification + optional push + email
- `SendPushNotification` job — queue
- `SendBroadcastNotification` job — batch by topic/role

### Web push (admin panel)

- `public/firebase-messaging-sw.js` (published)
- `resources/js/web-push.js` — request permission, register token to `DeviceTokenController`
- Notification bell component polls or uses SSE/websocket if broadcasting enabled

### Console commands

- `greeate:process-scheduled-broadcasts`
- `greeate:subscribe-admins-to-topics`

Schedule in package `GreeateServiceProvider::boot()` when running in console.

---

## Activity log

### `LogsActivity` trait (package)

- Uses Spatie `LogsActivity`
- `logOnly` fillable, `logOnlyDirty`
- Custom description with causer name
- `logAction($event, $properties)` manual logging
- On `Activity::creating`, merge IP, user agent, URL via `DeviceInfoService`

### Models using trait

All admin-managed Eloquent models.

### Admin UI

Filter by causer, subject type, date range; view changes (old/new attributes).

---

## Site settings service

```php
greeate_setting('site_name', 'default');
greeate_setting('primary_color', '#6366f1');
SiteSettingsService::getGroup('firebase');
SiteSettingsService::set('general', 'activity_log_enabled', true);
```

- Cache forever; clear on update
- File-type settings use `UploadService` → storage disk from config
- Inject settings into all views via `View::composer` or middleware share: `siteSettings`, `currentLanguage`, `unreadNotificationCount`

---

## `php artisan greeate:install`

Interactive or `--no-interaction` flags:

1. Publish config, migrations, views, lang, assets (tags: greeate-config, greeate-migrations, greeate-views, greeate-lang, greeate-assets, greeate-vite)
2. Prompt: publish to host or keep vendor-only views
3. Run migrations
4. Run seeders: Permission, Language (en+ar), SiteSetting, SuperAdmin
5. `storage:link` if needed
6. Print default credentials and next steps (npm build, .env keys)
7. Append middleware to host `bootstrap/app.php` instructions in README (or auto-detect and warn)

### Host app integration checklist (document in README)

```php
// bootstrap/app.php — append middleware
$middleware->web(append: [
    \Greeate\Greeate\Http\Middleware\SetLocale::class,
    \Greeate\Greeate\Http\Middleware\CheckMaintenanceMode::class,
]);

// config/auth.php — admins provider
// .env — GREEATE_* and FIREBASE_*
// composer.json — merge vite entry for greeate.css/js
```

For **Laravel 12 React/Inertia** host: set `GREEATE_LOAD_FRONTEND_ROUTES=false`; host keeps `/` and uses package only for `/admin` + API.

---

## API (`routes/api.php`)

Prefix: `config('greeate.api_prefix')` default `api/v1`

| Method | Endpoint | Auth |
|--------|----------|------|
| POST | `/auth/login` | public |
| POST | `/auth/logout` | sanctum |
| GET | `/auth/me` | sanctum |
| GET | `/notifications` | sanctum |
| PATCH | `/notifications/{id}/read` | sanctum |
| POST | `/device-tokens` | sanctum |

Use API Resources: `AdminResource`, `NotificationResource`. Consistent JSON envelope for errors.

---

## Blade components & directives

### Components (register in service provider)

`<x-greeate::card>`, `<x-greeate::datatable>`, `<x-greeate::sidebar>`, `<x-greeate::topbar>`, `<x-greeate::pagination>`, `<x-greeate::empty-state>`, `<x-greeate::toast>`, `<x-greeate::breadcrumbs>`, `<x-greeate::permission-matrix>`, `<x-greeate::translatable-tabs>`, `<x-greeate::notification-bell>`

### Directives

```blade
@greeateCan('admins.create') ... @endgreeateCan
@greeateRtl ... @endgreeateRtl
@greeateSetting('site_name')
```

---

## Config `config/greeate.php` (complete)

Must include: `name`, `version`, `load_frontend_routes`, `route_prefix`, `admin_prefix`, `api_prefix`, `guard`, `admin_guard`, `super_admin_role`, `default_admin`, `pagination`, `upload`, `maintenance`, `modules` (toggle each module), `repositories` map, `rate_limits`, `auth.register_enabled`, `features` (2fa, web_push, broadcasts, activity_log).

---

## Testing (Pest + Testbench)

Minimum coverage:

- Install command runs migrations + seeders
- Super admin can login
- Permission middleware blocks unauthorized admin
- Repository paginate/search/filter
- Site settings get/set/cache
- Maintenance mode blocks frontend, allows whitelisted role/IP
- Language switch sets locale and direction
- API login returns token
- Contact form stores message

---

## Quality gates (definition of done)

- [ ] `composer test` passes
- [ ] Fresh Laravel 12 install + package works end-to-end
- [ ] No PHPStan/Pint errors (run pint on package)
- [ ] All routes named `greeate.*` or `admin.*` consistently
- [ ] No hardcoded English in views (use lang files)
- [ ] Super admin seeded; permissions seeded for package modules only
- [ ] README has install, config, extend, Firebase, broadcasting, permissions docs
- [ ] CHANGELOG.md for v1.0.0
- [ ] Security: bcrypt passwords, CSRF, rate limits, mass assignment guarded, file upload validation
- [ ] Delete incomplete scaffold views (e.g. activity-logs create/edit if read-only)

---

## Implementation order

1. Consolidate `RepositoryOperations` + refactor `BaseRepository` and all repositories
2. Migrations + models + factories
3. Seeders (permissions, languages, settings, super admin)
4. Services (SiteSettings, Firebase, Notification, Maintenance)
5. Middleware + Gates + Policies
6. Admin controllers + FormRequests
7. Admin Blade views + components (polish UI last)
8. Frontend + auth views
9. API controllers
10. Jobs + commands + Firebase SW
11. Install command + README
12. Tests

---

## Current package state (do not duplicate blindly — complete gaps)

The repo already has partial scaffolding (~90 PHP files, Blade views). **Audit and fix**, don't restart from zero unless broken:

**Likely missing or incomplete:** `RepositoryOperations` (still split traits), `Broadcast` module, `ProfileController`, `DeviceTokenController`, `GreeateAuthServiceProvider` with full Gate map, `FirebaseTopicService`, jobs, console commands, `permission-matrix` UI, translatable tabs on banners/faqs/static pages, dashboard stats, web push JS, comprehensive seeders, Pest tests, polished SaaS CSS, `BroadcastRepository`, activity log delete restrictions.

**Remove incorrect scaffolds:** activity-logs create/edit routes if activity log is read-only audit trail.

---

## Output expectations

1. Working package in `/Users/mac/Sites/greeate`
2. Updated `README.md` with accurate install steps
3. `docs/INSTALLATION.md` for host Laravel 12 + React variant
4. All migrations runnable
5. `npm run build` instructions for Tailwind v4 assets
6. No TODO comments left in production code paths

Build everything. Commit logically. Ask only if a business rule is ambiguous.

--- PROMPT END ---
