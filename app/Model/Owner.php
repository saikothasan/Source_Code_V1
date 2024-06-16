<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;


class Owner extends Model
{
    protected $fillable = [
    	'date', 'note', 'amount',
    ];

}
