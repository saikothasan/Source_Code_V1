<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invoice_code' => 'required|unique:transfer_receives,invoice_code',
            'date' => 'required',
            'receive_branch' => 'required',
            'totalQuantity' => 'required|numeric|min:1',
            'total_transfer' => 'required|numeric',
            'transfer_products' => 'required|array',
            'transfer_products.*' => 'required|array',
            'transfer_products.*.available_stock' => 'required|numeric|min:1',
            'transfer_products.*.quantity' => 'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {
       return [
           'receive_branch.required' => 'Select send branch',
           'transfer_products.required' => 'Please add product for transfer',
           'transfer_products.*.available_stock.min' => 'Product Stock Out',
           'transfer_products.*.quantity.min' => 'Product quantity required',
       ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
