<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SaleExchange extends Model
{
    use Compoships;
    use HasFactory,CreatedUpdatedBy;
    protected $table = "sale_exchanges";
    protected $primaryKey = "id";
    protected $fillable = [
        'date', 'sale_id',  'user_id', 'branch_id', 'suppliers_id', 'customer_id',
        'delivery_id', 'vat_percentage', 'vat_amount', 'discount_percentage', 'discount_amount',
        'flat_discount', 'delivery_charge', 'additional_delivery_charge','additional_charge' ,'change_amount', 'net_total', 'pay_amount',
        'due_total', 'customer_address', 'created_by', 'updated_by', 'seller_id', 'payable_amount',
        'return_total'
    ];

    public function suppliersId(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }


    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->WhereHas('sale', function ($q) use ($search) {
                $q->where('invoice_code', 'LIKE', '%' . $search . '%');
            });
        });
    }


    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }

    public function scopeFilterByBranch($query, $search)
    {
        return $query->when($search)->where('branch_id', $search);
    }

    public function scopeFilterBySeller($query, $search)
    {
        return $query->when($search)->whereRelation( 'sale' ,'seller_id', $search);
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
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }


    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function saleProducts(): HasMany
    {
        return $this->hasMany(Sale_detail::class, 'sale_exchange_id', 'id')
            ->where('sale_type', Sale_detail::SALETYPE['exchange']);
    }

    public function exchangePayment(): HasOne
    {
        return $this->hasOne(Sale_payment::class, 'sale_exchange_id', 'id');
    }

    public function deliveryMan(): HasOne
    {
        return $this->hasOne(DeliveryMan::class, 'id', 'delivery_id');
    }

    public function exchangeDelivery(): HasOne
    {
        return $this->hasOne(SaleDelivery::class, 'sale_exchange_id', 'id')
            ->whereNotNull('sale_exchange_id');
    }


}
