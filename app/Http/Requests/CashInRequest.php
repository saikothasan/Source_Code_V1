<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashInRequest extends FormRequest
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
            'note' => 'required',
            'employee' => 'required',
            'amount' => 'required|numeric|min:0|not_in:0',
        ];
    }
    public function message(): array
    {
        return [
            'note.required' => 'Note is required',
            'employee_id.required' => 'Select a employee',
            'amount.required' => 'Amount cant be null and must be greater than 0',
        ];
    }
}
