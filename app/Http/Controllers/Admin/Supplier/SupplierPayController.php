<?php

namespace App\Http\Controllers\Admin\Supplier;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierPaymentRequest;
use App\Model\Bank;
use App\Model\BankTransfer;
use App\Model\PaymentMethod;
use App\Model\PurchaseDue;
use App\Model\PurchasePayment;
use App\Model\PurchasePaymentInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupplierPayController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param SupplierPaymentRequest $request
     *
     */
    public function __invoke(SupplierPaymentRequest $request, PurchasePayment $purchasePayment, PurchaseDue $purchaseDue)
    {
            $validator = Validator::make([], []);
            $update_send_bank = Bank::findOrFail($request->sender_bank_id);
            if ((int)$update_send_bank->amount < $request->total_pay) {
                $validator->errors()->add('sender_bank_id', 'Amount cant be greater than Bank Amount!');
                throw new ValidationException($validator);
            }

            $bank = PaymentMethod::where('name', 'Bank')->first();

            if (empty($bank)) {
                $validator->errors()->add('bank', 'Please Create PaymentMethod Bank!');
                throw new ValidationException($validator);
            } else {
                $bankId = $bank->id;
            }
            DB::beginTransaction();
            $data = [
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'date' => date('Y-m-d'),
                'receipt_no' => $purchasePayment->generateReceiptCode($request->supplier),
                'purchase_invoice' => json_encode(collect($request->purchase_data)->pluck('invoice')->unique()->toArray()),
                'purchase_id' => json_encode(collect($request->purchase_data)->pluck('id')->unique()),
                'total_buy_price' => $request->total_price,
                'total_advance' => $request->total_advance,
                'total_pay' => $request->total_pay,
                'total_due' => $request->total_due,
                'total_payable' => $request->total_payable,
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier['id'],
                'payment_method_id' => $bankId,
                'payment_number' => null,
                'payment_reference' => $request->sender_bank_id,
                'sender_bank_id' => $request->sender_bank_id,
                'receiver_bank_id' => $request->receiver_bank_id,
            ];
            $purchasePayment->fill($data)->save();
            foreach ($request->purchase_data as $purchase) {
                $invoice[] = [
                    'purchase_payments_id' => $purchasePayment->id,
                    'purchase_id' => $purchase['id'],
                    'purchase_invoice' => $purchase['invoice'],
                    'total_pay' => $purchase['pay_amount'],
                    'total_due' => $purchase['due_amount'],
                ];
                $purchaseDue = $purchaseDue->where('purchase_id', $purchase['id'])->first();

                $purchaseDue->update([
                        'paid_total' => $purchaseDue->paid_total + $purchase['pay_amount'],
                        'due_total' => $purchaseDue->due_total - $purchase['pay_amount'],
                    ]);
            }

            $update_send_bank->amount -= $request->total_pay;
            $update_send_bank->save();

            $bankTransfer = new BankTransfer();
            $bankTransfer->date = date('Y-m-d');
            $bankTransfer->paid = $request->total_pay;
            $bankTransfer->due = $request->total_due;
            $bankTransfer->sender_bank_id = $request->sender_bank_id;
            $bankTransfer->receiver_bank_id = $request->receiver_bank_id;
            $bankTransfer->type = "supplier";
            $bankTransfer->user_id = $request->supplier['user_id'];
            $bankTransfer->connect_id = $purchasePayment->id;
            $bankTransfer->referance_invoice = json_encode(collect($request->purchase_data)->pluck('invoice')->unique()->toArray());
            $bankTransfer->reference_id = $bankTransfer->generateSupplierReference($request->supplier);
            $bankTransfer->save();
            PurchasePaymentInvoice::insert($invoice);
            DB::commit();
            return view('components.supplier.payment-view', ['purchasePayment' => $purchasePayment->load('supplier')]);

    }
}
