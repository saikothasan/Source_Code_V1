<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => 'mimes:jpeg,jpg,png,gif|max:1999|nullable',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:20|unique:users,username,'.$this->route('user.id'),
            'email' => 'required|email|max:255|unique:users,email,'.$this->route('user.id'),
            'section' => 'required',
            'designation' => 'nullable',
            'phone' => 'required|unique:users,phone,'.$this->route('user.id'),
            'address' => 'nullable',
            'password' => 'string|min:8|confirmed',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
