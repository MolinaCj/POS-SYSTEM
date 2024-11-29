<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxRateRequest extends FormRequest
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
            'taxRate' => 'required|numeric|min:0', // Ensure it's a valid positive number
        ];
    }

    public function messages()
    {
        return [
            'taxRate.required' => 'The tax rate field is required.',
            'taxRate.numeric' => 'The tax rate must be a number.',
            'taxRate.min' => 'The tax rate must be a positive number.',
        ];
    }
}
