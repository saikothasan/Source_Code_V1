<?php

namespace App\Actions\Sale;

use App\Model\SaleDelivery;
use App\Services\PathaoService;
use App\Services\WinxService;

class SaleDeliveryAction
{
    public function handle($request, $sale)
    {
//        return $request->get('winx_info');
        $amount_to_collect = 0;
        $cod = collect($request->get('sale_payments'))->where('payment_method.text', "COD")->first();
        if ($cod) {
            $amount_to_collect = $cod['pay_amount'];
        }

        $saleDelivery = new SaleDelivery();
        $saleDelivery->date = $sale->date;
        $saleDelivery->sale_id = $sale->id;
        if ($request->get('pathao_info')){

            $saleDelivery->details = $request->get('pathao_info');
        }
        if ($request->get('winx_info')){

            $saleDelivery->details = $request->get('winx_info');
        }
        $saleDelivery->branch_id = $sale->branch_id;
        $saleDelivery->customer_id = $sale->customer_id;
        $saleDelivery->delivery_id = $sale->delivery_id;
        $saleDelivery->delivery_charge = $sale->delivery_charge;
        $saleDelivery->additional_delivery_charge = $sale->additional_delivery_charge;
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
                'merchant_order_id' => $sale->invoice_code,
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
        if ($request->get('winx_info')) {
            $params = [
                'pickup_id' => $request->winx_info['store']['value'],
                'name' => $request->winx_info['recipient_name'],
                'mobile' => $request->winx_info['recipient_phone'],
                'address' => $request->winx_info['recipient_address'],
                'package' => $request->winx_info['package']['value'],
                'delivery_area' => $request->winx_info['delivery_area']['value'],
                'sale_price' => $request->winx_info['amount_to_collect'],
                'merchant_invoice' => $sale->invoice_code,
            ];
            $endpoint = '/api/parcel';
            $winxResponse = WinxService::post($endpoint, $params);
            if ($winxResponse) {
                $saleDelivery->consignment_id = $winxResponse->tracking;
                $saleDelivery->merchant_order_id = $sale->invoice_code;
                $saleDelivery->save();
            } else {
                throw new \Exception('Sale create failed please reload');
            }
        }
    }
}
