<?php

use Greeate\Greeate\Services\SiteSettingsService;
use Greeate\Greeate\Services\TranslationService;

if (! function_exists('greeate_setting')) {
    function greeate_setting(string $key, mixed $default = null): mixed
    {
        return app(SiteSettingsService::class)->get($key, $default);
    }
}

if (! function_exists('greeate_trans')) {
    function greeate_trans(string $key, array $replace = [], ?string $locale = null): string
    {
        return app(TranslationService::class)->get($key, $replace, $locale);
    }
}

if (! function_exists('greeate_is_rtl')) {
    function greeate_is_rtl(?string $locale = null): bool
    {
        return app(TranslationService::class)->isRtl($locale);
    }
}

if (! function_exists('greeate_direction')) {
    function greeate_direction(?string $locale = null): string
    {
        return greeate_is_rtl($locale) ? 'rtl' : 'ltr';
    }
}
