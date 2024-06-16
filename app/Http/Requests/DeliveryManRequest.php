<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DeliveryManRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        $id = $this->route()->parameter('delivery_man.id');
        return [
            "name"         => "required",
            "delivery_charge" => "required|numeric",
            "phone"  => [
                "required",
                Rule::unique('delivery_men', 'phone')->ignore($id),
            ],
            "nid"  => [
                "required",
                Rule::unique('delivery_men', 'nid')->ignore($id),
            ],
            'address' => 'required',
            'delivery_area' => 'required',
        ];
    }
}
