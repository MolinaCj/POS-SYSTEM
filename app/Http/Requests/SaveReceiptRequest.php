<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveReceiptRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reference_no' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric',
            'items.*.total_price' => 'required|numeric',
            'net_amount' =>['required','regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'tax' =>['required','regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'amount_payable' => ['regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
            'cash_amount' => 'required|numeric',
            'change_amount' => ['regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
        ];
    }
}
