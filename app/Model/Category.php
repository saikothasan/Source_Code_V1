<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Cache;
use Session;


class Category extends Model
{
    protected $table = "categories";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function totalVariants(): HasManyThrough
    {
        return $this->hasManyThrough(ProductVariantSkuBarcode::class,Product::class);
    }

    public function availableStocks(): HasManyThrough
    {
        return $this->hasManyThrough(Stock::class,Product::class);
    }

    public static function flushCache()
    {
        Cache::forget('allCategory');
    }

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
