<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleInvoiceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invoice_code' => 'required|exists:sales'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'invoice_code.exists' => 'Invoice Not Found'
        ];
    }
}
