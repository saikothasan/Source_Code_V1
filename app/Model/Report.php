<?php

namespace App\Model;

use App\Constant\Constant;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = "reports";
    protected $primaryKey = "id";
    protected $fillable = [
        'report_id',
        'report_name',
        'from_date',
        'to_date',
        'details',
        'description',
        'created_by',
        'updated_by'
    ];

    const REPORT_TYPE = [
        'sales_report' => 1,
        'stock_report' => 2,
        'cr_master_report' => 3,
        'product_report' => 4,
    ];
    protected function getReportNameAttribute()
    {
        return Constant::REPORT_TYPE_NAME[$this->attributes['report_name']] ?? '';
    }


    public function scopegenerateReportId(): string
    {
        $last_report = self::query()->count();
        $prefix = 'RC-';
        return $prefix . date('dmy') .
            (str_pad((int)$last_report + 1, 3, '0', STR_PAD_LEFT));
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value),
        );
    }
}
