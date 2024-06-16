<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Purchase_detail extends Model
{
    use CreatedUpdatedBy;
    use \Awobaz\Compoships\Compoships;

    protected $table = "purchase_details";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'invoice',
        'user_id',
        'purchase_id',
        'product_id',
        'product_sku',
        'product_barcode',
        'supplier_id',
        'main_branch',
        'quantity',
        'rate',
        'sell_price',
        'total',
        'created_by',
        'updated_by',
    ];

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }


    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function productStock(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'product_id');
    }

    public function availableStock(): HasMany
    {
        return $this->hasMany(Stock::class, ['supplier_id', 'product_id', 'product_barcode'], ['supplier_id', 'product_id', 'product_barcode']);
    }


    public function availableMainBranchStock(): HasMany
    {
        return $this->hasMany(Stock::class,
            ['purchase_id', 'product_id', 'product_barcode', 'supplier_id'],
            ['purchase_id', 'product_id', 'product_barcode', 'supplier_id'])
            ->where('stock_status', Stock::STATUS['Stock'])
            ->whereNull('sale_id')
            ->whereNull('sale_detail_id')
            ->whereNull('transfer_id')
            ->where('current_branch', auth()->user()->branch_id);
    }

    public function soldProduct(): HasMany
    {
        return $this->hasMany(Sale_detail::class, ['supplier_id', 'product_id', 'product_barcode'], ['supplier_id', 'product_id', 'product_barcode']);
    }

    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }
}
