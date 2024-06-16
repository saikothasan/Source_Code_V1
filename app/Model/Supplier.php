<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Session;


class Supplier extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'area',
        'photo',
        'address',
        'company',
        'company_phone',
        'due',
        'note',
        'owner_name',
        'user_id'

    ];


    public function SupplierProduct()
    {
        return $this->hasMany(Purchase::class, 'supplier_id', 'id');
    }

    public function supplierPurchaseDetail()
    {
        return $this->hasOne(Purchase_detail::class, 'supplier_id', 'id');
    }

    public function supplierPurchasePayment()
    {
        return $this->hasOne(PurchasePayment::class, 'supplier_id', 'id');
    }

    public function supplierPurchaseDuePayment()
    {
        return $this->hasOne(PurchaseDue::class, 'supplier_id', 'id');
    }

    public function supplierSaleDetails()
    {
        return $this->hasOne(Sale_detail::class, 'supplier_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class,'supplier_id','id');
    }

}
