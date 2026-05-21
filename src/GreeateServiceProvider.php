<?php

namespace Greeate\Greeate;

use Greeate\Greeate\Console\InstallCommand;
use Greeate\Greeate\Console\ProcessScheduledBroadcastsCommand;
use Greeate\Greeate\Http\Middleware\CheckAdminPanelAccess;
use Greeate\Greeate\Http\Middleware\CheckMaintenanceMode;
use Greeate\Greeate\Http\Middleware\CheckPermission;
use Greeate\Greeate\Http\Middleware\RestrictSuperAdminEdit;
use Greeate\Greeate\Http\Middleware\SetLocale;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Services\NotificationService;
use Greeate\Greeate\Services\SiteSettingsService;
use Greeate\Greeate\Services\TranslationService;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\View;
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

        if (config('greeate.load_frontend_routes', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/auth.php');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                ProcessScheduledBroadcastsCommand::class,
            ]);
            $this->registerPublishables();
            $this->registerSchedule();
        }

        $this->registerMiddleware();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerPolicies();
        $this->shareViewData();
        $this->configureAuth();
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/greeate.php' => config_path('greeate.php'),
            __DIR__.'/../config/firebase.php' => config_path('firebase.php'),
            __DIR__.'/../config/broadcasting-greeate.php' => config_path('broadcasting-greeate.php'),
            __DIR__.'/../config/permission.php' => config_path('permission.php'),
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

        $this->publishes([
            __DIR__.'/../resources/css/greeate.tailwind4.css' => resource_path('css/greeate.css'),
            __DIR__.'/../resources/css/rtl.css' => resource_path('css/greeate-rtl.css'),
            __DIR__.'/../resources/js/greeate.js' => resource_path('js/greeate.js'),
            __DIR__.'/../resources/js/web-push.js' => resource_path('js/web-push.js'),
            __DIR__.'/../resources/js/firebase-config.js' => resource_path('js/firebase-config.js'),
            __DIR__.'/../vite.greeate.config.js' => base_path('vite.greeate.config.js'),
        ], 'greeate-vite');
    }

    protected function registerSchedule(): void
    {
        if (class_exists(Schedule::class)) {
            Schedule::command('greeate:process-scheduled-broadcasts')->everyMinute();
        }
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
            \Greeate\Greeate\Contracts\BroadcastRepositoryInterface::class => \Greeate\Greeate\Repositories\BroadcastRepository::class,
            \Greeate\Greeate\Contracts\DeviceTokenRepositoryInterface::class => \Greeate\Greeate\Repositories\DeviceTokenRepository::class,
        ];

        foreach ($bindings as $interface => $repository) {
            $this->app->singleton($interface, fn () => new $repository);
        }
    }

    protected function registerServices(): void
    {
        foreach ([
            \Greeate\Greeate\Services\SiteSettingsService::class,
            \Greeate\Greeate\Services\TranslationService::class,
            \Greeate\Greeate\Services\UploadService::class,
            \Greeate\Greeate\Services\FirebaseService::class,
            \Greeate\Greeate\Services\FirebaseTopicService::class,
            \Greeate\Greeate\Services\NotificationService::class,
            \Greeate\Greeate\Services\BroadcastService::class,
            \Greeate\Greeate\Services\MaintenanceService::class,
            \Greeate\Greeate\Services\AdminService::class,
            \Greeate\Greeate\Services\DeviceInfoService::class,
        ] as $service) {
            $this->app->singleton($service);
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
        Gate::policy(Admin::class, \Greeate\Greeate\Policies\AdminPolicy::class);
    }

    protected function registerMiddleware(): void
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('greeate.locale', SetLocale::class);
        $router->aliasMiddleware('greeate.permission', CheckPermission::class);
        $router->aliasMiddleware('greeate.maintenance', CheckMaintenanceMode::class);
        $router->aliasMiddleware('greeate.admin', CheckAdminPanelAccess::class);
        $router->aliasMiddleware('greeate.super-admin.protect', RestrictSuperAdminEdit::class);

        $router->middlewareGroup('greeate.admin.panel', [
            'web',
            'greeate.locale',
            'auth:'.config('greeate.guard', 'web'),
            'greeate.admin',
        ]);
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

        Blade::directive('greeateSetting', function (string $expression) {
            return "<?php echo e(greeate_setting({$expression})); ?>";
        });
    }

    protected function shareViewData(): void
    {
        View::composer('greeate::*', function ($view) {
            $user = Auth::user();
            $view->with([
                'siteSettings' => app(SiteSettingsService::class)->getByGroup('general'),
                'currentLanguage' => app()->getLocale(),
                'unreadNotificationCount' => $user instanceof Admin
                    ? app(NotificationService::class)->unreadCountFor($user)
                    : 0,
            ]);
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
