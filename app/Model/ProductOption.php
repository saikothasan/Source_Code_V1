<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ProductOption extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "product_options";
    protected $primaryKey = "id";
    protected $fillable = [
        'product_id',
        'option_id',
    ];

    public function optionName(): HasOne
    {
        return $this->hasOne(Variation::class, 'id', 'option_id');
    }

    public function optionValues(): HasMany
    {
        return $this->hasMany(ProductVariantValues::class, 'product_id', 'product_id');
    }
}
