<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Variation extends Model
{
    protected $table = "variations";
    protected  $primaryKey = "id";
    protected $fillable = [
        'variation_name',
        'type_id',
        'variation_value',
        'variation_code',
        'status',
    ];

    public function scopeVariation($query)
    {
        return $query->whereNull('type_id');
    }

    public function variantType(): HasOne
    {
        return $this->hasOne(self::class,'id','type_id');
    }

    public function variationValue(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(self::class,'type_id','id');
    }

}
