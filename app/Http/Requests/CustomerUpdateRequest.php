<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'name' => 'required|min:2|max:100',
            'email' => 'string|nullable',
            'phone' => 'nullable|max:11|regex:/(01)[0-9]{9}/',
            'date_of_birth' => 'string|nullable',
            'address' => 'string|nullable|min:2|max:255',
            'zip_code' => 'nullable|min:4|max:4',
            'facebook_id' => 'string|nullable',
            'photo' => 'mimes:jpeg,jpg,png,gif|max:1999|nullable',
        ];
    }
}
