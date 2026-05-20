<?php

namespace Greeate\Greeate;

use Greeate\Greeate\Console\InstallCommand;
use Greeate\Greeate\Http\Middleware\CheckMaintenanceMode;
use Greeate\Greeate\Http\Middleware\CheckPermission;
use Greeate\Greeate\Http\Middleware\SetLocale;
use Greeate\Greeate\Models\Admin;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class GreeateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/greeate.php', 'greeate');
        $this->mergeConfigFrom(__DIR__.'/../config/firebase.php', 'firebase');
        $this->mergeConfigFrom(__DIR__.'/../config/broadcasting-greeate.php', 'broadcasting-greeate');
        $this->mergeConfigFrom(__DIR__.'/../config/permission.php', 'permission');

        $this->registerRepositories();
        $this->registerServices();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'greeate');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'greeate');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');

        if ($this->app->runningInConsole()) {
            $this->commands([InstallCommand::class]);
            $this->publishes([
                __DIR__.'/../config/greeate.php' => config_path('greeate.php'),
                __DIR__.'/../config/firebase.php' => config_path('firebase.php'),
                __DIR__.'/../config/broadcasting-greeate.php' => config_path('broadcasting-greeate.php'),
            ], 'greeate-config');

            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'greeate-migrations');

            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/greeate'),
            ], 'greeate-views');

            $this->publishes([
                __DIR__.'/../resources/lang' => lang_path('vendor/greeate'),
            ], 'greeate-lang');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/greeate'),
            ], 'greeate-assets');
        }

        $this->registerMiddleware();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerGates();
        $this->registerPolicies();
        $this->configureAuth();
    }

    protected function registerRepositories(): void
    {
        $bindings = [
            \Greeate\Greeate\Contracts\AdminRepositoryInterface::class => \Greeate\Greeate\Repositories\AdminRepository::class,
            \Greeate\Greeate\Contracts\BannerRepositoryInterface::class => \Greeate\Greeate\Repositories\BannerRepository::class,
            \Greeate\Greeate\Contracts\FaqRepositoryInterface::class => \Greeate\Greeate\Repositories\FaqRepository::class,
            \Greeate\Greeate\Contracts\LanguageRepositoryInterface::class => \Greeate\Greeate\Repositories\LanguageRepository::class,
            \Greeate\Greeate\Contracts\ContactMessageRepositoryInterface::class => \Greeate\Greeate\Repositories\ContactMessageRepository::class,
            \Greeate\Greeate\Contracts\StaticPageRepositoryInterface::class => \Greeate\Greeate\Repositories\StaticPageRepository::class,
            \Greeate\Greeate\Contracts\SiteSettingRepositoryInterface::class => \Greeate\Greeate\Repositories\SiteSettingRepository::class,
            \Greeate\Greeate\Contracts\NotificationRepositoryInterface::class => \Greeate\Greeate\Repositories\NotificationRepository::class,
            \Greeate\Greeate\Contracts\RoleRepositoryInterface::class => \Greeate\Greeate\Repositories\RoleRepository::class,
            \Greeate\Greeate\Contracts\PermissionRepositoryInterface::class => \Greeate\Greeate\Repositories\PermissionRepository::class,
        ];

        foreach ($bindings as $interface => $repository) {
            $this->app->singleton($interface, fn () => new $repository);
        }
    }

    protected function registerBladeComponents(): void
    {
        $this->loadViewComponentsAs('greeate', [
            'card' => \Greeate\Greeate\View\Components\Card::class,
            'datatable' => \Greeate\Greeate\View\Components\Datatable::class,
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\Greeate\Greeate\Models\Admin::class, \Greeate\Greeate\Policies\AdminPolicy::class);
    }

    protected function registerServices(): void
    {
        $services = [
            \Greeate\Greeate\Services\SiteSettingsService::class,
            \Greeate\Greeate\Services\TranslationService::class,
            \Greeate\Greeate\Services\UploadService::class,
            \Greeate\Greeate\Services\FirebaseService::class,
            \Greeate\Greeate\Services\MaintenanceService::class,
            \Greeate\Greeate\Services\AdminService::class,
        ];

        foreach ($services as $service) {
            $this->app->singleton($service);
        }
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('greeate.locale', SetLocale::class);
        $router->aliasMiddleware('greeate.permission', CheckPermission::class);
        $router->aliasMiddleware('greeate.maintenance', CheckMaintenanceMode::class);
    }

    protected function registerBladeDirectives(): void
    {
        Blade::if('greeateCan', function (string $permission) {
            $user = Auth::user();

            if (! $user) {
                return false;
            }

            if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
                return true;
            }

            return $user->can($permission);
        });

        Blade::if('greeateRtl', fn () => greeate_is_rtl());
    }

    protected function registerGates(): void
    {
        Gate::before(function ($user, $ability) {
            if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
                return true;
            }

            return null;
        });
    }

    protected function configureAuth(): void
    {
        config([
            'auth.providers.admins' => [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ],
            'permission.models.role' => \Greeate\Greeate\Models\Role::class,
        ]);
    }
}
