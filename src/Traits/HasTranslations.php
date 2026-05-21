<?php

namespace Greeate\Greeate\Traits;

trait HasTranslations
{
    public function getTranslation(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$field};

        if (is_array($value)) {
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? null;
        }

        $localized = $this->{"{$field}_{$locale}"} ?? null;

        if ($localized) {
            return $localized;
        }

        return $this->{"{$field}_".config('app.fallback_locale', 'en')} ?? $this->{$field} ?? null;
    }

    public function setTranslation(string $field, string $locale, ?string $value): void
    {
        $translations = $this->{$field};

        if (! is_array($translations)) {
            $translations = is_string($translations) ? json_decode($translations, true) ?? [] : [];
        }

        $translations[$locale] = $value;
        $this->{$field} = $translations;
    }
}
