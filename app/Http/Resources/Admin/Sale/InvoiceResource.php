<?php

namespace App\Http\Resources\Admin\Sale;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $payment_name = collect($this->whenLoaded('salePayment')->payments)->pluck('payment_method.text')->implode('<br>');
        return [
            'id' => $this->id,
            'date' => $this->date,
            'sale_date' => date('d F y', strtotime($this->date)),
            'invoice_code' => $this->invoice_code,
            'user_id' => $this->user_id,
            'seller_id' => $this->seller_id,
            'suppliers_id' => $this->suppliers_id,
            'branch_id' => $this->branch_id,
            'customer_id' => $this->customer_id,
            'delivery_id' => $this->delivery_id,
            'vat_percentage' => $this->vat_percentage,
            'vat_amount' => $this->vat_amount,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'flat_discount' => $this->flat_discount,
            'delivery_charge' => $this->delivery_charge,
            'additional_delivery_charge' => floatFormat($this->additional_delivery_charge),
            'additional_charge' => floatFormat($this->additional_charge),
            'change_amount' => $this->change_amount,
            'net_total' => $this->net_total,
            'final_total' => $this->final_total,
            'pay_amount' => $this->pay_amount,
            'due_total' => $this->due_total,
            'customer' => $this->whenLoaded('customer', [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'address' => $this->customer_address,
            ]),
            'invoice_products' => InvoiceProducts::collection($this->whenLoaded('saleProducts')),
            'invoice_payment' => $this->whenLoaded('salePayment'),
            'payments_name' => $payment_name,
            'delivery' => $this->whenLoaded('delivery'),
            'sale_returns' => InvoiceReturnResource::collection($this->whenLoaded('saleReturns')),
        ];
    }
}
