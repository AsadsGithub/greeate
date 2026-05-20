<?php

namespace Greeate\Greeate\Traits;

trait TranslationTrait
{
    protected function getLocalizedField(array $data, string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $key = "{$field}_{$locale}";

        if (! empty($data[$key])) {
            return $data[$key];
        }

        $fallback = config('app.fallback_locale', 'en');

        return $data["{$field}_{$fallback}"] ?? $data[$field] ?? null;
    }

    protected function mergeTranslationFields(array $data, array $fields): array
    {
        foreach ($fields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $locale => $value) {
                    $data["{$field}_{$locale}"] = $value;
                }
                unset($data[$field]);
            }
        }

        return $data;
    }
}
