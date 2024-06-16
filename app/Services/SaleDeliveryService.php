<?php

namespace App\Services;


use App\Constant\Constant;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\BranchPaymentMethod;
use App\Model\BranchPaymentMethodHistory;
use App\Model\Sale;
use App\Model\SaleDelivery;
use App\Model\User;
use Illuminate\Http\Request;


class SaleDeliveryService
{

    public static function saleDeliveryList(Request $request): array
    {

        $saleDelivery = SaleDelivery::query()
            ->search($request->get('search'))
            ->filterByDate($request->get('from-date'), $request->get('to-date'))
            ->filterBySeller($request->get('seller'))
            ->where('order_status', SaleDelivery::ORDER_STATUS['pending'])
            ->when(isBranch(), function ($query) {
                $query->where('branch_id', auth()->user()->branch_id);
            })
            ->when(isMainBranch(), function ($query) {
                $query->with('branch:id,name');
            })
            ->with([
                'deliveryMan:id,name',
                'sale.user:id,name',
                'sale.seller:id,name',
                'customer:id,name,phone',
            ])->with(['sale' => function ($query) {
                $query->withCount('saleDetails as total_items')->withSum('saleDetails as total_quantity', 'quantity');
            }]);

        $salesClone = $saleDelivery->newQuery()->get();
        $total_items = collect($salesClone)->pluck('sale')->sum('total_items');
        $total_quantity = collect($salesClone)->sum('sale.total_quantity');
        $total_sell = collect($salesClone)->sum('sale.final_total');


        $saleDelivery = $saleDelivery->orderBy('id', 'DESC')->paginate(100);
        return [
            'sale_delivery' => $saleDelivery,
            'total_items' => $total_items,
            'total_quantity' => $total_quantity,
            'total_sell' => $total_sell,
            'all_status' => Constant::DELIVERY_STATUS
        ];
    }

    public static function saleCODPayment($saleDelivery, $sale): void
    {
        $cod_payment = collect($sale->salePayment->payments)
            ->pluck('payment_method')
            ->where('text', 'COD')
            ->first();

        if (isset($cod_payment) && $cod_payment->text=='COD') {
            $branch_payment_method = BranchPaymentMethod::firstOrCreate(
                [
                    'payment_method_id' => $cod_payment->value,
                    'branch_id' => $sale->branch_id,
                ],
                [
                    'payment_method_id' =>  $cod_payment->value,
                    'branch_id' => $sale->branch_id,
                ]
            );
            $branch_payment_method->total_balance += $saleDelivery->amount_to_collect;
            $branch_payment_method->save();

            $branch_payment_history = new BranchPaymentMethodHistory();
            $branch_payment_history->date = date('Y-m-d');
            $branch_payment_history->type = BranchPaymentMethodHistory::TYPE['sale'];
            $branch_payment_history->invoice_reference = $sale->invoice_code;
            $branch_payment_history->sale_id = $sale->id;
            $branch_payment_history->branch_id = $sale->branch_id;
            $branch_payment_history->payment_method_id = $cod_payment->value;
            $branch_payment_history->payment_number = null;
            $branch_payment_history->payment_reference = null;
            $branch_payment_history->pay_amount = $saleDelivery->amount_to_collect;
            $branch_payment_history->payable_amount = $sale->payable_amount;
            $branch_payment_history->save();

            //Bank Amount Upload & History
            $bank_payment = Bank::query()
                ->where('account_no', Constant::PAYMENT_TYPE_ACCOUNT[$cod_payment->text] ?? '')
                ->first();
            if (isset($bank_payment)) {
                $bank_payment->amount += $saleDelivery->amount_to_collect;
                $bank_payment->save();
                $bankTransfer = new BankTransfer();
                $bankTransfer->type = 'Sale';
                $bankTransfer->date = date('Y-m-d');
                $bankTransfer->receiver_bank_id = $bank_payment->id;
                $bankTransfer->branch_id = $sale->branch_id;
                $bankTransfer->paid = $saleDelivery->amount_to_collect;
                $bankTransfer->connect_id = $sale->id;
                $bankTransfer->referance_invoice = json_encode($sale->invoice_code);
                $bankTransfer->status = BankTransfer::STATUS['Receive'];
                $bankTransfer->save();
            }
        }
    }

    public static function saleDeliveryCharge($saleDelivery, $sale): void
    {
        //Bank Amount Upload & History
        $bank_payment = Bank::query()
            ->where('account_no', Constant::PAYMENT_TYPE_ACCOUNT['COD'] ?? '')
            ->first();
        if (isset($bank_payment)) {
            $bank_payment->amount -= $saleDelivery->delivery_charge;
            $bank_payment->save();

            $bankTransfer = new BankTransfer();
            $bankTransfer->type = 'Sale';
            $bankTransfer->date = date('Y-m-d');
            $bankTransfer->receiver_bank_id = $bank_payment->id;
            $bankTransfer->branch_id = $sale->branch_id;
            $bankTransfer->paid = -$saleDelivery->delivery_charge;
            $bankTransfer->connect_id = $sale->id;
            $bankTransfer->referance_invoice = json_encode($sale->invoice_code);
            $bankTransfer->status = BankTransfer::STATUS['delivery_return'];
            $bankTransfer->save();
        }
    }
}
