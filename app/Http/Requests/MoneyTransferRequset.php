<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class MoneyTransferRequset extends FormRequest
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
    public function rules()
    {
        return [
            'selectedPaymentMethod.id' => 'required',
            'selectedReceiverType' => 'required',
            'selectedBank.id' => 'required_if:selectedReceiverType,Bank',
            'selectedCashDrawer.id' => 'required_if:selectedReceiverType,Cash Drawer',
            'transferAmount' => 'required|numeric|min:0|not_in:0',
        ];
    }

    public function messages(): array
    {
        return [
            'selectedPaymentMethod.id.required' => 'Select a Payment Method',
            'selectedReceiverType.required' => 'Select a Receiving Type',
            'selectedBank.id.required' => 'Select a Bank when Receiving Type is Bank',
            'selectedCashDrawer.id.required' => 'Select a Bank when Receiving Type is Bank',
            'transferAmount.required' => 'Select a Payment Method',
        ];
    }
}
