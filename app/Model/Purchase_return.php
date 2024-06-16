<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Purchase_return extends Model
{

    use CreatedUpdatedBy;

    protected $table = "purchase_returns";
    protected $primaryKey = 'id';
    protected $fillable = [
        'date',
        'purchase_id',
        'total_quantity',
        'total_amount',
        'supplier_id',
        'branch_id',
        'user_id',
        'status',
        'created_by',
        'updated_by'
    ];

    const STATUS = [
        'pending' => 0,
        'received' => 1,
        'reject' => 2,
    ];

    protected $appends = ['status_text'];

    protected function getStatusTextAttribute()
    {
        return Constant::PURCHASES_RETURN_STATUS[$this->attributes['status']];
    }


    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->whereHas('purchase', function ($q) use ($search) {
                $q->where('invoice', 'LIKE', '%' . $search . '%');
            });
        });
    }

    public function scopeFilterBySupplier($query, $supplier)
    {
        return $query->when($supplier, function ($query) use ($supplier) {
            $query->whereHas('purchase', function ($q) use ($supplier) {
                $q->where('supplier_id', $supplier);
            });
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }

    public function returnProducts()
    {
        return $this->hasMany(PurchaseReturnProduct::class, 'purchase_return_id', 'id');
    }

    public function purchase(): HasOne
    {
        return $this->hasOne(Purchase::class, 'id', 'purchase_id');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
