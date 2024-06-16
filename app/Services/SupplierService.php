<?php

namespace App\Services;

use App\Model\BankTransfer;
use App\Model\Purchase;
use App\Model\PurchasePayment;
use App\Model\SaleDelivery;
use App\Model\Stock;
use Illuminate\Database\Eloquent\Builder;


class SupplierService
{
    public static function purchasePaymentInvoice($id)
    {
        return PurchasePayment::where('id', $id)
            ->with(['supplier', 'supplierBank:id,name,account_no'])
            ->first();
    }

    public function purchasePayableAmount($supplier): \Illuminate\Support\Collection
    {
        return Purchase::query()
            ->where('supplier_id', $supplier['id'])
            ->withCount(['stocks as total_sell' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id');
            }])
            ->withCount('purchaseDetails')
            ->having('total_sell', '>', '0')
            ->withSum('purchaseDue', 'due_total')
            ->withSum('purchaseDue', 'paid_total')
            ->withSum(['purchasePayments as advanced_payment' => function ($query) {
                $query->whereDoesntHave('bankHistory', function ($q) {
                    $q->where('status', BankTransfer::STATUS['Reject']);
                });
            }], 'total_pay')
            ->withSum(['stocks as sales_product_purchase_price' => function ($query) {
                $query->where('stock_status', Stock::STATUS['Sale'])
                    ->whereNotNull('sale_id')
                    ->whereNotNull('sale_detail_id')
                    ->deliveredSale('sales.saleDeliveries');
            }], 'buy_price')
//            ->with(['stocks' => function ($q) {
//                $q->where('stock_status', Stock::STATUS['Sale'])
//                    ->whereNotNull('sale_id')
//                    ->whereNotNull('sale_detail_id')
//                    ->with('saleDetails')
//                    ->whereDoesntHave('saleDetails.sale.saleDelivery', function ($q) {
//                        $q->whereIn('order_status',
//                            [
//                                SaleDelivery::ORDER_STATUS['pending'],
//                                SaleDelivery::ORDER_STATUS['returned'],
//                                SaleDelivery::ORDER_STATUS['cancelled']
//                            ]);
//                    })->whereDoesntHave('saleDetails.exchange.exchangeDelivery', function ($q) {
//                        $q->whereIn('order_status',
//                            [
//                                SaleDelivery::ORDER_STATUS['pending'],
//                                SaleDelivery::ORDER_STATUS['returned'],
//                                SaleDelivery::ORDER_STATUS['cancelled']
//                            ]);
//                    });
//            }])
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($data) {
                //$amount = (int)collect($data->stocks)->sum('saleDetails.buy_rate') - (int)$data->advanced_payment;
                $amount = (int)$data->sales_product_purchase_price - (int)$data->advanced_payment;
                if ($amount < 0) {
                    $amount = 0;
                }
                return [
                    'data' => $data,
                    'total_payable' => $amount,
                ];
            });
    }

}
