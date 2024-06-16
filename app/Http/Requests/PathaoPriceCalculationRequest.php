<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PathaoPriceCalculationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'store_id' => 'required',
            'item_type' => 'required',
            'delivery_type' => 'required',
            'item_weight' => 'required|numeric|gt:0.1|max:50',
            'recipient_city' => 'required',
            'recipient_zone' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
