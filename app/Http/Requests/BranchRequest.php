<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|unique:branches,name,' . $this->route('branch.id'),
            'email' => 'filled|unique:branches,email,' . $this->route('branch.id'),
            'email' => 'filled|unique:users,email,' . $this->route('branch.id'),
            'password' => 'filled|string|min:6',
            'branch_id' => 'required|unique:branches,branch_id,' . $this->route('branch.id'),
            'branch_id' => 'required|unique:users,username,' . $this->route('branch.id'),
            'address' => 'required',
            'phone_number' => 'required',
            'is_main_branch' => 'nullable',
            'weekend' => 'nullable',
            // 'open_time' => 'required',
            // 'close_time' => 'required',
            'status' => 'nullable',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
