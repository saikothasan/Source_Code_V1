<?php

namespace App\Actions\Sale;

use App\Constant\Constant;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\Branch;
use App\Model\CashDrawer;
use App\Model\CashHistory;
use App\Model\BranchPaymentMethod;
use App\Model\BranchPaymentMethodHistory;

class BranchPaymentStoreAction
{
    public function execute($payment, $amount, $sale): void
    {
        $branch_id = auth()->user()->branch_id;
        if ($payment['payment_method']['text'] == 'Cash') {
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
            $cash_drawer->amount += $amount;
            $cash_drawer->save();
            $cash_history = new CashHistory();
            $cash_history->cash_id = $cash_drawer->id;
            $cash_history->branch_id = $branch_id;
            $cash_history->cash_type = CashHistory::CASH_TYPE['sale'];
            $cash_history->date = date('Y-m-d');
            $cash_history->amount = $amount;
            $cash_history->note = $sale->invoice_code;
            $cash_history->sale_id = $sale->id;
            $cash_history->save();
        }
        if ($payment['payment_method']['text'] != 'COD') {
            $branch_payment_method = BranchPaymentMethod::firstOrCreate(
                [
                    'payment_method_id' => $payment['payment_method']['value'],
                    'branch_id' => $branch_id,
                ],
                [
                    'payment_method_id' => $payment['payment_method']['value'],
                    'branch_id' => $branch_id,
                ]
            );
            $branch_payment_method->total_balance += $amount;
            $branch_payment_method->save();

            $branch_payment_history = new BranchPaymentMethodHistory();
            $branch_payment_history->date = date('Y-m-d');
            $branch_payment_history->type = BranchPaymentMethodHistory::TYPE['sale'];
            $branch_payment_history->invoice_reference = $sale->invoice_code;
            $branch_payment_history->sale_id = $sale->id;
            $branch_payment_history->branch_id = $branch_id;
            $branch_payment_history->payment_method_id = $payment['payment_method']['value'];
            $branch_payment_history->payment_number = $payment['payment_number'] ?? null;
            $branch_payment_history->payment_reference = $payment['payment_reference'] ?? null;
            $branch_payment_history->pay_amount = $amount;
            $branch_payment_history->payable_amount = $sale->payable_amount;
            $branch_payment_history->save();

            //Bank Amount Upload & History
            $bank_payment = Bank::query()
                ->where('account_no', Constant::PAYMENT_TYPE_ACCOUNT[$payment['payment_method']['text']] ?? '')
                ->first();
            if (isset($bank_payment)) {
                $bank_payment->amount += $amount;
                $bank_payment->save();
                $bankTransfer = new BankTransfer();
                $bankTransfer->type = 'Sale';
                $bankTransfer->date = date('Y-m-d');
                $bankTransfer->receiver_bank_id = $bank_payment->id;
                $bankTransfer->paid = $amount;
                $bankTransfer->connect_id = $sale->id;
                $bankTransfer->branch_id = $sale->branch_id;
                $bankTransfer->referance_invoice = json_encode($sale->invoice_code);
                $bankTransfer->status = BankTransfer::STATUS['Receive'];
                $bankTransfer->save();
            }
        }
    }
}
