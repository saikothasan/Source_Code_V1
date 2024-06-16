<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SaleReturnDetail extends Model
{
    use Compoships;
    use HasFactory, CreatedUpdatedBy;

    protected $table = "sale_return_details";
    protected $primaryKey = "id";
    protected $fillable = [
        'return_type',
        'sale_id',
        'sale_return_id',
        'user_id',
        'customer_id',
        'branch_id',
        'supplier_id',
        'product_id',
        'product_sku',
        'product_barcode',
        'vat_total',
        'discount_total',
        'flat_discount_total',
        'buy_rate',
        'sale_rate',
        'quantity',
        'product_total',
        'net_total',
        'created_by',
        'updated_by'
    ];

    const RETURN_TYPE = [
        'return' => 1,
        'exchange_return' => 2,
    ];

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }

    public function saleReturn(): HasOne
    {
        return $this->hasOne(Sale_return::class, 'id', 'sale_return_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }



}
