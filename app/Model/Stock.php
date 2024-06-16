<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Stock extends Model
{
    use \Awobaz\Compoships\Compoships;
    use CreatedUpdatedBy;

    protected $table = "stocks";
    protected $primaryKey = "id";
    protected $fillable = [
        'purchase_id',
        'purchase_details_id',
        'product_id',
        'product_sku',
        'product_barcode',
        'sell_price',
        'buy_price',
        'user_id',
        'supplier_id',
        'main_branch',
        'current_branch',
        'transfer_id',
        'sale_id',
        'sale_detail_id',
        'purchase_return_id',
        'stock_status',
        'offer_id',
        'offer_type',
        'created_by',
        'updated_by',
    ];


    const STATUS = [
        'Sale' => 0,
        'Stock' => 1,
        'TransferHold' => 2,
        'PurchaseReturn' => 3,
        'PurchasePending' => 4,
        'PurchaseCancelled' => 5,
    ];

    public function scopeFilterByLikeBarcode(Builder $query, $sku): Builder
    {
        return $query->when($sku, function ($query) use ($sku) {
            $query->where('product_barcode', 'LIKE', '%' . $sku . '%');
        });
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

    public function scopeStockProduct($query)
    {
        return $query->where('stock_status', self::STATUS['Stock'])
            ->whereNull('sale_id')
            ->whereNull('sale_detail_id')
            ->whereNull('purchase_return_id')
            ->whereNull('transfer_id');
    }

    public function scopeOfferStockProduct($query, $offer, $offerType)
    {
        return $query
            ->where('offer_id', $offer)
            ->where('offer_type', $offerType)
            ->with(['offer' => function ($q) {
                return $q->active();
            }])
            ->where('stock_status', self::STATUS['Stock'])
            ->whereNull('sale_id')
            ->whereNull('sale_detail_id')
            ->whereNull('purchase_return_id')
            ->whereNull('transfer_id');
    }


    public function saleDelivery()
    {
        return $this->hasOne(SaleDelivery::class, 'sale_id', 'sale_id');
    }

    public function scopeFilterByBrand($query, $brand)
    {
        return $query->when($brand, function ($query) use ($brand) {
            $query->where('brand_id', $brand);
        });
    }

    public function scopeFilterByCategory($query, $category)
    {
        return $query->when($category, function ($query) use ($category) {
            $query->where('category_id', $category);
        });
    }

    public function scopeSearchProduct($query, $request)
    {
        return $query->when($request->get('search'), function ($search) use ($request) {
            $search->where('product_barcode', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhere('product_sku', 'LIKE', '%' . $request->get('search') . '%')
                ->orWhereHas('product', function (Builder $q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->get('search') . '%');
                });
        })->when($request->get('supplier'), function ($supplier) use ($request) {
            $supplier->WhereHas('product', function (Builder $q) use ($request) {
                $q->where('supplier_id', $request->get('supplier'));
            });
        })->when($request->get('brand'), function ($brand) use ($request) {
            $brand->WhereHas('product', function (Builder $q) use ($request) {
                $q->where('brand_id', $request->get('brand'));
            });
        })->when($request->get('category'), function ($brand) use ($request) {
            $brand->WhereHas('product', function (Builder $q) use ($request) {
                $q->where('category_id', $request->get('category'));
            });
        });
    }

    public function scopeUserBranch($query, $branch_id)
    {
        return $query->where('current_branch', $branch_id);
    }

    public function scopeOfferProduct($query, $offer_id, $offer_type)
    {
        return $query->where('offer_id', $offer_id)
            ->where('offer_type', $offer_type);
    }

    public function scopeFilterByBarcode(Builder $query, $product_code): Builder
    {
        return $query->when($product_code, function ($query) use ($product_code) {
            $query->where('product_code', $product_code);
        });
    }

    public function scopeFilterBySupplier(Builder $query, $supplier): Builder
    {
        return $query->when($supplier, function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier);
        });
    }

    public function scopeFilterBySku(Builder $query, $sku): Builder
    {
        return $query->when($sku, function ($query) use ($sku) {
            $query->where('product_sku', $sku);
        });
    }

    public function scopeFilterByBranch(Builder $query, $branch): Builder
    {
        return $query->when($branch, function ($query) use ($branch) {
            $query->where('current_branch', $branch);
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween(\Illuminate\Support\Facades\DB::raw('DATE(stocks.created_at)'), [$start, $end]);
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
                    SaleDelivery::ORDER_STATUS['cancelled'],
                ]
            );
        });
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'current_branch');
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(Purchase_detail::class, 'id', 'purchase_details_id');
    }

    public function purchaseDetail(): HasOne
    {
        return $this->hasOne(Purchase_detail::class, 'id', 'purchase_details_id');
    }

    public function scopeStockDetail($query)
    {
        return $query->with([
            'purchaseDetail:id,rate',
            'product:id,name,is_active,sell_price,buy_price',
            'productVariations.variantValues.variantValueName',
        ]);
    }




    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductVariantSkuBarcode::class, 'product_id', 'product_id');
    }

    public function productVariations(): HasOne
    {
        return $this->hasOne(ProductVariantSkuBarcode::class, ['product_id', 'variant_barcode'], ['product_id', 'product_barcode']);
    }

    public function saleDetails(): HasOne
    {
        return $this->hasOne(Sale_detail::class, ['id', 'sale_id'], ['sale_detail_id', 'sale_id']);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'id', 'sale_id');
    }


    public function offer(): HasOne
    {
        return $this->hasOne(Offer::class, 'id', 'offer_id');
    }

    public function productOffer()
    {
        return $this->hasMany(OfferProduct::class, ['product_barcode', 'offer_id'], ['product_barcode', 'offer_id']);
    }

}
