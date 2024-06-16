<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;

class Cash extends Model
{
    protected $fillable = [
    	'date', 'amount', 'in_cash','type','bank_id','user_name','description'
    ];



    public function bank()
    {
        return $this->belongsTo('App\Model\Bank_transaction', 'bank_id');
    }

}
