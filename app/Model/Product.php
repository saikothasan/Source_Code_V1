<?php

namespace App\Model;

use App\Traits\CreatedUpdatedBy;
use Awobaz\Compoships\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Session;

class Product extends Model
{
    use CreatedUpdatedBy;

    protected $table = "products";
    protected $primaryKey = "id";
    protected $fillable = [
        'name',
        'product_slug',
        'product_sku',
        'brand_id',
        'supplier_id',
        'product_options',
        'photo',
        'description',
        'product_code',
        'vat',
        'buy_price',
        'product_margin',
        'product_profit',
        'discount_type',
        'discount_percentage',
        'discount_amount',
        'sell_price',
        'type',
        'category_id',
        'created_by',
        'updated_by'
    ];

    /**
     * Scope a query to filter by product sku.
     *
     * @param Builder $query
     * @param $sku
     * @return Builder
     */

    public function scopeFilterByLikeSku(Builder $query, $sku): Builder
    {
        return $query->when($sku, function ($query) use ($sku) {
            $query->where('product_sku', 'LIKE', '%' . $sku . '%');
        });
    }

    public function scopeFilterBySku(Builder $query, $sku): Builder
    {
        return $query->when($sku, function ($query) use ($sku) {
            $query->where('product_sku', $sku);
        });
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('product_code', 'LIKE', '%' . $search . '%')
            ->orWhere('product_sku', 'LIKE', '%' . $search . '%');
    }

    public function scopeFilterByBarcode($query, $product_code)
    {
        return $query->when($product_code, function ($query) use ($product_code) {
            $query->where('product_code', $product_code);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFilterBySupplier($query, $supplier)
    {
        return $query->when($supplier, function ($query) use ($supplier) {
            $query->where('supplier_id', $supplier);
        });
    }

    public function scopeFilterByBrand($query, $brand)
    {
        return $query->when($brand, function ($query) use ($brand) {
            $query->where('brand_id', $brand);
        });
    }

    public function scopeFilterByCategory($query, $category)
    {
        return $query->when($category, function ($query) use ($category) {
            $query->where('category_id', $category);
        });
    }


    public function scopeVariantSkuBarcodeValues(Builder $query): Builder
    {
        return $query->with(['productVariantSkuBarcode.variantValues.variantValueName:id,variation_value,variation_code,type_id']);
    }



    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'product_id', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }

    public function productVariantSkuBarcode(): HasMany
    {
        return $this->hasMany(ProductVariantSkuBarcode::class, 'product_id', 'id', 'products');
    }

    public function productVariantValues(): HasMany
    {
        return $this->hasMany(ProductVariantValues::class, 'product_id', 'id');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productPurchaseDetails(): HasOne
    {
        return $this->hasOne(Purchase_detail::class, 'product_id', 'id');
    }

    public function productStock(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }
    public function offerProductStock(): HasMany
    {
        return $this->hasMany(Stock::class, 'product_id', 'id');
    }
    protected function productSlug(): Attribute
    {
        return Attribute::make(
            set: fn($value) => Str::slug($this->name),
        );
    }

    public function productImage(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function thumbnailImage(): HasOne
    {
        return $this->hasOne(ProductImage::class, 'product_id', 'id');
    }
}
