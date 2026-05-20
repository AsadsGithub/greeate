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

        $language = Cache::remember("greeate.lang.{$locale}", 3600, function () use ($locale) {
            return Language::where('code', $locale)->first();
        });

        if ($language) {
            return $language->isRtl();
        }

        return in_array($locale, $this->rtlLocales, true);
    }

    public function getActiveLanguages()
    {
        return Cache::remember('greeate.languages.active', 3600, function () {
            return Language::where('is_active', true)->orderBy('sort_order')->get();
        });
    }

    public function getDefaultLocale(): string
    {
        return Cache::remember('greeate.locale.default', 3600, function () {
            $lang = Language::where('is_default', true)->first();

            return $lang?->code ?? config('app.locale', 'en');
        });
    }
}
