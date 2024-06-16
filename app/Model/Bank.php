<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Expr\FuncCall;


class Bank extends Model
{

    protected $table = 'banks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'account_no',
        'amount',
        'transfer_amount',
        'user_id',
        'branch_id',
        'is_main_bank'
    ];

    public function scopeMainBank($query)
    {
        $query->where('is_main_bank', 1);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bankTransfers(): HasMany
    {
        return $this->hasMany(BankTransfer::class, 'receiver_bank_id', 'id');
    }


    public function storeBank(Object $request)
    {
        $this->name = $request->name;
        $storeBank = $this->save();

        $storeBank
            ? session()->flash('message', 'New Bank Stored Successfully!')
            : session()->flash('message', 'Something Went Wrong');
    }

    public function updateBank(Object $request, Int $id)
    {
        $bank = $this::findOrFail($id);
        $bank->name = $request->name;
        $updateBank = $bank->save();

        $updateBank
            ? session()->flash('message', 'Bank Updated Successfully!')
            : session()->flash('message', 'Something Went Wrong');
    }

    public function destroyBank(Int $id)
    {
        $bank = $this::findOrFail($id);
        $destroyBank = $bank->delete();

        $destroyBank
            ? session()->flash('message', 'Bank Deleted Successfully!')
            : session()->flash('message', 'Something Went Wrong');
    }
}
