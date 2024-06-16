<?php

namespace App\Http\Resources\Admin\Sale;

use App\Model\SaleReturnDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnProductResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $types = [
            SaleReturnDetail::RETURN_TYPE['return'] => 'return' ,
            SaleReturnDetail::RETURN_TYPE['exchange_return'] => 'exchange_return' ,
        ];
        $product_name = $this->product->name;
        if (isset($this->productVariations)) {
            $product_name = $this->product->name . collect($this->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
        }
        return [
            'sale_return_details' => $this->id,
            'sale_return_id' => $this->sale_return_id,
            'sale_detail_id' => $this->id,
            'return_type' => $types[$this->return_type],
            'sale_id' => $this->sale_id,
            'user_id' => $this->user_id,
            'customer_id' => $this->customer_id,
            'supplier_id' => $this->supplier_id,
            'branch_id' => $this->branch_id,
            'product_id' => $this->product_id,
            'product_name' => $product_name,
            'product_sku' => $this->product_sku,
            'product_barcode' => $this->product_barcode,
            'vat_total' => $this->vat_total,
            'discount_total' => $this->discount_total,
            'flat_discount_total' => $this->flat_discount_total,
            'buy_rate' => $this->buy_rate,
            'sale_rate' => $this->sale_rate,
            'quantity' => $this->quantity,
            'product_total' => $this->product_total,
            'net_total' => $this->net_total,
            'final_sale_rate' => ($this->net_total / $this->quantity),
            'single_discount' => ($this->discount_total / $this->quantity),
            'single_vat' => ($this->vat_total / $this->quantity),
        ];
    }
}
