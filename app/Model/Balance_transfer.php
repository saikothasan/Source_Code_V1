<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;



class Balance_transfer extends Model
{
    protected $fillable = [
    	'date', 'amount', 'note',  'type',
    ];

}
