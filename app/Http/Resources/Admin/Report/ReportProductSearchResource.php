<?php

namespace App\Http\Resources\Admin\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportProductSearchResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $product_name = $this->product->name;
        if (isset($this->productVariations)) {
            $product_name = $this->product->name . '-' . collect($this->productVariations->variantValues)
                    ->pluck('variantValueName.variation_value')
                    ->implode('-');
        }
        return [
            'value' => $this->product_barcode,
            'text' => $product_name,
            'product_id' => $this->product_id,
            'product_sku' => $this->product_sku,
            'sell_price' => $this->sell_price,
            'buy_price' => $this->buy_price,
        ];
    }
}
