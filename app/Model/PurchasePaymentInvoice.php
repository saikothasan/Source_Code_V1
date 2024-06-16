<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class PurchasePaymentInvoice extends Model
{
    use HasFactory;

    protected $table = "purchase_payment_invoices";
    protected $primaryKey = "id";

    public $timestamps = false;

    protected $fillable = [
        'purchase_payments_id',
        'purchase_id',
        'purchase_invoice',
        'total_pay',
        'total_due',
    ];

    public function bankHistory(): HasOne
    {
        return $this->hasOne(BankTransfer::class,'connect_id','purchase_payments_id')
            ->where('type','supplier');
    }

}
