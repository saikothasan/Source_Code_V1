<?php

namespace App\Model;


use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;


class Sale extends Model
{

    use Compoships;
    use CreatedUpdatedBy;

    protected $table = "sales";
    protected $primaryKey = "id";

    protected $fillable = [
        'date', 'sale_type', 'invoice_code', 'user_id', 'branch_id', 'suppliers_id', 'customer_id',
        'delivery_id', 'vat_percentage', 'vat_amount', 'discount_percentage', 'discount_amount',
        'flat_discount', 'delivery_charge', 'additional_delivery_charge','additional_charge' ,'change_amount', 'net_total', 'final_total', 'pay_amount',
        'due_total', 'customer_address', 'created_by', 'updated_by', 'seller_id', 'payable_amount',
        'return_total', 'exchange_total'
    ];

    const SALETYPE = [
        'pos_sale' => 1,
        'ecommerce_sale' => 2,
    ];

    public function scopeSaleType($query, $type)
    {
        return $query->where('sale_type', $type);
    }


    public static function generateInvoiceCode(): string
    {
        $branch = Branch::query()->where('id', auth()->user()->branch_id)->firstOrFail();
        $branch = Str::upper(substr($branch->name, 0, 1));
        $prefix = 'CF' . $branch;
        $lastInvoice = self::query()
            ->where('invoice_code', 'LIKE', $prefix . '%')
            ->whereDate('date', today())
            ->latest()->count() ?? 0;
        return $prefix . '-' . date('dmy') .
            (str_pad((int)$lastInvoice + 1, 3, '0', STR_PAD_LEFT));
    }

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where('invoice_code', 'LIKE', '%' . $search . '%')
                ->orWhereHas('customer', function ($q) use ($search) {
                    $q->where('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                })->orWhereHas('user', function ($q) use ($search) {
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

    public function scopeFilterByBranch($query, $search)
    {
        return $query->when($search)->where('branch_id', $search);
    }

    public function scopeFilterBySeller($query, $search)
    {
        return $query->when($search)->where('seller_id', $search);
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



    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function salePayment(): HasOne
    {
        return $this->hasOne(Sale_payment::class, 'sale_id', 'id');
    }

    public function salePayments(): HasMany
    {
        return $this->hasMany(SalePaymentHistory::class, 'sale_id', 'id');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, ['id'], ['customer_id']);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function seller(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(DeliveryMan::class, 'id', 'delivery_id');
    }


    public function saleDelivery(): HasOne
    {
        return $this->hasOne(SaleDelivery::class, 'sale_id', 'id')->whereNull('sale_exchange_id');
    }

    public function  saleDeliveries(): HasMany
    {
        return $this->hasMany(SaleDelivery::class, 'sale_id', 'id');
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(Sale_detail::class, 'sale_id', 'id');
    }

    public function saleProducts(): HasMany
    {
        return $this->saleDetails()->where('sale_type', Sale_detail::SALETYPE['sale']);
    }

    public function exchangeProducts(): HasMany
    {
        return $this->saleDetails()->where('sale_type', Sale_detail::SALETYPE['exchange']);
    }

    public function saleReturns(): HasMany
    {
        return $this->returns();
    }

    public function returns(): HasMany
    {
        return $this->hasMany(Sale_return::class, 'sale_id', 'id');
    }

    public function returnProducts(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class, 'sale_id', 'id');
    }

    public function exchanges(): HasMany
    {
        return $this->hasMany(SaleExchange::class, 'sale_id', 'id');
    }

    public function suppliersId(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }


}
