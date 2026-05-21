<?php

namespace Greeate\Greeate\Models;

use Greeate\Greeate\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use LogsActivity;

    protected $table = 'greeate_site_settings';

    protected $fillable = ['key', 'value', 'type', 'group', 'description'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('greeate.site_settings'));
        static::deleted(fn () => Cache::forget('greeate.site_settings'));
    }

    public function getTypedValue(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'integer', 'number' => (int) $this->value,
            'float', 'decimal' => (float) $this->value,
            'json', 'array' => json_decode($this->value, true) ?? [],
            default => $this->value,
        };
    }

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('greeate.site_settings', function () {
            return static::all()->keyBy('key');
        });

        $setting = $settings->get($key);

        return $setting ? $setting->getTypedValue() : $default;
    }
}
