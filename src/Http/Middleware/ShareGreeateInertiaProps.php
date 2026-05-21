<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Services\NotificationService;
use Greeate\Greeate\Services\SiteSettingsService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareGreeateInertiaProps
{
    public function handle(Request $request, Closure $next): Response
    {
        if (class_exists(Inertia::class) && config('greeate.ui', 'inertia') === 'inertia') {
            Inertia::share(fn () => $this->shared($request));
        }

        return $next($request);
    }

    public function shared(Request $request): array
    {
        $user = $request->user();
        $siteSettings = app(SiteSettingsService::class)->getByGroup('general');

        return [
            'locale' => app()->getLocale(),
            'rtl' => greeate_is_rtl(),
            'translations' => array_merge(
                __('greeate::nav'),
                __('greeate::auth'),
                __('greeate::actions'),
                __('greeate::messages'),
                __('greeate::fields'),
                __('greeate::stats'),
            ),
            'siteSettings' => $siteSettings,
            'greeate' => [
                'name' => config('greeate.name'),
                'adminPrefix' => config('greeate.admin_prefix', 'admin'),
                'registerEnabled' => config('greeate.auth.register_enabled', false),
            ],
            'unreadNotificationCount' => $user instanceof Admin
                ? app(NotificationService::class)->unreadCountFor($user)
                : 0,
        ];
    }
}
