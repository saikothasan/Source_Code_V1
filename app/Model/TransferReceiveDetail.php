<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class TransferReceiveDetail extends Model
{
    use HasFactory, CreatedUpdatedBy;
    use \Awobaz\Compoships\Compoships;

    protected $table = "transfer_receive_details";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'invoice_code',
        'user_id',
        'transfer_invoice_id',
        'transfer_receive_from',
        'product_id',
        'product_sku',
        'product_barcode',
        'supplier_id',
        'main_branch',
        'transfer_branch',
        'current_branch',
        'quantity',
        'rate',
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

    public function transfer(): HasOne
    {
        return $this->hasOne(TransferReceive::class, 'id', 'transfer_invoice_id');
    }

    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }
}
