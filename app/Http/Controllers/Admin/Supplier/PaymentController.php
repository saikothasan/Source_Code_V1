<?php

namespace App\Http\Controllers\Admin\Supplier;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\Model\Stock;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request)
    {
        try {
            $purchaseId = collect($request)->pluck('id');
            $supplierId = collect($request)->pluck('supplier_id');

            $purchase = Purchase::query()
                ->whereIn('id', $purchaseId)
                ->whereIn('supplier_id', $supplierId)
                ->withSum('purchaseDue','due_total')
                ->withSum('purchaseDue','paid_total')
                ->withSum('purchasePayments as advanced_payment','total_pay')
                ->with(['stocks' => function($q) {
                    $q->where('stock_status', Stock::STATUS['Sale'])
                        ->whereNotNull('sale_id')
                        ->whereNotNull('sale_detail_id')
                        ->with('saleDetails');
                }])
                ->get()
                ->map(function ($data) {
                    return [
                        'id' => $data->id,
                        'invoice' => $data->invoice,
                        'total_payable' => collect($data->stocks)->sum('saleDetails.buy_rate'),
                        'due_total' => $data->purchase_due_sum_due_total,
                        'paid_total' => $data->purchase_due_sum_paid_total,
                        'advance_payment' =>  (int) $data->advanced_payment,
                        'pay_amount' => '',
                  ];
                });


            return $this->respondSuccess($purchase, 'Payable amounts fetched successfully');
        } catch (\Throwable $exception) {
            return $this->respondError('Something went wrong');
        }
    }
}
