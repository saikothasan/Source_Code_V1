<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class BranchPaymentMethod extends Model
{
    use HasFactory;
        protected $table = "branch_payment_methods";
    protected  $primaryKey = "id";
    protected $fillable = ['payment_method_id', 'branch_id', 'total_balance', 'transfer_balance'];


    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }


}
