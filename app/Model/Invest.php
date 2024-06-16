<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;


class Invest extends Model
{
    protected $fillable = [
    	'date', 'type', 'amount', 'note',
    ];

}
