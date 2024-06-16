<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Branch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = "branches";
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'address',
        'branch_id',
        'date',
        'email',
        'user_id',
        'phone_number',
        'is_main_branch',
        'weekend',
        'open_time',
        'close_time',
        'status',
        'created_by',
        'updated_by',
    ];

    public function scopeActive($query)
    {
        $query->where('status', true);
    }

    public function scopeWithOutMainBranch($query)
    {
        $query->where('is_main_branch', 0);
    }

    public function scopeCrMasterReport($query, Request $request)
    {
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        $query->withSum(['saleDetails as sale_pcs' => function ($query) use ($from_date, $to_date) {
            $query->deliveredSale('sale.saleDelivery')
                ->deliveredSale('sale.exchanges.exchangeDelivery')
                ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
        }], 'quantity')
            ->withSum(['saleReturnDetails as return_pcs' => function ($query) use ($from_date, $to_date) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
            }], 'quantity')
            ->withSum(['saleDetails as exchange_pcs' => function ($query) use ($from_date, $to_date) {
                $query->whereNotNull('sale_exchange_id')
                    ->deliveredSale('exchange.exchangeDelivery')
                    ->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
            }], 'quantity')
            ->withSum(['sales as sale_total' => function ($query) use ($from_date, $to_date) {
                $query->deliveredSale('saleDelivery')->whereBetween('date', [$from_date, $to_date]);
            }], 'net_total')
            ->withSum(['saleExchange as sale_exchange_total' => function ($query) use ($from_date, $to_date) {
                $query->deliveredSale('exchangeDelivery')->whereBetween('date', [$from_date, $to_date]);
            }], 'net_total')
            ->withSum(['stocks as sales_product_purchase' => function ($query) use ($from_date, $to_date) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereHas('sales', function (Builder $q) use ($from_date, $to_date) {
                        $q->filterByDate($from_date, $to_date);
                    })->deliveredSale('sales.saleDeliveries');
            }], 'buy_price')
            ->withSum(['sales as discount_amount' => function ($query) use ($from_date, $to_date) {
                $query->deliveredSale('saleDeliveries')->whereBetween('date', [$from_date, $to_date]);
            }], 'discount_amount')
            ->withSum(['sales as flat_discount' => function ($query) use ($from_date, $to_date) {
                $query->deliveredSale('saleDeliveries')->whereBetween('date', [$from_date, $to_date]);
            }], 'flat_discount')
            ->withSum(['sales as normal_delivery_cost' => function ($query) use ($from_date, $to_date) {
                $query->whereHas('saleDeliveries', function ($q) {
                    $q->where('order_status', SaleDelivery::ORDER_STATUS['delivered']);
                })->whereBetween('date', [$from_date, $to_date]);
            }], 'delivery_charge')
            ->withSum(['sales as return_delivery_cost' => function ($query) use ($from_date, $to_date) {
                $query->whereHas('saleDeliveries', function ($q) {
                    $q->where('order_status', SaleDelivery::ORDER_STATUS['returned']);
                })->whereBetween('date', [$from_date, $to_date]);
            }], 'delivery_charge')
            ->withSum(['saleExchange as exchange_delivery_cost' => function ($query) use ($from_date, $to_date) {
                $query->whereHas('exchangeDelivery', function ($q) {
                    $q->where('order_status', SaleDelivery::ORDER_STATUS['delivered']);
                })->whereBetween('date', [$from_date, $to_date]);
            }], 'delivery_charge')
            ->costTypeAmount('daily_cost', $from_date, $to_date)
            ->costTypeAmount('monthly_cost', $from_date, $to_date)
            ->costTypeAmount('one_time_cost', $from_date, $to_date);
    }

    public function scopeCostTypeAmount($query, $value, $from_date, $to_date)
    {
        $query->withSum(['costs as ' . $value => function ($query) use ($value, $from_date, $to_date) {
            $query->whereCostType($value)->whereBetween(DB::raw('DATE(created_at)'), [$from_date, $to_date]);
        }], 'amount');
    }


    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'current_branch', 'id')->where('stock_status', '!=' , 4);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'branch_id', 'id');
    }

    public function saleExchange(): HasMany
    {
        return $this->hasMany(SaleExchange::class, 'branch_id', 'id');
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(Sale_detail::class, 'branch_id', 'id');
    }

    public function saleReturnDetails(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class, 'branch_id', 'id');
    }

    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class, 'branch_id', 'id');
    }

    public function transfers()
    {
        return $this->hasMany(TransferReceive::class, 'transfer_branch', 'id');
    }

    public function transferProducts()
    {
        return $this->hasMany(TransferReceiveDetail::class, 'transfer_branch', 'id');
    }


    protected function weekend(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

}
