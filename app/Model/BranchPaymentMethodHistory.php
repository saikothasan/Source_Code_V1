<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\CreatedUpdatedBy;


class BranchPaymentMethodHistory extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = "branch_payment_method_histories";
    protected  $primaryKey = "id";

    protected $fillable = [
        'date',
        'type',
        'invoice_reference',
        'sale_id',
        'sale_exchange_id',
        'branch_id',
        'payment_method_id',
        'payment_number',
        'payment_reference',
        'pay_amount',
        'payable_amount',
        'return_amount',
        'created_by',
        'updated_by',
    ];


    const TYPE = [
        'sale' => 1,
        'exchange' => 2,
        'return' => 2,
    ];

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }


    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }
}
