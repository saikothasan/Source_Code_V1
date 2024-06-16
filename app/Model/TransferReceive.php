<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;


class TransferReceive extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = "transfer_receives";
    protected $primaryKey = "id";
    protected $fillable = [
        'date',
        'invoice_type',
        'invoice_code',
        'supplier_id',
        'user_id',
        'total_quantity',
        'subtotal',
        'total',
        'note',
        'supplier_id',
        'transfer_branch',
        'receive_branch',
        'receive_by',
        'main_branch',
        'status',
        'created_by',
        'updated_by'
    ];

    const  INVOICE_TYPE = [
        'transfer' => 1,
        'receive' => 2,
    ];

    const  STATUS = [
        'Transferring' => 0,
        'Receiving' => 0,
        'Transferred' => 1,
        'Received' => 1,
        'Reject' => 2
    ];

    public function scopeSearch($query, Request $request)
    {
        $query->where('invoice_code', 'LIKE', '%' . $request->get('search') . '%')
            ->when($request->get('from-date') && $request->get('to-date'), function ($query) use ($request) {
                $query->whereBetween('date', [$request->get('from-date'), $request->get('to-date')]);
            });
    }

    public function productDetails(): HasMany
    {
        return $this->hasMany(TransferReceiveDetail::class, 'transfer_invoice_id', 'id');
    }

    public function scopeTansferInvoice($query)
    {
        return $query->where('invoice_type', self::INVOICE_TYPE['transfer']);
    }

    public function scopeReceiveInvoice($query)
    {
        return $query->where('invoice_type', self::INVOICE_TYPE['receive']);
    }


    public function sendBranch()
    {
        return $this->hasOne(Branch::class, 'id', 'transfer_branch');
    }

    public function receiveBranch()
    {
        return $this->hasOne(Branch::class, 'id', 'receive_branch');
    }

    public function sendUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function receiveUser()
    {
        return $this->hasOne(User::class, 'id', 'receive_by');
    }

}
