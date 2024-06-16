<?php

namespace App\Actions\Sale\Exchange;

use App\Model\SaleExchange;

class SaleExchangeNewAction
{

    public $new_exchange_product, $new_exchange_payment;

    public function __construct()
    {
        $this->new_exchange_product = new NewExchangeProductAction();
        $this->new_exchange_payment = new NewExchangePaymentAction();
    }

    /**
     * @throws \Exception
     */
    public function execute($request, $sale): array
    {
        $user = auth()->user();
        $suppliers = collect($request->sale_products)->pluck('supplier_id')->unique()->toArray();
        $sale_exchange = new SaleExchange();
        $exchange = [
            'date' => date('Y-m-d'),
            'sale_id' => $sale->id,
            'user_id' => $user->id,
            'branch_id' => $sale->branch_id,
            'seller_id' => $sale->seller_id,
            'suppliers_id' => $suppliers,
            'customer_id' => $sale->customer_id,
            'delivery_id' => $request->delivery_man['id'] ?? null,
            'delivery_charge' => $request->delivery_charge,
            'vat_percentage' => $request->vat_percentage,
            'vat_amount' => $request->vat_amount,
            'discount_percentage' => $request->discount_percentage,
            'additional_delivery_charge' => $request->additional_delivery_charge,
            'additional_charge' => $request->additional_charge,
            'discount_amount' => $request->discount_amount,
            'change_amount' => $request->change_amount,
            'flat_discount' => $request->flat_discount,
//            'net_total' => $request->sale_net_total,
            'net_total' => $request->payable_amount,
            'payable_amount' => $request->payable_amount,
            'pay_amount' => $request->pay_amount,
            'due_total' => $request->due_total,
            'return_total' => $request->return_calculation['return_total'],
        ];
        $sale_exchange->fill($exchange)->save();
        $this->new_exchange_product->execute($request, $sale, $sale_exchange);
        if ($request->payable_amount > 0) {
            $this->new_exchange_payment->execute($request, $sale, $sale_exchange);
        }
        if ($request->get('deliveryOption') && $request->get('delivery_man')) {
            $newSaleExcahngeDeliveryAction = new NewSaleExcahngeDeliveryAction();
            $newSaleExcahngeDeliveryAction->execute($request, $sale_exchange);
        }
        return $exchange;
    }
}
