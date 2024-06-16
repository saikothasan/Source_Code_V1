<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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

            'name' => 'required',
            'phone' => 'required',
            'company' => 'required',
            'password' => 'string|min:6',
            'email' => 'required|email|max:255|unique:users,email,'.$this->route('user.id'),


        ];
    }
}
