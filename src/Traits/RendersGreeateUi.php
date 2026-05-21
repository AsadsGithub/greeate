<?php

namespace Greeate\Greeate\Traits;

use Greeate\Greeate\Support\GreeateUi;
use Illuminate\Contracts\View\View;
use Inertia\Response;

trait RendersGreeateUi
{
    protected function greeatePage(string $component, array $props = []): Response|View
    {
        return GreeateUi::render($component, $props);
    }

    protected function greeateBlade(string $view, array $props = []): Response|View
    {
        if (GreeateUi::usesInertia()) {
            return $this->greeatePage(
                GreeateUi::inertiaComponentFromBladePrefix($view, $props['_action'] ?? 'index'),
                $props
            );
        }

        return view($view, $props);
    }
}
