<?php

namespace Greeate\Greeate\Http\Middleware;

use Closure;
use Greeate\Greeate\Services\TranslationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function __construct(protected TranslationService $translation) {}

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale')
            ?? $request->cookie('locale')
            ?? $this->translation->getDefaultLocale();

        if ($request->has('lang')) {
            $locale = $request->get('lang');
            $request->session()->put('locale', $locale);
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
