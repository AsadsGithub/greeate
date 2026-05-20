<?php

namespace Greeate\Greeate\Services;

use Greeate\Greeate\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SiteSettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        return SiteSetting::getValue($key, $default);
    }

    public function getMultiple(array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->get($key);
        }

        return $result;
    }

    public function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): SiteSetting
    {
        if (is_array($value)) {
            $value = json_encode($value);
            $type = 'json';
        }

        return SiteSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }

    public function getByGroup(string $group): array
    {
        return Cache::remember("greeate.settings.{$group}", 3600, function () use ($group) {
            return SiteSetting::where('group', $group)
                ->get()
                ->mapWithKeys(fn ($s) => [$s->key => $s->getTypedValue()])
                ->toArray();
        });
    }

    public function flush(): void
    {
        Cache::forget('greeate.site_settings');
        Cache::flush();
    }
}
