<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ProductVariantSkuBarcode extends Model
{
    use \Awobaz\Compoships\Compoships;

    protected $table = "product_variant_sku_barcodes";
    protected $primaryKey = "id";
    protected $fillable = [
        'product_id',
        'variant_price',
        'variant_buy_price',
        'variant_sku',
        'variant_barcode',
        'discount_type',
        'discount_percentage',
        'discount_amount',
        'status',
    ];

    /**
     * Scope a query to filter by variant barcode.
     *
     * @param Builder $query
     * @param $barcode
     * @return Builder
     */

    public function scopeFilterByBarcode(Builder $query, $barcode): Builder
    {
        return $query->where('variant_barcode', $barcode);
    }


    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }

    public function variantValues(): HasMany
    {
        return $this->hasMany(ProductVariantValues::class, ['product_id', 'product_variant_sku_id'], ['product_id', 'id']);
    }
    public function productStock(): HasMany
    {
        return $this->hasMany(Stock::class,'product_barcode', 'variant_barcode');
    }
}
