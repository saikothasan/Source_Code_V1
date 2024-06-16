<?php

namespace App\Model;

use App\Model\Bank_transaction;
use App\Model\Owner;
use DB;
use Illuminate\Database\Eloquent\Model;
use Session;


class Sale_due_collection extends Model
{
    protected $fillable = [

    	 'date', 'paid', 'due', 'user_id', 'customer_id', 'payment_method', 'reference_code'
    ];
}
