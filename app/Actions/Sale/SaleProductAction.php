<?php

namespace App\Actions\Sale;

use App\Model\Sale_detail;
use App\Model\Stock;

class SaleProductAction
{
    public function handle($request, $sale): void
    {
        $totalQuantity = collect($request->sale_products)->sum('quantity');
        //        $vats = [];
        foreach ($request->sale_products as $value) {
            $discountTotal = round(($sale->discount_amount / $totalQuantity) * $value['quantity']);
            $vatTotal = round(($sale->vat_amount / $totalQuantity) * $value['quantity']);
            //            $vats[] = [
            //                'vatTotal' => $vatTotal,
            //                'discountTotal' => $discountTotal,
            //            ];
            $flatDiscountTotal = 0.00;
            if ($sale->flat_discount) {
                $flatDiscountTotal = ($sale->flat_discount / $totalQuantity) * $value['quantity'];
            }
            $netTotal = (($value['total_price'] + $vatTotal) - ($discountTotal));
            $sale_detail = new Sale_detail();
            $sale_product = [
                'sale_type' => Sale_detail::SALETYPE['sale'],
                'sale_id' => $sale->id,
                'user_id' => $sale->user_id,
                'customer_id' => $sale->customer_id,
                'branch_id' => $sale->branch_id,
                'vat_total' => $vatTotal,
                'discount_total' => $discountTotal,
                'flat_discount_total' => $flatDiscountTotal,
                'supplier_id' => $value['supplier_id'],
                'product_id' => $value['product_id'],
                'product_sku' => $value['product_sku'],
                'product_barcode' => $value['product_barcode'],
                'buy_rate' => $value['product_buy_price'],
                'sale_rate' => $value['product_sell_price'],
                'quantity' => $value['quantity'],
                'product_total' => $value['total_price'],
                'net_total' => $netTotal,
            ];
            $sale_detail->fill($sale_product)->save();
            //Quantity Wise Stock Change
            Stock::query()
                ->userBranch($sale->branch_id)
                ->stockProduct()
                ->where('product_id', $value['product_id'])
                ->where('product_barcode', $value['product_barcode'])
                ->orderBy('purchase_id', 'asc')
                ->when($value['offer_id'] !== null, function ($query) use ($value) {
                    $query->where('offer_id', $value['offer_id']);
                })
                ->when($value['offer_id'] === null, function ($query) {
                    $query->whereNull('offer_id');
                })
                ->limit($value['quantity'])
                ->update([
                    'stock_status' => Stock::STATUS['Sale'],
                    'sale_id' => $sale->id,
                    'sale_detail_id' => $sale_detail->id,
                ]);
        }
        //        dd($vats,collect($vats)->sum('vatTotal'),collect($vats)->sum('discountTotal'));
    }
}
