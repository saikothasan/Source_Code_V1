<?php

namespace App\Actions\Sale;

use App\Model\Sale_payment;
use App\Model\SalePaymentHistory;

class SalePaymentAction
{
    public function handle($request,$sale): void
    {
        $sale_payment = new Sale_payment();

        $sale_payment_data = [
            'date' => $sale->date,
            'sale_id' => $sale->id,
            'payable_amount' => $sale->payable_amount,
            'paid' => $sale->pay_amount,
            'due' => $sale->due_total,
            'change_amount' => $sale->change_amount,
            'user_id' => $sale->user_id,
            'customer_id' => $sale->customer_id,
            'payments' => $request->get('sale_payments'),
            'branch_id' => $sale->branch_id,
        ];

        $sale_payment->fill($sale_payment_data)->save();

        foreach ($request->get('sale_payments') as $value) {
            $sale_payment_history = new SalePaymentHistory();
            $branch_payment = new BranchPaymentStoreAction();

            $paid_total = $value['pay_amount'];
            $change_amount = 0.00;
            if ($request->change_amount > 0) {
                if ($value['payment_method']['text'] === 'Cash') {
                    $paid_total = ($value['pay_amount'] - $request->change_amount);
                    $change_amount = $request->change_amount;
                }
            }

            $sale_payment_data = [
                'date' => $sale->date,
                'sale_id' => $sale->id,
                'sale_payment_id' => $sale_payment->id,
                'payable_amount' => $sale->payable_amount,
                'branch_id' => $sale->branch_id,
                'pay_amount' => $value['pay_amount'],
                'paid_total' => $paid_total,
                'due' => $sale->due_total,
                'change_amount' => $change_amount,
                'user_id' => $sale->user_id,
                'customer_id' => $sale->customer_id,
                'payment_method_id' => $value['payment_method']['value'],
                'payment_number' => $value['payment_number'] ?? null,
                'payment_reference' => $value['payment_reference'] ?? null,
            ];
            $sale_payment_history->fill($sale_payment_data)->save();
            $branch_payment->execute($value,$paid_total,$sale);
        }
    }
}
