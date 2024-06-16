<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class QuotationDetail extends Model
{

    protected $fillable = [
        'quotation_id', 'product_id', 'quantity', 'rate', 'total',
    ];


}
