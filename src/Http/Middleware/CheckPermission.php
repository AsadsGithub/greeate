<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) {
            return $next($request);
        }

        if (! $user->can($permission)) {
            abort(403, __('greeate::messages.unauthorized'));
        }

        return $next($request);
    }
}
