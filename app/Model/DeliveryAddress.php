<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;
 
    protected $table  = 'delivery_addresses';
    protected $primaryKey = 'id';
    protected $fillable = ['name','amount', 'status'];
}
