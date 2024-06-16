<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\Branch;
use App\Model\BranchPaymentMethod;
use App\Model\BranchPaymentMethodHistory;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\Cost;
use App\Model\Purchase;
use App\Model\Purchase_detail;
use App\Model\PurchaseDue;
use App\Model\Sale;
use App\Model\SaleReturnDetail;
use App\Model\Stock;
use App\Model\TransferReceive;
use App\Model\TransferReceiveDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DataUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return string
     */
    public function __invoke(Request $request, $type)
    {

        try {
            DB::beginTransaction();
            $result = '';
            if ($type == 'sale') {
                $result = $this->saleDateUpdate();
            } elseif ($type == 'sale_return_buy_price') {
                $result = $this->saleReturnBuyPrice();
            } elseif ($type == 'cost') {
                $result = $this->costUpdate();
            } elseif ($type == 'purchase') {
                $result = $this->purchaseUpdate();
            } elseif ($type == 'sell_price_purchase') {
                $result = $this->purchaseSellPriceUpdate();
            } elseif ($type == 'stock_price') {
                $result = $this->stockPriceAdd();
            } elseif ($type == 'transfer') {
                $result = $this->transferUpdate();
            }

            DB::commit();
            Session::flash('message', 'Data Update Successfully!');
            return $result;

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }

    }


    private function transferUpdate()
    {
        $transfers = TransferReceive::query()->get();
        foreach ($transfers as $value) {
            TransferReceiveDetail::query()->whereTransferInvoiceId($value->id)->update(['transfer_branch' => $value->transfer_branch]);
        }
    }

    private function saleDateUpdate()
    {
        $sales = Sale::query()
            ->with('salePayments.paymentMethod')
            ->with('saleDelivery')
            ->get();

        foreach ($sales as $value) {
            $branch_id = $value->branch_id;
//            $bankTransfer  = BankTransfer::query()
//                ->whereType('Sale')
//                ->whereNull('branch_id')
//                ->where('connect_id', $value->id)
//                ->first();
//            if(isset($bankTransfer)) {
//                $bankTransfer->update(['branch_id' => $branch_id]);
//            }


            foreach ($value->salePayments as $payment) {
                ///Cash
                if ($payment->paymentMethod->name == 'Cash') {
                    $cash_drawer = CashDrawer::firstOrCreate(
                        [
                            'branch_id' => $branch_id,
                        ],
                        [
                            'name' => Branch::query()->where('id', $branch_id)->first()->name,
                            'amount' => 0.00,
                            'branch_id' => $branch_id,
                        ]
                    );


                    $cash_history = CashHistory::query()
                        ->where('cash_id', $cash_drawer->id)
                        ->where('branch_id', $branch_id)
                        ->where('cash_type', CashHistory::CASH_TYPE['sale'])
                        ->where('date', $payment->date)
                        ->where('sale_id', $value->id)
                        ->first();
                    if (!isset($cash_history)) {

                        $cash_drawer->amount += $payment->paid_total;
                        $cash_drawer->save();


                        $cash_history = new CashHistory();
                        $cash_history->cash_id = $cash_drawer->id;
                        $cash_history->branch_id = $branch_id;
                        $cash_history->cash_type = CashHistory::CASH_TYPE['sale'];
                        $cash_history->date = $payment->date;
                        $cash_history->amount = $payment->paid_total;
                        $cash_history->note = $value->invoice_code;
                        $cash_history->sale_id = $value->id;
                        $cash_history->save();
                    }

                }
                ///Cash


                if ($payment->paymentMethod->name != 'COD') {

                    $branch_payment_method = BranchPaymentMethod::firstOrCreate(
                        [
                            'payment_method_id' => $payment->paymentMethod->id,
                            'branch_id' => $branch_id,
                        ],
                        [
                            'payment_method_id' => $payment->paymentMethod->id,
                            'branch_id' => $branch_id,
                        ]
                    );


                    $branch_payment_first = BranchPaymentMethodHistory::query()
                        ->where('date', $payment->date)
                        ->where('type', BranchPaymentMethodHistory::TYPE['sale'])
                        ->where('sale_id', $value->id)
                        ->where('branch_id', $branch_id)
                        ->first();
                    if (!isset($branch_payment_first)) {
                        $branch_payment_method->total_balance += $payment->paid_total;
                        $branch_payment_method->save();

                        $branch_payment_history = new BranchPaymentMethodHistory();
                        $branch_payment_history->date = $payment->date;
                        $branch_payment_history->type = BranchPaymentMethodHistory::TYPE['sale'];
                        $branch_payment_history->invoice_reference = $value->invoice_code;
                        $branch_payment_history->sale_id = $value->id;
                        $branch_payment_history->branch_id = $branch_id;
                        $branch_payment_history->payment_method_id = $payment->paymentMethod->id;
                        $branch_payment_history->payment_number = $payment->payment_number ?? null;
                        $branch_payment_history->payment_reference = $payment->payment_reference ?? null;
                        $branch_payment_history->pay_amount = $payment->paid_total;
                        $branch_payment_history->payable_amount = $value->final_total;
                        $branch_payment_history->save();
                    }


                    //Bank Amount Upload & History
                    $bank_payment = Bank::query()
                        ->where('account_no', Constant::PAYMENT_TYPE_ACCOUNT[$payment->paymentMethod->name] ?? '')
                        ->first();

                    if (isset($bank_payment)) {

                        $bankTransfer_first = BankTransfer::query()
                            ->where('type', 'Sale')
                            ->where('connect_id', $value->id)
                            ->first();

                        if (!isset($bankTransfer_first)) {
                            $bank_payment->amount += $payment->paid_total;
                            $bank_payment->save();

                            $bankTransfer = new BankTransfer();
                            $bankTransfer->type = 'Sale';
                            $bankTransfer->date = $value->date;
                            $bankTransfer->receiver_bank_id = $bank_payment->id;
                            $bankTransfer->paid = $payment->paid_total;
                            $bankTransfer->connect_id = $value->id;
                            $bankTransfer->branch_id = $branch_id;
                            $bankTransfer->referance_invoice = json_encode($value->invoice_code);
                            $bankTransfer->status = BankTransfer::STATUS['Receive'];
                            $bankTransfer->save();
                        }

                    }
                }


                if ($payment->paymentMethod->name == 'COD' && isset($value->saleDelivery) && $value->saleDelivery->order_status == 1) {


                    $branch_payment_method = BranchPaymentMethod::firstOrCreate(
                        [
                            'payment_method_id' => $payment->paymentMethod->id,
                            'branch_id' => $branch_id,
                        ],
                        [
                            'payment_method_id' => $payment->paymentMethod->id,
                            'branch_id' => $branch_id,
                        ]
                    );


                    $branch_payment_first = BranchPaymentMethodHistory::query()
                        ->where('date', $payment->date)
                        ->where('type', BranchPaymentMethodHistory::TYPE['sale'])
                        ->where('sale_id', $value->id)
                        ->where('branch_id', $branch_id)
                        ->first();
                    if (!isset($branch_payment_first)) {
                        $branch_payment_method->total_balance += $payment->paid_total;
                        $branch_payment_method->save();

                        $branch_payment_history = new BranchPaymentMethodHistory();
                        $branch_payment_history->date = $payment->date;
                        $branch_payment_history->type = BranchPaymentMethodHistory::TYPE['sale'];
                        $branch_payment_history->invoice_reference = $value->invoice_code;
                        $branch_payment_history->sale_id = $value->id;
                        $branch_payment_history->branch_id = $branch_id;
                        $branch_payment_history->payment_method_id = $payment->paymentMethod->id;
                        $branch_payment_history->payment_number = $payment->payment_number ?? null;
                        $branch_payment_history->payment_reference = $payment->payment_reference ?? null;
                        $branch_payment_history->pay_amount = $payment->paid_total;
                        $branch_payment_history->payable_amount = $value->final_total;
                        $branch_payment_history->save();
                    }


                    //Bank Amount Upload & History
                    $bank_payment = Bank::query()
                        ->where('account_no', Constant::PAYMENT_TYPE_ACCOUNT[$payment->paymentMethod->name] ?? '')
                        ->first();

                    if (isset($bank_payment)) {

                        $bankTransfer_first = BankTransfer::query()
                            ->where('type', 'Sale')
                            ->where('connect_id', $value->id)
                            ->first();

                        if (!isset($bankTransfer_first)) {
                            $bank_payment->amount += $payment->paid_total;
                            $bank_payment->save();

                            $bankTransfer = new BankTransfer();
                            $bankTransfer->type = 'Sale';
                            $bankTransfer->date = $value->date;
                            $bankTransfer->receiver_bank_id = $bank_payment->id;
                            $bankTransfer->paid = $payment->paid_total;
                            $bankTransfer->connect_id = $value->id;
                            $bankTransfer->branch_id = $branch_id;
                            $bankTransfer->referance_invoice = json_encode($value->invoice_code);
                            $bankTransfer->status = BankTransfer::STATUS['Receive'];
                            $bankTransfer->save();
                        }

                    }


                }


            }

        }
    }


    private function purchaseUpdate()
    {

        $purchase = Purchase::query()->get();
        foreach ($purchase as $value) {
            $PurchaseDue = PurchaseDue::where('purchase_id', $value->id)->first();
            if (isset($PurchaseDue)) {
                $PurchaseDue->update(['total_amount' => $value->total]);
            }

        }
    }

    private function purchaseSellPriceUpdate()
    {
        $purchase_details = Purchase_detail::query()->with(['product', 'productVariations'])->get();
        foreach ($purchase_details as $detail_value) {
            if ($detail_value->product->product_options && $detail_value->productVariations) {
                $detail_value->update(['sell_price' => $detail_value->productVariations->variant_price]);
            }
            if (!$detail_value->product->product_options) {
                $detail_value->update(['sell_price' => $detail_value->product->sell_price]);
            }
        }

        return 'Data Update successfully';

    }


    private function saleReturnBuyPrice()
    {
        $sale_returns = SaleReturnDetail::query()->get();
        foreach ($sale_returns as $value) {
            $purchase = Purchase_detail::query()->where('product_barcode', $value['product_barcode'])->first();
            if (isset($purchase)) {
                $value->update(['buy_rate' => $purchase->rate]);
            }

        }

    }

    private function stockPriceAdd()
    {
        $stocks = Stock::query()->with(['product', 'productVariations'])->get();
        foreach ($stocks as $stock) {
            if ($stock->product->product_options && $stock->productVariations) {
                $stock->update([
                    'sell_price' => $stock->productVariations->variant_price,
                    'buy_price' => $stock->productVariations->variant_buy_price,
                ]);
            }
            if (!$stock->product->product_options) {
                $stock->update([
                    'sell_price' => $stock->product->sell_price,
                    'buy_price' => $stock->product->buy_price,
                ]);
            }
        }

        return 'Stock Data Update successfully';

    }

    private function costUpdate()
    {

        $cash_history = CashHistory::query()
            ->where('cash_type', CashHistory::CASH_TYPE['cost'])
            ->get();

        foreach ($cash_history as $value) {
            $cost = Cost::query()->where('id', $value->cash_id)->first();
            if (isset($cost)) {
                $cash_drawer = CashDrawer::query()->where('branch_id', $cost->branch_id)->first();
                if (isset($cash_drawer)) {
                    $value->update([
                        'cash_id' => $cash_drawer->id,
                        'cost_id' => $cost->id
                    ]);

                }

            }


        }


    }

}
