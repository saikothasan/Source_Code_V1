<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SaleDelivery extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = "sale_deliveries";
    protected $primaryKey = "id";

    protected $fillable = [
        'date', 'sale_id', 'sale_exchange_id', 'details', 'consignment_id', 'merchant_order_id', 'branch_id', 'customer_id',
        'delivery_id', 'delivery_charge', 'additional_delivery_charge','amount_to_collect', 'order_status', 'created_by', 'updated_by',
        'tracking_number', 'comments'
    ];

    const ORDER_STATUS = [
        'pending' => 0,
        'delivered' => 1,
        'returned' => 2,
        'cancelled' => 3,
    ];
    protected $appends = ['status'];


    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where('consignment_id', 'LIKE', '%' . $search . '%')
                ->orWhereHas('sale', function ($q) use ($search) {
                    $q->where('invoice_code', 'LIKE', '%' . $search . '%');
                })->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('branch', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('deliveryMan', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }



    public function scopeFilterBySeller($query, $search)
    {
        return $query->when($search)->whereRelation( 'sale' ,'seller_id', $search);
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    protected function getStatusAttribute()
    {
        return Constant::DELIVERY_STATUS[$this->attributes['order_status']];
    }

    public function deliveryMan()
    {
        return $this->hasOne(DeliveryMan::class, 'id', 'delivery_id');
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
}
