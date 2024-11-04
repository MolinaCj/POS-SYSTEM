<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'barcode' => 'required|string|unique:products,barcode,' . $this->product,
            'item_name' => 'required|string|max:255',
            'category' => 'required|string',
            'stocks' => 'required|integer|min:0',
            // 'price' => 'required|numeric',
            'price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/', 'min:0'],
        ];
    }
}
