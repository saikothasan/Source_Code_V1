<?php

namespace App\Http\Resources\Admin\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseProductsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {

        $product_name = $this->product->name;
        if (isset($this->productVariations)) {
            $product_name = $this->product->name . collect($this->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
        }
        return [
            'purchase_details_id' => $this->id,
            'date' => $this->date,
            'invoice' => $this->invoice,
            'user_id' => $this->user_id,
            'purchase_id' => $this->purchase_id,
            'product_name' => $product_name,
            'product_id' => $this->product_id,
            'product_sku' => $this->product_sku,
            'product_barcode' => $this->product_barcode,
            'supplier_id' => $this->supplier_id,
            'main_branch' => $this->main_branch,
            'quantity' => $this->quantity,
            'return_quantity' => 0,
            'rate' => $this->rate,
            'total' => $this->total,
            'available_stock' => $this->available_stock,
        ];
    }
}
