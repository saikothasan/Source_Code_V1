<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;


class Product_transfer extends Model
{
    protected $fillable = [

        'date', 'user_id', 'product_code', 'quantity', 'product_id',
    ];
}
