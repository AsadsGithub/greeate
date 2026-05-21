<?php

namespace Greeate\Greeate\Support;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class GreeateUi
{
    public static function driver(): string
    {
        return config('greeate.ui', 'inertia');
    }

    public static function usesInertia(): bool
    {
        return self::driver() === 'inertia' && class_exists(Inertia::class);
    }

    public static function render(string $component, array $props = []): Response|View
    {
        if (self::usesInertia()) {
            return Inertia::render($component, $props);
        }

        $view = self::bladeViewFromComponent($component);

        return view($view, $props);
    }

    public static function bladeViewFromComponent(string $component): string
    {
        $path = str_replace('/', '.', $component);

        if (str_starts_with($path, 'greeate.')) {
            return 'greeate::'.substr($path, strlen('greeate.'));
        }

        return 'greeate::'.$path;
    }

    public static function inertiaComponentFromBladePrefix(string $viewPrefix, string $action = 'index'): string
    {
        $path = str_replace('greeate::', '', $viewPrefix);
        $path = str_replace('.', '/', $path);

        return 'greeate/'.$path.'/'.$action;
    }

    public static function redirectWith(string $message, string $type = 'success'): RedirectResponse
    {
        return back()->with($type, $message);
    }
}
