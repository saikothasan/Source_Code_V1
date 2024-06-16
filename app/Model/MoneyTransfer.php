<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MoneyTransfer extends Model
{
    use HasFactory,CreatedUpdatedBy;
    protected $table="money_transfers";
    protected $primaryKey="id";
    protected $fillable=[
        'date',
        'payment_method_id',
        'current_branch_id',
        'receiver_branch_id',
        'receive_type',
        'cash_drawer_id',
        'bank_id',
        'bank_account_no',
        'available_amount',
        'transfer_amount',
        'remaining_amount',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $appends = ['money_transfer_status'];

    const STATUS = [
        'pending' => 0,
        'Receive' => 1,
        'Reject' => 2,
    ];


    protected function getMoneyTransferStatusAttribute()
    {
        return Constant::MONEY_TRANSFER_STATUS[$this->attributes['status']] ?? '';
    }
    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class,'id','payment_method_id');
    }
    public function bank()
    {
        return $this->hasOne(Bank::class,'account_no','bank_account_no');
    }
    public function branch()
    {
        return $this->hasOne(Branch::class,'id','current_branch_id');
    }
    public function cashDrawer()
    {
        return $this->hasOne( CashDrawer::class,'id','cash_drawer_id');
    }
    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class,'receiver_bank_id','bank_id');
    }
}
