<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;


class Loan_advance extends Model
{
    protected $fillable = [
        'date', 'employee_id', 'note', 'amount', 'department_id', 'type',
    ];

}
