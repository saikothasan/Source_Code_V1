<?php

namespace App\Actions\Sale\Exchange;

use App\Model\SaleDelivery;
use App\Services\PathaoService;

class NewSaleExcahngeDeliveryAction
{
    public function execute($request, $sale_exchange): void
    {
        $amount_to_collect = 0;
        $cod = collect($request->get('sale_payments'))->where('payment_method.text', "COD")->first();
        if ($cod) {
            $amount_to_collect = $cod['pay_amount'];
        }

        $saleDelivery = new SaleDelivery();
        $saleDelivery->date = $sale_exchange->date;
        $saleDelivery->sale_id = $sale_exchange->sale_id;
        $saleDelivery->sale_exchange_id = $sale_exchange->id;
        $saleDelivery->details = $request->get('pathao_info');
        $saleDelivery->branch_id = $sale_exchange->branch_id;
        $saleDelivery->customer_id = $sale_exchange->customer_id;
        $saleDelivery->delivery_id = $sale_exchange->delivery_id;
        $saleDelivery->delivery_charge = $sale_exchange->delivery_charge;
        $saleDelivery->additional_delivery_charge = $sale_exchange->additional_delivery_charge;
        $saleDelivery->amount_to_collect = $amount_to_collect;
        $saleDelivery->order_status = SaleDelivery::ORDER_STATUS['pending'];
        $saleDelivery->save();
        if ($request->get('pathao_info')) {
            $params = [
                'store_id' => $request->pathao_info['store']['store_id'],
                'recipient_name' => $request->pathao_info['recipient_name'],
                'recipient_phone' => $request->pathao_info['recipient_phone'],
                'recipient_address' => $request->pathao_info['recipient_address'],
                'recipient_city' => $request->pathao_info['recipient_city']['city_id'],
                'recipient_zone' => $request->pathao_info['recipient_zone']['zone_id'],
                'delivery_type' => $request->pathao_info['delivery_type'],
                'item_type' => $request->pathao_info['item_type'],
                'special_instruction' => $request->pathao_info['special_instruction'],
                'item_quantity' => $request->pathao_info['item_quantity'],
                'item_weight' => $request->pathao_info['item_weight'],
                'amount_to_collect' => $request->pathao_info['amount_to_collect'],
                'item_description' => $request->pathao_info['item_description'],
                'merchant_order_id' => $sale_exchange->invoice_code,
            ];
            if (isset($request->pathao_info['recipient_area']['area_id'])) {
                $params['recipient_area'] = $request->pathao_info['recipient_area']['area_id'];
            }
            $endpoint = 'orders';
            $pathaoResponse = PathaoService::post($endpoint, $params);
            if ($pathaoResponse->code == 200) {
                $saleDelivery->consignment_id = $pathaoResponse->data->consignment_id;
                $saleDelivery->merchant_order_id = $pathaoResponse->data->merchant_order_id;
                $saleDelivery->save();
            } else {
                throw new \Exception('Sale create failed please reload');
            }
        }
    }
}
