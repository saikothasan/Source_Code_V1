<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class SalePaymentHistory extends Model
{
    use HasFactory;

    use  CreatedUpdatedBy;

    protected $table = "sale_payment_histories";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'sale_id',
        'sale_payment_id',
        'sale_exchange_id',
        'pay_amount',
        'paid_total',
        'due_amount',
        'change_amount',
        'user_id',
        'branch_id',
        'customer_id',
        'payment_method_id',
        'payment_number',
        'payment_reference',
        'created_by',
        'updated_by',
        'payable_amount'
    ];

    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    public function sales(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }


}
