<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Greeate\Greeate\Models\Admin;
use Greeate\Greeate\Services\NotificationService;
use Greeate\Greeate\Services\SiteSettingsService;
use Greeate\Greeate\Services\TranslationService;
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
        $translation = app(TranslationService::class);

        return [
            'locale' => app()->getLocale(),
            'rtl' => greeate_is_rtl(),
            'activeLanguages' => $translation->getActiveLanguages()->map(fn ($lang) => [
                'code' => $lang->code,
                'name' => $lang->name,
                'direction' => $lang->direction,
                'is_default' => (bool) $lang->is_default,
            ])->values()->all(),
            'settingsGroups' => collect(app(SiteSettingsService::class)->getAvailableGroups())
                ->map(fn (string $group) => [
                    'key' => $group,
                    'label' => __("greeate::settings.group_{$group}", [], app()->getLocale()),
                ])
                ->values()
                ->all(),
            'translations' => array_merge(
                __('greeate::nav'),
                __('greeate::auth'),
                __('greeate::actions'),
                __('greeate::messages'),
                __('greeate::fields'),
                __('greeate::stats'),
                __('greeate::settings'),
            ),
            'siteSettings' => $siteSettings,
            'auth' => [
                'user' => $this->serializeUser($user),
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'greeate' => [
                'name' => config('greeate.name'),
                'adminPrefix' => config('greeate.admin_prefix', 'dashboard'),
                'registerEnabled' => config('greeate.auth.register_enabled', false),
            ],
            'unreadNotificationCount' => $user instanceof Admin
                ? app(NotificationService::class)->unreadCountFor($user)
                : 0,
        ];
    }

    protected function serializeUser(mixed $user): ?array
    {
        if (! $user) {
            return null;
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => method_exists($user, 'getRoleNames') ? $user->getRoleNames()->toArray() : [],
            'permissions' => method_exists($user, 'getAllPermissions')
                ? $user->getAllPermissions()->pluck('name')->toArray()
                : [],
        ];
    }
}
