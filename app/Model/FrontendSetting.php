<?php

namespace App\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FrontendSetting extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'key', 'value'];

    /**
     * Get all the settings
     *
     * @return self
     */
    public static function getAllFrontendSettings()
    {
         return Cache::rememberForever('frontend_settings.all', static function () {
             return self::select(['key', 'value'])->get();
         });
    }


    /**
     * Get all the settings in array
     *
     * @return array
     */
    public static function getFrontendSettingsArray(): array
    {
         return Cache::rememberForever('frontend_settings.toArray', static function () {
             return self::getAllFrontendSettings()->pluck('value', 'key')->toArray();
         });
    }

    /**
     * Check if setting exists
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return (bool)self::getAllFrontendSettings()->whereStrict('key', $key)->count();
    }

    /**
     * Get a settings value
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    public static function get(string $key, ?string $default = null)
    {
        if (self::has($key)) {
            $setting = self::getAllFrontendSettings()->where('key', $key)->first();
            return $setting->value;
        }
        return $default;
    }

    /**
     * Add a settings value
     *
     * @param string $key
     * @param string $value
     * @return string|bool
     */
    public static function add(string $key, $value)
    {
        if (self::has($key)) {
            return self::set($key, $value);
        }

        return self::create(['key' => $key, 'value' => $value]) ?? $value;
    }
    /**
     * Set a value for setting
     *
     * @param $key
     * @param $value
     * @return string|bool
     */
    public static function set($key, $value)
    {
        if ($setting = self::where('key', $key)->first()) {
            return $setting->update([
                'key' => $key,
                'value' => $value
            ]);
        }
        return self::add($key, $value);
    }

    /**
     * Update Settings
     *
     * @param array $data
     * @return void
     */
    public static function updateSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('frontend_settings.all');
        Cache::forget('frontend_settings.toArray');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }
}
