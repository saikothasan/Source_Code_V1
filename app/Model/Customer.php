<?php

namespace App\Model;


use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $guard = 'customer';
    use Compoships , Notifiable;
    /**
     * @var string
     */

    protected $fillable = [
        'name',
        'email',
        'phone',
        'area',
        'photo',
        'address',
        'credit_limit',
        'note',
        'district_id',
        'zip_code',
        'password',
        'otp',
        'date_of_birth',
        'facebook_id',
        'status'
    ];
    protected function password(): Attribute
    {
        return Attribute::make(
         
            set: fn($value) =>  Hash::make($value),
        );
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'otp',   'remember_token'
    ];



    const STATUS = [
        'Active' => 1,
        'Inactive' => 0,
    ];
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->where('phone', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeFilterByBranch($query, $search)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->whereHas('sales', function ($q) use ($search) {
                $q->where('branch_id', $search);
            });
        });
    }

    public function scopeFilterByDate($query, $start, $end)
    {
        return $query->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$start, $end]);
        });
    }


    public function scopeFilterByPhone(Builder $query, $phone): Builder
    {
        return $query->where('phone', $phone);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }

    public function saleDetails(): HasMany
    {
        return $this->hasMany(Sale_detail::class, 'customer_id', 'id');
    }

    public function saleReturnProducts(): HasMany
    {
        return $this->hasMany(SaleReturnDetail::class, 'customer_id', 'id');
    }

    public function exchangeProducts(): HasMany
    {
        return $this->saleDetails()->where('sale_type',Sale_detail::SALETYPE['exchange']);
    }


}
