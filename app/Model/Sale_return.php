<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Sale_return extends Model
{

    use CreatedUpdatedBy;

    protected $table = "sale_returns";
    protected $primaryKey = 'id';
    protected $fillable = [
        'return_type',
        'return_date',
        'sale_id',
        'user_id',
        'branch_id',
        'customer_id',
        'vat_percentage',
        'vat_amount',
        'discount_percentage',
        'discount_amount',
        'flat_discount',
        'return_total',
        'return_amount',
        'created_by',
        'updated_by'
    ];

    protected $appends = ['type_name'];

    const RETURN_TYPE = [
        'return' => 1,
        'exchange_return' => 2,
    ];

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
            $query->whereBetween('return_date', [$start, $end]);
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

    public function getTypeNameAttribute()
    {
        return Constant::SALE_RETURN_TYPE[$this->attributes['return_type']];
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

    public function returnProducts(): HasMany
    {
        return $this->products();
    }

    public function products(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class,'sale_return_id','id');
    }
}

