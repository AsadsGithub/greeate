# Changelog

## [1.0.0] - 2026-05-21

### Added

- Production-ready SaaS admin panel (Blade + Alpine + Tailwind v4)
- Consolidated `RepositoryOperations` trait
- Full RBAC with Spatie Permission
- Activity logging with device metadata
- Firebase push, broadcasts, device tokens
- Public frontend, auth, and admin layouts
- API v1 with Sanctum
- `php artisan greeate:install` with Vite asset publishing
- RTL/LTR language system
- Site settings (cacheable groups)
- Maintenance mode module

### Changed

- Replaced split CRUD traits with single `RepositoryOperations`
- Renamed `LogsActivityTrait` to `LogsActivity`
