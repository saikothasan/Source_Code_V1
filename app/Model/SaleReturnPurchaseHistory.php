<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnPurchaseHistory extends Model
{
    use HasFactory;

    protected $table = "sale_return_purchase_histories";
    protected $primaryKey = "id";
    protected $fillable = [
        'return_type',
        'purchase_id',
        'product_id',
        'product_sku',
        'product_barcode',
        'supplier_id',
        'branch_id',
        'customer_id',
        'sale_id',
        'sale_detail_id',
        'buy_rate',
        'sale_rate',
        'quantity',
        'buy_total',
        'sale_total',
        'created_by',
        'updated_by'
    ];

    const RETURN_TYPE = [
        'return' => 1,
        'exchange_return' => 2,
    ];

}
