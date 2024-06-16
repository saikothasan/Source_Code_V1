<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariantValues extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = "product_variant_values";
    protected $primaryKey = "id";
    protected $fillable = [
        'product_id',
        'product_variant_sku_id',
        'option_id',
        'variant_value',
    ];

    public function variantValueName(): HasOne
    {
       return $this->hasOne(Variation::class,'id','variant_value');
    }
}
