<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\FuncCall;


class BankTransfer extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;

    protected $table = "banks_transfers";
    protected $primaryKey = 'id';
    protected $fillable = [
        'type',
        'date',
        'user_id',
        'receiver_bank_id',
        'sender_bank_id',
        'paid',
        'due',
        'reference_id',
        'payment_method_id',
        'branch_id',
        'current_branch_id',
        'cash_id',
        'connect_id', //cash history id
        'status',
        'money_transfer_id'
    ];
    protected $appends = ['bank_status'];

    const STATUS = [
        'Pending' => 0,
        'Receive' => 1,
        'Reject' => 2,
        'delivery_return' => 3,
    ];


    public function generateSupplierReference($supplier): string
    {
        $supplier_name = Str::upper(substr($supplier['name'], 0, 1));
        $lastInvoice = self::query()->where('user_id',$supplier['user_id'])->count();
        $prefix = "CP-".$supplier_name;
        return $prefix . '-' . date('dmy') .
            (str_pad((int)$lastInvoice + 1, 3, '0', STR_PAD_LEFT));


    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('date', [$start, $end]);
        });
    }


    protected function getBankStatusAttribute()
    {
        return Constant::BANK_STATUS[$this->attributes['status']] ?? '';
    }

    public function scopeFilterByStatus($query, $status)
    {
        // dd($query->where);

        if ($status) {
            return $query->when($status->get('status') == 'pending', function ($query) {
                $query->where('status', 0);
            })

                ->when($status->get('status') == 'transfer', function ($query) {
                    $query->where('status', 1)->where('type', 'supplier');
                })
                ->when($status->get('status') == 'received', function ($query) {
                    $query->where('status', 1)->where('type', '!=', 'supplier')->where('created_by', '!=', auth()->user()->id);
                })
                ->when($status->get('status') == 'send', function ($query) {
                    $query->where('status', 1)->where('type', '!=', 'supplier')->where('created_by', auth()->user()->id);
                });
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function receiverBank()
    {
        return $this->belongsTo(Bank::class, 'receiver_bank_id', 'id');
    }

    public function senderBank()
    {
        return $this->belongsTo(Bank::class, 'sender_bank_id', 'id');
    }
    public function scopeWithOutMainBank($query)
    {
        $query->where('is_main_branch', 0);
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class, 'id', 'connect_id');
    }

    //    public function generateReferenceCode(): string
    //    {
    //        $lastId = self::query()->latest()->first();
    //        $lastId = $lastId->id ?? 0;
    //        return 'CD' . '-' . auth()->user()->id . '-' .(str_pad((int)$lastId+1, 5, '0', STR_PAD_LEFT));
    //    }
}
