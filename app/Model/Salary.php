<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;


class Salary extends Model
{
    protected $fillable = [

        'date', 'employee_id', 'note', 'amount', 'department_id', 'month_id', 'late', 'leave_days', 'absent', 'present', 'late_fine',
    ];
}
