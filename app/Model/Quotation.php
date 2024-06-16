<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Session;


class Quotation extends Model
{

    protected $fillable = [

        'date', 'subtotal', 'vat_percentage', 'vat', 'discount', 'total', 'note', 'company', 'phone', 'email', 'address',
    ];

}
