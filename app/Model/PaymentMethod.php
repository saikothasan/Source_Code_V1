<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'reference_status',
        'status',
        'photo',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }


    public function methodBalance(): HasMany
    {
        return $this->paymentMethodMethod()->where('branch_id', auth()->user()->branch_id);
    }

    public function paymentMethodMethod(): HasMany
    {
        return $this->hasMany(BranchPaymentMethod::class,'payment_method_id','id');
    }

    public function paymentMethodHistory():HasMany {
        return  $this->hasMany(BranchPaymentMethodHistory::class,'payment_method_id','id');
    }
    public function toDayPayment(): HasMany
    {
        return $this->paymentMethodHistory()->where('branch_id', auth()->user()->branch_id)->where('date', date('Y-m-d'));
    }


}
