<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'selectedBranch.id' => 'required',
            'selectPaymentMethod' => 'required',
            'note' => 'required',
            'selectedBank.account_no'=>'required_if:selectPaymentMethod,7',
            'amount' => 'required|numeric|min:0|not_in:0',
        ];
    }
    public function messages(): array
    {
        return [
            'selectedBranch.id.required' => 'Select a Branch',
            'selectPaymentMethod.required' =>'Payment Method is required',
            'selectedBank.account_no.required_if' =>'Select a Bank Account',
            'note.required' => 'Note is Required',
            'amount.required' =>'Amount is required',
        ];
    }
}
