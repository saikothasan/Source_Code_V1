<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class DeliveryMan extends Model
{
    protected $table = 'delivery_men';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'phone',
        'nid',
        'address',
        'delivery_area',
        'photo',
        'delivery_charge',
        'inside_dhaka_charge',
        'outside_dhaka_charge',
        'status'
    ];


    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('nid', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

}
