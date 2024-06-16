<?php

namespace App\Actions\Sale;

use App\Model\Sale;

class SaleAction
{
    public function handle($request, $sale)
    {
        $customerAction = new CustomerAction();
        $customer = $customerAction->handle($request);
        $user = auth()->user();
        $suppliers = collect($request->sale_products)->pluck('supplier_id')->unique()->toArray();
        $sale_data = [
            'date' => date('Y-m-d'),
            'sale_type' => Sale::SALETYPE['pos_sale'],
            'invoice_code' => Sale::generateInvoiceCode(),
            'user_id' => $user->id,
            'branch_id' => $user->branch_id,
            'seller_id' => $request->seller_id,
            'suppliers_id' => $suppliers,
            'customer_id' => $customer->id,
            'delivery_id' => $request->delivery_man['id'] ?? null,
            'delivery_charge' => $request->delivery_charge,
            'additional_delivery_charge' => $request->additional_delivery_charge,
            'additional_charge' => $request->additional_charge,
            'vat_percentage' => $request->vat_percentage,
            'vat_amount' => $request->vat_amount,
            'discount_percentage' => $request->discount_percentage,
            'discount_amount' => $request->discount_amount,
            'change_amount' => $request->change_amount,
            'flat_discount' => $request->flat_discount,
            'net_total' => $request->sale_net_total,
            'final_total' => $request->sale_net_total,
            'payable_amount' => $request->sale_net_total,
            'pay_amount' => $request->pay_amount,
            'due_total' => $request->due_total,
            'customer_address' => $request->customer['address'],
        ];
        $sale->fill($sale_data)->save();
        return $sale;
    }
}
