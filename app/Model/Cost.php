<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;


class Cost extends Model
{
    use CreatedUpdatedBy;

    protected $table = "costs";
    protected $primaryKey = "id";
    protected $fillable = [
        'cost_type',
        'cost_category',
        'amount',
        'details',
        'receipt_no',
        'branch_id',
        'cost_branch_id',
        'employee_id',
        'asset_branch_id',
        'payment_method_id'
    ];


    public function generateReceiptCode(): string
    {
        $lastId = self::query()->latest()->first();
        $lastId = $lastId->id ?? 0;
        return 'CFC-' . (str_pad((int)$lastId + 1, 5, '0', STR_PAD_LEFT));
    }

    protected function details(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    public function scopeFilterByBranch($query, $search)
    {
        return $query->when($search)->where('branch_id', $search);
    }

    public function scopeFilterByCostType($query, $category)
    {

        return $query->when($category, function ($query) use ($category) {
            $query->where('cost_type', $category);
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$start, $end]);
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function costBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'cost_branch_id', 'id');
    }

    public function assetBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'asset_branch_id', 'id');
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }
}
