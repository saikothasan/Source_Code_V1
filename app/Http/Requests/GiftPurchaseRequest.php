<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftPurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'date' => 'required|date',
            'receive_by' => 'required',
            'send_by' => 'required',
            'invoice' => 'required|unique:purchases,invoice',
            'purchase_products' => 'required|array',
        ];
    }
    public function messages() : array
    {
        return [
            'send_by.required' => 'Send name is required',
            'receive_by.required' => 'Receive name is required',
            'purchase_products.required' => 'Please add product for purchase',
        ];

    }
}
