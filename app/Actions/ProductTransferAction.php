<?php

namespace App\Actions;

use App\Http\Requests\ProductTransferRequest;
use App\Model\Branch;
use App\Model\Stock;
use App\Model\TransferReceive;
use App\Model\TransferReceiveDetail;

class ProductTransferAction
{
    public function handle(ProductTransferRequest $request): TransferReceive
    {
        $branch_id = auth()->user()->branch_id;
        if (isSupplier()) {
            $main_branch = getMainBranch();
            $branch_id = $main_branch->id;
            $supplier_id = supplierAuth()->supplier->id;
        }

        $transfer = new TransferReceive();
        $userId = auth()->user()->id;
        $data = [
            'date' => date('Y-m-d', strtotime($request->date)),
            'invoice_code' => $request->invoice_code,
            'invoice_type' => TransferReceive::INVOICE_TYPE['transfer'],
            'user_id' => $userId,
            'subtotal' => $request->total_transfer,
            'total' => $request->total_transfer,
            'total_quantity' => $request->totalQuantity,
            'supplier_id' => $supplier_id ?? null,
            'transfer_branch' => $branch_id,
            'receive_branch' => $request->receive_branch,
            'main_branch' => isset($main_branch->is_main_branch) ? $branch_id : null,
            'status' => TransferReceive::STATUS['Transferring'],
        ];
        $transfer->fill($data)->save();

        foreach ($request->transfer_products as $value) {
            $transferReceiveDetail = new TransferReceiveDetail();
            $details = [
                'date' => $transfer->date,
                'invoice_code' => $transfer->invoice_code,
                'transfer_invoice_id' => $transfer->id,
                'user_id' => $userId,
                'product_id' => $value['product_id'],
                'product_sku' => $value['variation_sku'],
                'product_barcode' => $value['product_barcode'],
                'supplier_id' => $value['supplier_id'],
                'main_branch' => $value['main_branch'],
                'transfer_branch' => $branch_id,
                'quantity' => $value['quantity'],
                'rate' => $value['product_buy_price'],
                'total' => $value['total_price'],

            ];
            $transferReceiveDetail->fill($details)->save();
            Stock::stockProduct()
                ->userBranch($branch_id)
                ->when(isSupplier(), function ($query) {
                    $query->where('supplier_id', supplierAuth()->supplier->id);
                })
                ->where('product_barcode', $value['product_barcode'])
                ->limit($value['quantity'])
                ->update([
                    'stock_status' => Stock::STATUS['TransferHold'],
                    'transfer_id' => $transfer->id,
                    'current_branch' => null,
                ]);
        }

        return $transfer;

    }
}
