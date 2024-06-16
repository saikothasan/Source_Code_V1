<?php

namespace App\Actions;

use App\Http\Requests\PurchaseRequest;
use App\Model\Branch;
use App\Model\Purchase;
use App\Model\Purchase_detail;
use App\Model\PurchaseDue;
use App\Model\Stock;

class PurchaseStoreAction
{
    public function handle(PurchaseRequest $request, Purchase $purchase): Purchase
    {
        $mainBranch = getMainBranch();
        $userId = auth()->user()->id;

        if (isSupplier()) {
            $sender_type = Purchase::SENDER_TYPE['supplier'];
        } else {
            $sender_type = Purchase::SENDER_TYPE['management'];
        }
        $data = [
            'date' => date('Y-m-d', strtotime($request->date)),
            'invoice' => $request->invoice,
            'supplier_id' => $request->supplier_id,
            'user_id' => $userId,
            'subtotal' => $request->totalPurchase,
            'total' => $request->totalPurchase,
            'total_quantity' => $request->totalQuantity,
            'send_by' => $request->send_by,
            'receive_by' => $request->receive_by,
            'product_margin' => $request->margin,
            'product_profit' => $request->profit,
            'main_branch' => $mainBranch->id,
            'sender_type' => $sender_type,
            'status' => Purchase::STATUS['pending'],
        ];
        $purchase->fill($data)->save();

        foreach ($request->purchase_products as $key => $value) {
            $purchaseDetail = new Purchase_detail();
            $details = [
                'date' => date('Y-m-d', strtotime($request->date)),
                'invoice' => $request->invoice,
                'user_id' => $userId,
                'purchase_id' => $purchase->id,
                'product_id' => $value['product_id'],
                'product_sku' => $value['variation_sku'],
                'product_barcode' => $value['product_barcode'],
                'supplier_id' => $value['supplier_id'],
                'main_branch' => $mainBranch->id,
                'quantity' => $value['quantity'],
                'rate' => $value['product_buy_price'],
                'sell_price' => $value['product_sell_price'],
                'total' => $value['total_price'],

            ];
            $purchaseDetail->fill($details)->save();
            $stock_data = [];
            for ($i = 1; $i <= $value['quantity']; $i++) {
                $stock_data[] = [
                    'purchase_id' => $purchase->id,
                    'purchase_details_id' => $purchaseDetail->id,
                    'product_id' => $value['product_id'],
                    'product_sku' => $value['variation_sku'],
                    'product_barcode' => $value['product_barcode'],
                    'buy_price' => $value['product_buy_price'],
                    'sell_price' => $value['product_sell_price'],
                    'user_id' => $userId,
                    'supplier_id' => $value['supplier_id'],
                    'main_branch' => $mainBranch->id,
                    'current_branch' => $mainBranch->id,
                    'stock_status' => Stock::STATUS['PurchasePending'],
                    'created_by' => $userId,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                ];
            }
            Stock::insert($stock_data);
        }

        $purchaseDue = new PurchaseDue();
        $purchaseDue->date = $purchase->date;
        $purchaseDue->purchase_invoice = $purchase->invoice;
        $purchaseDue->purchase_id = $purchase->id;
        $purchaseDue->user_id = $userId;
        $purchaseDue->supplier_id = $purchase->supplier_id;
        $purchaseDue->due_total = $purchase->total;
        $purchaseDue->total_amount = $purchase->total;
        $purchaseDue->save();

        return $purchase;
    }
}
