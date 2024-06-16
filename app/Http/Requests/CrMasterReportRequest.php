<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrMasterReportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from_date' => 'required',
            'to_date' => 'required',
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
