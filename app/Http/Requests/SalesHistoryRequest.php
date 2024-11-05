<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'transactions' => 'required|array',
            'transactions.*.item_name' => 'required|string',
            'transactions.*.quantity' => 'required|integer|min:1',
            'transactions.*.unit_price' => 'required|numeric',
            'transactions.*.total_price' => 'required|numeric',
            'amount_payable' => ['regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'cash_amount' => 'required|numeric',
            'change_amount' => ['regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'unit_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'total_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'reference_no' => 'required|string|max:255',
            'change' => ['regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
        ];
    }
}
