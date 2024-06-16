<?php

namespace App\Http\Resources\Admin\Sale;

use App\Model\Sale_detail;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceProducts extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $types = [
            Sale_detail::SALETYPE['sale'] => 'sale',
            Sale_detail::SALETYPE['exchange'] => 'exchange',
        ];
        $product_name = $this->product->name;
        if (isset($this->productVariations)) {
            $product_name = $this->product->name . collect($this->productVariations->variantValues)
                ->pluck('variantValueName.variation_value')
                ->implode('-');
        }
        return [
            'sale_detail_id' => $this->id,
            'sale_type' => $types[$this->sale_type],
            'sale_id' => $this->sale_id,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'supplier_id' => $this->supplier_id,
            'branch_id' => $this->branch_id,
            'product_id' => $this->product_id,
            'product_name' => $product_name,
            'product_sku' => $this->product_sku,
            'product_barcode' => $this->product_barcode,
            'vat_total' => floatFormat($this->vat_total),
            'discount_total' => floatFormat($this->discount_total),
            'flat_discount_total' => floatFormat($this->flat_discount_total),
            'buy_rate' =>  floatFormat($this->buy_rate),
            'sale_rate' => floatFormat($this->sale_rate),
            'quantity' => floatFormat($this->quantity),
            'product_total' =>  floatFormat($this->product_total),
            'net_total' => floatFormat($this->net_total),
            'final_sale_rate' => floatFormat(($this->net_total / $this->quantity)),
            'single_discount' =>  floatFormat(($this->discount_total / $this->quantity)),
            'single_vat' =>  floatFormat(($this->vat_total / $this->quantity)),
            'single_flat_discount' =>  ($this->flat_discount_total / $this->quantity),
        ];
    }
}
