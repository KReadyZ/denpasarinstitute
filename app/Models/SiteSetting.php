<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        return Cache::remember('site_setting_' . $key, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return ($setting && $setting->value !== null && $setting->value !== '') ? $setting->value : $default;
        });
    }

    public static function set(string $key, ?string $value, string $group = 'general', ?string $label = null): static
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget('site_setting_' . $key);

        return $setting;
    }

    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $k) {
            Cache::forget('site_setting_' . $k);
        }
    }
}

