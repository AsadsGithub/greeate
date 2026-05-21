<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('greeate.login');
        }

        if (method_exists($user, 'isActive') && ! $user->isActive()) {
            auth()->logout();

            return redirect()->route('greeate.login')
                ->with('error', __('greeate::messages.account_inactive'));
        }

        return $next($request);
    }
}
