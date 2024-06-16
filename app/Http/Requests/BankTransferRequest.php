<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankTransferRequest extends FormRequest
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
    public function rules()
    {
        return [
            'designation' => 'required',
            'user_id' => 'required',
            'paid' => 'required|gt:0',
            'sender_bank_id' => 'required',
            'receiver_bank_id' => 'required',
            'payable_amount' => 'required|gt:0',
            'due' => 'required|min:0',
        ];
    }
}
