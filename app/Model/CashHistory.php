<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class CashHistory extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = 'cash_histories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cash_id',
        'cost_id',
        'branch_id', //receiver branch id
        'current_branch_id', //sender branch id
        'receiver_branch_id', //cash drawer transfer receiver  branch id
        'sale_id',
        'sale_exchange_id',
        'cash_type',
        'note',
        'sender_id', //sender branch id
        'date',
        'employee_id',
        'supplier_id',
        'payment_method_id',
        'payment_reference',
        'amount',
        'status',
        'money_transfer_id',
        //        'receive_type',
    ];

    protected $appends = ['cash_type_name', 'cash_status'];

    const CASH_TYPE = [
        'cash_in' => 0,
        'payment' => 1,
        'transfer' => 2,
        'sale' => 3,
        'sale_return' => 4,
        'payment_method' => 5,
        'cost'   => 6,
        'bank_to_cash' => 7,
    ];

    const STATUS = [
        'pending' => 0,
        'received' => 1,
        'transfer' => 2,
        'receive' => 3,
        'reject' => 4,

    ];

    protected function getCashTypeNameAttribute()
    {
        return Constant::CASH_TYPE[$this->attributes['cash_type']];
    }

    protected function getCashStatusAttribute()
    {
        return Constant::CASH_STATUS[$this->attributes['status']] ?? '';
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }

    public function scopeFilterByType($query, $cashIn, $payment, $transfer)
    {
        return $query->when($cashIn || $payment || $transfer, function ($query) use ($cashIn) {
            $query->where('cash_type', $cashIn);
        })->orWhere(function ($query) use ($payment) {
            $query->orWhere('cash_type', $payment);
        })->orWhere(function ($query) use ($transfer) {
            $query->orWhere('cash_type', $transfer);
        });
    }

    public function branch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }
    public function receiverBranch(): HasOne
    {
        return $this->hasOne(Branch::class, 'id', 'receiver_branch_id');
    }

    public function bank(): HasOne
    {
        return $this->hasOne(Bank::class, 'account_no', 'payment_reference');
    }

    public function employee(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'employee_id');
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function sender(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
