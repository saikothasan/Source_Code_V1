<?php

namespace App\Actions;

use App\Http\Requests\BankTransferRequest;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\PaymentMethod;
use App\Model\PurchaseDue;
use App\Model\PurchasePayment;
use App\Model\PurchasePaymentInvoice;
use App\Model\Supplier;
use App\Services\SupplierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupplierBankPayment
{
    /**
     * @throws \Throwable
     */
    public function execute(BankTransferRequest $request): PurchasePayment
    {

        DB::beginTransaction();
        $validator = Validator::make([], []);
        $bank = PaymentMethod::where('name', 'Bank')->first();
        if (empty($bank)) {
            $validator->errors()->add('bank', 'Please Create PaymentMethod Bank!');
            throw new ValidationException($validator);
        } else {
            $bankId = $bank->id;
        }

        $update_send_bank = Bank::find($request->sender_bank_id);
        if ((int)$update_send_bank->amount < $request->paid) {
            $validator->errors()->add('paid', 'Amount cant be greater than Bank Amount!');
            throw new ValidationException($validator);
        }


        $user_id = $request->user_id;
        $supplier = Supplier::where('user_id', $user_id)->firstOrFail();

        $bankTransfer = new BankTransfer();
        $purchasePayment = new PurchasePayment();
        $purchaseDue = new PurchaseDue();

        $purchases = (new SupplierService())->purchasePayableAmount($supplier);
        $purchases = collect($purchases)->where('total_payable', '>', 0);
        $data = [
            'date' => date('Y-m-d'),
            'receipt_no' => $purchasePayment->generateReceiptCode($supplier),
            'total_buy_price' => collect($purchases)->sum('data.total'),
            'total_advance' => collect($purchases)->sum('data.advanced_payment'),
            'total_pay' => $request->paid,
            'total_due' => $request->due,
            'user_id' => auth()->id(),
            'supplier_id' => $supplier->id,
            'payment_method_id' => $bankId,
            'payment_number' => null,
            'payment_reference' => $request->receiver_bank_id,
        ];

        $purchasePayment->fill($data)->save();

        $pay_amount = $request->paid;
        $invoice = [];
        foreach ($purchases as $purchase) {
            $purchaseDue = $purchaseDue->where('purchase_id', $purchase['data']['id'])->first();

            $temp = $pay_amount - $purchase['total_payable'];
            if ($temp < 0) {
                $invoice[] = [
                    'purchase_payments_id' => $purchasePayment->id,
                    'purchase_id' => $purchase['data']['id'],
                    'purchase_invoice' => 'advance',
                    'total_pay' => abs($pay_amount),
                    'total_due' => $purchase['total_payable'] - abs($pay_amount),
                ];

                $purchaseDue->update([
                    'paid_total' => $purchaseDue->paid_total + abs($pay_amount),
                    'due_total' => $purchaseDue->due_total - $purchase['total_payable'] - abs($pay_amount),
                ]);
                break;
            } else if ($temp > 0) {
                $invoice[] = [
                    'purchase_payments_id' => $purchasePayment->id,
                    'purchase_id' => $purchase['data']['id'],
                    'purchase_invoice' => $purchase['data']['invoice'],
                    'total_pay' => $purchase['total_payable'],
                    'total_due' => 0,
                ];
                $purchaseDue->update([
                    'paid_total' => $purchaseDue->paid_total + $purchase['total_payable'],
                    'due_total' => $purchaseDue->due_total - $purchase['total_payable'],
                ]);

                $pay_amount = abs($purchase['total_payable'] - abs($pay_amount));
            } else {
                $invoice[] = [
                    'purchase_payments_id' => $purchasePayment->id,
                    'purchase_id' => $purchase['data']['id'],
                    'purchase_invoice' => $purchase['data']['invoice'],
                    'total_pay' => abs($pay_amount),
                    'total_due' => 0,
                ];
                $purchaseDue->update([
                    'paid_total' => $purchaseDue->paid_total + abs($pay_amount),
                    'due_total' => $purchaseDue->due_total - abs($pay_amount),
                ]);
                break;
            }
        }
        $purchasePayment->purchase_invoice = json_encode(collect($invoice)->pluck('purchase_invoice')->unique()->toArray());
        $purchasePayment->purchase_id = json_encode(collect($invoice)->pluck('purchase_id')->unique());
        $purchasePayment->sender_bank_id = $request->sender_bank_id;
        $purchasePayment->receiver_bank_id = $request->receiver_bank_id;
        $purchasePayment->total_payable = $request->payable_amount;
        $purchasePayment->save();

        PurchasePaymentInvoice::insert($invoice);


        $bankTransfer->date = date('Y-m-d');
        $bankTransfer->type = 'supplier';
        $bankTransfer->paid = $request->paid;
        $bankTransfer->due = $request->due;
        $bankTransfer->user_id = $request->user_id;
        $bankTransfer->receiver_bank_id = $request->receiver_bank_id;
        $bankTransfer->sender_bank_id = $request->sender_bank_id;
        $bankTransfer->referance_invoice = json_encode(collect($invoice)->pluck('purchase_invoice'));
        $bankTransfer->connect_id = $purchasePayment->id;
        $bankTransfer->reference_id = $bankTransfer->generateSupplierReference($supplier);
        $bankTransfer->save();


        $update_send_bank->amount -= $request->paid;
        $update_send_bank->save();
        DB::commit();
        return $purchasePayment;
    }
}
