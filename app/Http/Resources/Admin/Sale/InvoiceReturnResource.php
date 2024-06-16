<?php

namespace App\Http\Resources\Admin\Sale;

use App\Model\Sale_return;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceReturnResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $types = [
            Sale_return::RETURN_TYPE['return'] => 'return' ,
            Sale_return::RETURN_TYPE['exchange_return'] => 'exchange_return' ,
        ];
        return [
            'id' => $this->id,
            'type_name' => $this->type_name,
            'return_date' => $this->return_date,
            'return_type' => $types[$this->return_type],
            'format_date' => date('d F y',strtotime($this->return_date)),
            'user_id' => $this->user_id,
            'branch_id' => $this->branch_id,
            'customer_id' => $this->customer_id,
            'vat_percentage' => $this->vat_percentage,
            'vat_amount' => $this->vat_amount,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'flat_discount' => $this->flat_discount,
            'total_discount' => ($this->discount_amount+$this->flat_discount),
            'return_total' => $this->return_total,
            'return_amount' => $this->return_amount,
            'product_total' => $this->whenLoaded('returnProducts')->sum('product_total'),
            'return_products' => ReturnProductResource::collection($this->whenLoaded('returnProducts')),
        ];
    }
}
