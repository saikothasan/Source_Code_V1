<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'selectedEmployee'=>'required',
            'note'=>'required',
            'amount' => 'required|numeric|min:0|not_in:0',
        ];
    }
    public function messages(): array
    {
       return [
           'selectedEmployee.required' => 'Select a employee',
           'note.required'=> 'Note is required',
           'amount.required'=> 'Amount is required',
       ];
    }
}
