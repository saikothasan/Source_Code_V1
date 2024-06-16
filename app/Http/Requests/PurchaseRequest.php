<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'supplier_id' => 'required',
            'receive_by' => 'required',
            'send_by' => 'required',
            'invoice' => 'required|unique:purchases,invoice',
            'purchase_products' => 'required|array',

        ];
    }

    public function messages(): array
    {
        return [
            'send_by.required' => 'Send name is required',
            'receive_by.required' => 'Receive name is required',
            'purchase_products.required' => 'Please add product for purchase',
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
