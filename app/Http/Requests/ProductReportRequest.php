<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_date' => 'required',
            'to_date' => 'required',
            'product' => 'required',
            'selectedBranch' => 'required',
            'selectedPiece' => 'required',
            'selectedReportMode' => 'required',
            'report_file_mode' => 'required',
            'description' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
