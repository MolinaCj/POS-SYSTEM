<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //'employee_id' => 'required|string|max:255|unique:employees,employee_id', // Unique employee_id
            'employee_name' => 'required|string|max:255', // Employee name
            'username' => 'required|string|max:191|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email', // Unique email
            'email_verified_at' => 'nullable|date', // Nullable date for email verification
            'password' => 'required|string|min:8|confirmed', // Password with confirmation field
            'remember_token' => 'nullable|string|max:100', // Optional remember_token
        ];
    }

    public function messages()
    {
        return [
            // 'employee_id.required' => 'The employee ID is required.',
            'employee_id.unique' => 'This employee ID is already taken.',
            'employee_name.required' => 'The employee name is required.',
            'username.unique' => 'The username already exist',
            'email.required' => 'The email address is required.',
            'email.unique' => 'This email is already registered.',
            'email_verified_at.date' => 'The email verification date must be a valid date.',
            'password.required' => 'The password is required.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
