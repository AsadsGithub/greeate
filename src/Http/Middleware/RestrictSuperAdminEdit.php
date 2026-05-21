<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Greeate\Greeate\Models\Admin;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictSuperAdminEdit
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = $request->route('admin');

        if ($admin instanceof Admin && $admin->isSuperAdmin()) {
            $current = $request->user();
            if (! $current?->isSuperAdmin() || $current->id !== $admin->id) {
                abort(403, __('greeate::messages.cannot_modify_super_admin'));
            }
        }

        return $next($request);
    }
}
