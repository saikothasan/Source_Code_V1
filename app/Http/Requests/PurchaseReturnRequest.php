<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'purchase_products' => 'required|array',
            'purchase_products.*.available_stock' => 'required|numeric|min:1',
            'purchase_products.*.return_quantity' => 'required|numeric|min:0',
            'total_return_quantity' => 'required|numeric|min:1',
            'total_return_amount' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'purchase_products.required' => 'Return Product required',
            'purchase_products.*.available_stock.min' => 'Product Stock Out',
            'purchase_products.*.return_quantity.min' => 'Return quantity required',
            'purchase_products.*.return_quantity.required' => 'Return quantity required',
            'total_return_quantity.min' => 'Return quantity required',
            'total_return_amount.min' => 'Return amount required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
