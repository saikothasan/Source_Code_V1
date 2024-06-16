<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Session;


class PurchasePayment extends Model
{
    use CreatedUpdatedBy;

    protected $table = "purchase_payments";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'from_date',
        'to_date',
        'receipt_no',
        'purchase_invoice',
        'purchase_id',
        'total_buy_price',
        'total_advance',
        'total_pay',
        'total_due',
        'total_payable',
        'user_id',
        'supplier_id',
        'receiver_bank_id',
        'sender_bank_id',
        'payment_method_id',
        'payment_number',
        'payment_reference',
        'created_by',
        'updated_by',
    ];


    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }


    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function supplierBank(): HasOne
    {
        return $this->hasOne(Bank::class, 'id', 'receiver_bank_id');
    }

    public function generateReceiptCode($supplier): string
    {
        $lastId = self::query()
            ->whereDate('date', today())
            ->where('supplier_id', $supplier['id'])
            ->latest()
            ->count();
        return 'SP-' . strtoupper(substr($supplier['name'], 0, 1)) . '-' . date('dmy') . (str_pad((int)$lastId + 1, 3, '0', STR_PAD_LEFT));
    }

    public function paidAmount(): HasMany
    {
        return $this->hasMany(PurchasePaymentInvoice::class, 'purchase_payments_id', 'id');
    }
}
