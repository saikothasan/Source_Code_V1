<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'from_date' => 'required',
            'to_date' => 'required',
            'sender_bank_id' => 'required',
            'receiver_bank_id' => 'required',
            'total_pay' => 'required|numeric|min:1',
            'purchase_data.*.pay_amount' => 'required|numeric|min:1',
            'purchase_data' => 'required|array',
        ];
    }
    public  function  messages(): array
    {
        return [
            'paymentMethod.required' => 'Select a Payment Method',
            'total_pay.required' => 'Payment Amount is required',
            'total_pay.min' => 'Payment Amount is required',
            'purchase_data.*.pay_amount.required' => 'Payment Amount is required',
            'purchase_data.*.pay_amount.min' => 'Payment Amount is required',
            'purchase_data.required' => 'Select invoice',
        ];
    }
}
