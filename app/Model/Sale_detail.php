<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Sale_detail extends Model
{

    use Compoships;
    use CreatedUpdatedBy;

    protected $table = "sale_details";
    protected $primaryKey = "id";
    protected $fillable = [
        'sale_type',
        'sale_id',
        'sale_exchange_id',
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

    const SALETYPE = [
        'sale' => 1,
        'exchange' => 2,
    ];

    public function scopeSearchProduct($query, $request)
    {
        return $query->when($request->get('search'), function ($search) use ($request) {
            $search->where('product_barcode', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('product_sku', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhereHas('product', function (Builder $q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->get('search') . '%');
                });
        });
    }

    public function scopeDeliveredSale($query, $relation)
    {
        $query->whereDoesntHave($relation, function ($q) {
            $q->whereIn(
                'order_status',
                [
                    SaleDelivery::ORDER_STATUS['pending'],
                    SaleDelivery::ORDER_STATUS['returned'],
                    SaleDelivery::ORDER_STATUS['cancelled']
                ]
            );
        });
    }


    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, ['id'], ['sale_id']);
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function exchange(): HasOne
    {
        return $this->hasOne(SaleExchange::class, ['id'], ['sale_exchange_id']);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }


    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'user_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'supplier_id');
    }
}
