<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class PurchaseReturnProduct extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    use \Awobaz\Compoships\Compoships;

    protected $table = "purchase_return_products";
    protected $primaryKey = 'id';
    protected $fillable = [
        'purchase_return_id', 'purchase_id',
        'purchase_detail_id', 'product_id',
        'product_sku', 'product_barcode',
        'quantity', 'rate', 'total',
        'supplier_id', 'branch_id',
        'user_id', 'created_by', 'updated_by'
    ];


    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$start, $end]);
        });
    }


    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class,'id','purchase_id');
    }



    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id','product_id');
    }


    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }
}
