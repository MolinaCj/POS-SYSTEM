<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'total_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'reference_no' => 'required|string|max:255',
        ];
    }
}
