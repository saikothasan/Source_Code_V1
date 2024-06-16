<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Session;


class Purchase extends Model
{
    use CreatedUpdatedBy;

    protected $table = "purchases";
    protected $primaryKey = "id";
    protected $fillable = [
        'date',
        'invoice',
        'supplier_id',
        'user_id',
        'vat_percentage',
        'vat',
        'extra_cost_name',
        'extra_cost',
        'discount_percentage',
        'discount',
        'total_quantity',
        'subtotal',
        'total',
        'note',
        'send_by',
        'receive_by',
        'main_branch',
        'sender_type',
        'status',
        'created_by',
        'updated_by'
    ];


    const STATUS = [
        'approved' => 1,
        'pending' => 2,
        'cancelled' => 3,
    ];

    const SENDER_TYPE = [
        'management' => 1,
        'supplier' => 2,
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where('invoice', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeFilterBySupplier($query, $supplier)
    {
        return $query->when($supplier, function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier);
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }

    public function purchaseDetails(): HasMany
    {
        return $this->hasMany(Purchase_detail::class, 'purchase_id', 'id');
    }

    public function purchaseDue(): HasOne
    {
        return $this->hasOne(PurchaseDue::class, 'purchase_id', 'id');
    }

    public function purchasePayments(): HasMany
    {
        return $this->hasMany(PurchasePaymentInvoice::class, 'purchase_id', 'id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'purchase_id', 'id');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function receive(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'receive_by');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
