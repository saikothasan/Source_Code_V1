<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Session;
use DB;


class Bank_transaction extends Model
{
    protected $fillable = [
    	'date', 'amount', 'type', 'description', 'name' , 'bank_id',
    ];

    public function bank():BelongsTo
    {
        return $this->belongsTo('App\Model\Bank', 'bank_id');
    }

}
