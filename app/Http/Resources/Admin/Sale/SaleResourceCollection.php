<?php

namespace App\Http\Resources\Admin\Sale;

use App\Constant\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResourceCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $status = "Sale";
        if (isset($this['sale_id'])) {
            $sale_id = $this['sale_id'];
            $invoice_code = $this['sale']['invoice_code'];
            $customer_phone = $this['sale']['customer']['phone'];
            $customer_name = $this['sale']['customer']['name'];
            $branch_name = $this['branch']['name'];
            $user_name = $this['user']['name'];
            $seller_name = $this['sale']['seller']['name'];
            $total_items = $this['total_items'];
            $total_quantity = $this['total_quantity'];
            $total_amount = $this['net_total'] ?? 0;

        } else {
            $sale_id = $this['id'];
            $invoice_code = $this['invoice_code'];
            $customer_phone = $this['customer']['phone'] ?? '';
            $customer_name = $this['customer']['name'] ?? '';
            $branch_name =$this['branch']['name'];
            $user_name = $this['user']['name'];
            $seller_name = $this['seller']['name'];
            $total_items = $this['total_items'];
            $total_quantity = $this['total_quantity'];
            $total_amount = $this['net_total'];

        }
        $delivery_return = 0;
        if(isset($this['return_type'])) {
            $total_amount = -$this['return_total'];
            $delivery_return = $this['sale']['delivery_charge'];
            $status = "Returned";
            if($delivery_return <=0) {
                $status = "Sale Returned";
            }
        }
        if(isset($this['sale_delivery'])) {
            $status = $this['sale_delivery']['status'];
        }
        if(isset($this['exchange_delivery'])) {
            $status = $this['exchange_delivery']['status'];
        }
        return [
            'sale_id' => $sale_id,
            'date' => $this['date'],
            'date_time' => $this['created_at'],
            'invoice_code' => $invoice_code,
            'customer_phone' => $customer_phone,
            'customer_name' => $customer_name,
            'branch_name' => $branch_name,
            'user_name' => $user_name,
            'seller_name' => $seller_name,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'total_amount' => $total_amount,
            'delivery_return' => $delivery_return,
            'status' => Constant::SALE_STATUS_LABEL[$status],
        ];
    }
}
