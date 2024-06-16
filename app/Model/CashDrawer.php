<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashDrawer extends Model
{
    use HasFactory;
    use CreatedUpdatedBy;
    protected $table='cash_drawers';
    protected $primaryKey='id';
    protected $fillable= [
        'name',
        'branch_id',
        'amount',
    ];


}
