<?php

namespace App\Model;

use App\Model\Invest;
use App\Traits\CreatedUpdatedBy;
use DB;
use Illuminate\Database\Eloquent\Model;
use Session;


class PurchaseDue extends Model
{
    use CreatedUpdatedBy;

    protected $table = "purchase_dues";
    protected $primaryKey = "id";

    protected $fillable = [
        'date',
        'purchase_invoice',
        'purchase_id',
        'user_id',
        'supplier_id',
        'total_amount',
        'paid_total',
        'due_total',
        'created_by',
        'updated_by',
    ];

}
