<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleReportRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'selectedBranch' => 'required',
            'selectedCategory' => 'required',
            'selectedSupplier' => 'required',
            'selectedBrand' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'selectedReportMode' => 'required',
            'report_file_mode' => 'required',
            'description' => 'required',
        ];
    }
}
