<?php

namespace App\Http\Resources\Admin\Purchase;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'date' => $this->date,
                'date_format' => date('d F Y',strtotime($this->date)),
                'return_date' => date('d F Y'),
                'invoice' => $this->invoice,
                'supplier_id' => $this->supplier_id,
                'user_id' => $this->user_id,
                'total_quantity' => $this->total_quantity,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'receive_by' => $this->receive_by,
                'main_branch' => $this->main_branch,
                'purchase_items' => $this->purchase_details_count,
                'send_by' => $this->send_by,
                'receive' => $this->receive,
                'user' => $this->user,
                'purchase_products' => PurchaseProductsResource::collection($this->whenLoaded('purchaseDetails'))
        ];
    }
}
