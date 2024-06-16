<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory , CreatedUpdatedBy;

    protected $table = 'shipping_addresses';
    protected $primaryKey = 'id';
    protected $fillable = [
                'name',
                'address',
                'mobile',
                'landmark',
                'division_id',
                'district_id',
                'thana_id',
                'type',
                'address_type',
                'customer_id',
                'zip_code',
                'status',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class, 'thana_id', 'id');
    }
}
