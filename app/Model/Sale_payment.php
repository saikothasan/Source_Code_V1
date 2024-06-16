<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Session;



class Sale_payment extends Model
{

    use  CreatedUpdatedBy;

    protected $table = "sale_payments";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'sale_id',
        'paid',
        'due',
        'change_amount',
        'user_id',
        'customer_id',
        'branch_id',
        'payments',
        'created_by',
        'updated_by',
        'sale_exchange_id',
        'payable_amount',
    ];

    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    protected function payments(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }
}
