<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Greeate\Greeate\Services\MaintenanceService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function __construct(protected MaintenanceService $maintenance) {}

    public function handle(Request $request, Closure $next): Response
    {
        if (! $this->maintenance->isEnabled()) {
            return $next($request);
        }

        $roles = $request->user()?->getRoleNames()?->toArray() ?? [];

        if ($this->maintenance->canAccess($request->ip(), $roles)) {
            return $next($request);
        }

        if ($request->is(config('greeate.admin_prefix').'/*')) {
            return $next($request);
        }

        return response()->view('greeate::frontend.maintenance', [
            'settings' => $this->maintenance->getSettings(),
        ], 503);
    }
}
