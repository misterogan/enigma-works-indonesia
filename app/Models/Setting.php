<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Semua pengaturan dalam satu array, disimpan di cache. */
    public static function allCached(): array
    {
        return Cache::rememberForever('site.settings', fn () => static::pluck('value', 'key')->all());
    }

    public static function get(string $key, $default = null)
    {
        $value = static::allCached()[$key] ?? null;

        return ($value === null || $value === '') ? $default : $value;
    }

    /** Teks per baris menjadi array. */
    public static function lines(string $key): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) static::get($key, '')))));
    }

    /** Baris "Judul | Teks" menjadi array pasangan [judul, teks]. */
    public static function pairs(string $key): array
    {
        return array_map(function ($line) {
            $parts = array_map('trim', explode('|', $line, 2));

            return [$parts[0], $parts[1] ?? ''];
        }, static::lines($key));
    }

    public static function put(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site.settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('site.settings'));
        static::deleted(fn () => Cache::forget('site.settings'));
    }
}
