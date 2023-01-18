<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportsRequest extends FormRequest
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
            // 'exportDate'=> 'required|date|bail',
            'customerID' => 'required|min:1',
            'invoiceID' => 'required|min:1',
            'customerID' => 'required|not_in:0',
            'productID' => 'required|array',
            'productID.*' => 'required|numeric|integer|not_in:0|bail',
            'quantity' => 'required|array|min:1|bail',
            'quantity.*' => 'required|numeric|integer|min:1|bail',
        ];
    }
    public function messages()
    {
        return [
            'invoiceID.required'=>'Invoice ID cannot blank',
            'customerID.required'=>'Customer ID cannot blank',
            'productID.required'=>'Product ID cannot blank',
            'exportDate.required'=> '* Export Date cannot blank',
            'exportDate.date'=> '* Export Date is invalid !',
            'quantity.[*].required'=> 'Product quantity cannot blank',
            'quantity.[*].min'=> 'Product quantity cannot below 1',
            // 'quantity.numeric'=> 'Product quantity must be numeric and integer',
            // 'quantity.integer'=> 'Product quantity must be numeric and integer',
        ];
    }
}
