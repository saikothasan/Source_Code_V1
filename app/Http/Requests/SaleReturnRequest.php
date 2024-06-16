<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleReturnRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'main_invoice' => 'required',
            'return_products' => 'required|array'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'main_invoice.required' => 'Invoice is required',
            'return_products.required' => 'Return product is required',
        ];
    }
}
