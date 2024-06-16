<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Brand extends Model
{
    protected $table = "brands";
    protected  $primaryKey = "id";
    protected $fillable = [
        'name',
        'status',
    ];

    public function scopeActive($query)
    {
        return $query->where('status',true);
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
  

    public function totalVariants(): HasManyThrough
    {
        return $this->hasManyThrough(ProductVariantSkuBarcode::class,Product::class);
    }

    public function availableStocks(): HasManyThrough
    {
        return $this->hasManyThrough(Stock::class,Product::class);
    }
}
