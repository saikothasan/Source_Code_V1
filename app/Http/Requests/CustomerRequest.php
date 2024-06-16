<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|max:11|unique:customers,phone,' . $this->route('customer.id'),
            'photo' => 'mimes:jpeg,jpg,png,gif|max:1999|nullable',
            'address' => 'string|nullable',
            'district_id' => 'required',
            'email' =>  'string|nullable',
            'facebook_id'=> 'string|nullable',
        ];
    }
}
