<?php

namespace Greeate\Greeate\Traits;

use Illuminate\Support\Facades\Gate;

trait AuthorizesActions
{
    protected function authorizeAbility(string $ability): void
    {
        if (! Gate::allows($ability)) {
            abort(403, __('greeate::messages.unauthorized'));
        }
    }

    protected function authorizeSiteSettings(string $group, string $action): void
    {
        $this->authorizeAbility("site-settings.{$group}.{$action}");
    }
}
