<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Models\Language;
use Illuminate\Support\Facades\Cache;

class TranslationService
{
    protected array $rtlLocales = ['ar', 'ur', 'he', 'fa'];

    public function get(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return trans("greeate::{$key}", $replace, $locale);
    }

    public function isRtl(?string $locale = null): bool
    {
        $locale = $locale ?? app()->getLocale();

        $direction = Cache::remember("greeate.lang.{$locale}.direction", 3600, function () use ($locale) {
            return Language::query()
                ->where('code', $locale)
                ->value('direction');
        });

        if ($direction !== null) {
            return $direction === 'rtl';
        }

        return in_array($locale, $this->rtlLocales, true);
    }

    public function getActiveLanguages()
    {
        return Language::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function getDefaultLocale(): string
    {
        return Cache::remember('greeate.locale.default', 3600, function () {
            return Language::query()
                ->where('is_default', true)
                ->value('code') ?? config('app.locale', 'en');
        });
    }

    public function flushCache(): void
    {
        Cache::forget('greeate.locale.default');
        foreach (['en', 'ar'] as $code) {
            Cache::forget("greeate.lang.{$code}.direction");
        }
    }
}
